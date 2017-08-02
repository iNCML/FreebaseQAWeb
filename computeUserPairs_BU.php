<?php
// Connect to mysql
require_once("dbopen.php");

// Always produces 300 pairs
function generatePairsPerUser($username)
{
  $conn = returnConn();
  // Get array of article ids to select from
  $pairs = array_map('str_getcsv', file('articlePairs.csv'));
  // Overlap constant
  $overlap = 1.1;
  $numArticles = 2700 * $overlap;
  // Set so visible outside of loop
  $userCount = 0;
  // Get count, and create number of articles per user
  $countQuery = "select count(*) from `accDB`;";
  if ($result = mysqli_query($conn, $countQuery)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userCount = $row['count(*)'];
    }
  }

  // Determine number of articles per user
  // $articlesPerUser = $numArticles / $userCount;
  $articlesPerUser = 300;

  // if($articlesPerUser > 300)
  // {
  //   $articlesPerUser = 300;
  // }

  // Section of articles is based on when the user signed up
  // Signed up sooner get articles near the beginning

  $userIDQuery = "select `user_id` from `accDB` where username='$username';";
  $userID = 0;
  if ($result = mysqli_query($conn, $userIDQuery)){
    while ($row = mysqli_fetch_assoc($result)) {
        $userID = $row['user_id'];
    }
  }

  // Need to rank that ID against all other id's
  // So query all other ID's
  $getAlluserID = "select `user_id` from `accDB`;";
  $userIDs = array();
  if ($result = mysqli_query($conn, $getAlluserID)){
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($userIDs,$row['user_id']);
    }
  }

  // Sort the user IDs
  asort($userIDs);
  // Find relative index of current user
  $dex = array_search($userID, $userIDs);

  // 90% individual, 10% overlap
  $organizedChunk = $articlesPerUser * 0.9;
  $dexs = range(0,2700,$organizedChunk);

  // Load the users rated pairs, don't want repeated pairs
  $ratedPairs = loadRatedPairs($username);

  // Create range and append to current pairs
  $assignedChunkLower = $dexs[$dex];
  $assignedChunkHigher = $dexs[$dex+1];
  $currentPairs = array();
  for($i = $assignedChunkLower; $i < $assignedChunkHigher; $i++)
  {
    if(in_array($i,$ratedPairs) == false)
    {
        array_push($currentPairs,$i);
    }
  }

  // Check to make sure they haven't done this segement already
  // If they have generate the next segment and check if they've done that
  while((count(array_intersect($currentPairs,$ratedPairs)) == count($currentPairs)) || (count($currentPairs) == 0))
  {
    $segment = 2;
    // 90% individual, 10% overlap
    $organizedChunk = $articlesPerUser * 0.9;
    $dexs = range(0,2700,$organizedChunk);

    // Create range and append to current pairs
    $assignedChunkLower = $dexs[$dex + $segment];
    $assignedChunkHigher = $dexs[$dex + 1 + $segment];
    $currentPairs = array();
    for($i = $assignedChunkLower; $i < $assignedChunkHigher; $i++)
    {
      if(in_array($i,$ratedPairs) == false)
      {
          array_push($currentPairs,$i);
      }
    }
  }

  // Generate random numbers to append for the last 10% overlap

  $generatedNums = array();
  for($i = 0; $i<30; $i++)
  {
    $num =  rand( 0, count($pairs));
    while(in_array($num, $currentPairs) || in_array($num,$generatedNums) || in_array($num, $ratedPairs))
    {
      $num =  rand( 0, count($pairs));
    }
    array_push($currentPairs, $num);
    array_push($generatedNums, $num);
  }

  // echo count($currentPairs);
  insertIntoSQL($username, $currentPairs);
}

function loadRatedPairs($username)
{
  $conn = returnConn();
  // Load what pairs the user has rated
  // Remove articles already rated
  $allArtsRated = "select `pair_id` from `artRatings` where username='$username';";
  $ratedArts = array();
  if ($result = mysqli_query($conn, $allArtsRated)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($ratedArts,$row['pair_id']);
    }
  }
  // Get unique rated
  $uniqueRated = array_combine($ratedArts, $ratedArts);
  return $ratedArts;
}

function insertIntoSQL($username, $removedDone)
{
  $conn = returnConn();
  // Make into string
  $arrayIntoDB = serialize( $removedDone );
  // Update MySQL account
  $insertArray = "update `accDB` set `currentPairs` = '$arrayIntoDB' where username='$username';";
  mysqli_query($conn, $insertArray);
}


function updateCurrentPairsRemoveDone($username)
{
  $currentPairs = getUserPairs($username);
  // echo count($currentPairs);
  $ratedPairs = loadRatedPairs($username);

  $currentPairs = array_diff($currentPairs,$ratedPairs);
  // echo count($currentPairs);
  insertIntoSQL($username,$currentPairs);
}


function getUserPairs($username)
{
    $conn = returnConn();
    $selectPairs = "select `currentPairs` from accDB where username='$username';";
    $currentPairs;
    if ($result = mysqli_query($conn, $selectPairs)) {
      while ($row = mysqli_fetch_assoc($result)) {
          $currentPairs = unserialize($row['currentPairs']);
      }
    }
    return $currentPairs;
}

// generatePairsPerUser("q");
// updateCurrentPairsRemoveDone("p");
// $pairs = getUserPairs("p");
// print_r($pairs);
?>
