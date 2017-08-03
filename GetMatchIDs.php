<?php
require_once("ConnectDB.php");

function generateMatchIDsForUser($username)
{
    $matchesPerUser = 20000;
    //$conn = returnConn();

    $queryID = mysqli_prepare($conn, "SELECT `minID` FROM `FreebaseQA_Users` WHERE `minID` != null;");
    mysqli_stmt_execute($queryID);
    mysqli_stmt_store_result($queryID);
    $nID = mysqli_stmt_num_rows($queryID);

    $minID = $nID * $matchesPerUser;
    insertIntoSQL($username, $minID);
}

function insertIntoSQL($username, $minID)
{
    //$conn = returnConn();
    $insertArrayQuery = "UPDATE `FreebaseQA_User` SET `minID` = $minID WHERE `username` = '$username';";
    mysqli_query($conn, $insertArrayQuery);
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
