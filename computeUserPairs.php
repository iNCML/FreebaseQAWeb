<?php
// Connect to mysql
require_once("dbopen.php");

// Always produces 300 pairs
function generatePairsPerUser($username)
{
  $conn = returnConn();
  // Get array of article ids to select from
  $pairs = array_map('str_getcsv', file('articlePairs.csv'));
  // print_r($pairs);
  $articlesPerUser = 2700;

  // Load the users rated pairs, don't want repeated pairs
  //$ratedPairs = loadRatedPairs($username);

  // Create range and append to current pairs
  $currentPairs = array();
  for($i = 0; $i < 2700; $i++)
  {
    array_push($currentPairs,$i);
  }

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
  //echo(strlen($arrayIntoDB));
  // Update MySQL account
  $insertArray = "update `accDB` set `currentPairs` = '$arrayIntoDB' where username='$username';";
  mysqli_query($conn, $insertArray);
  //echo(mysqli_error ( $conn ));
}


function updateCurrentPairsRemoveDone($username)
{
  //$currentPairs = getUserPairs($username);
  $currentPairs = array();
  for($i = 0; $i < 2700; $i++)
  {
    array_push($currentPairs,$i);
  }
  //echo count($currentPairs);
  $ratedPairs = loadRatedPairs($username);
  
  $currentPairs = array_values(array_diff($currentPairs,$ratedPairs));
  
  insertIntoSQL($username,$currentPairs);
  $json = array();
  $json['numLeft']=count($currentPairs);
  return $json;
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

//generatePairsPerUser("atjoseph");
//updateCurrentPairsRemoveDone("t6");
// $pairs = getUserPairs("t");
// print_r($pairs);
?>
