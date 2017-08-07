<?php
session_start();

require_once('ConnectDB.php');

$matchesPerUser = 20000;

$username = $_SESSION["person"];

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);
$minID = $userInfo['minID'];
$currentID = $userInfo['currentID'];
$count = $userInfo['count'];

// if the current matchID goes past the last match in the table, start from the beginning again
$query = "SELECT * FROM `TEMP_Matches`;";
$result = mysqli_query($conn, $query);
$nMatches = mysqli_num_rows($result);

if ($currentID > $nMatches) {
    $currentID = 1;
    $query = "UPDATE `FreebaseQA_Users` SET `currentID` = $currentID WHERE `username` = '$username';";
    mysqli_query($conn, $query);
}

// if user gets to the end of their assigned range, look for skipped questions
$maxID = $minID + $matchesPerUser;
if ($currentID > $maxID) {
    $query = "SELECT * FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `matchID` > $minID AND `matchID` < $maxID AND `rating` = 3 LIMIT 1;"; // a rating of 3 is a deferred match
    $result = mysqli_query($conn, $query);
    $matchID = mysqli_fetch_assoc($result)['matchID']; 
    obtainInfo($matchID);
}
else {
    obtainInfo($currentID);
}

function obtainInfo($ID) {
    $query = "SELECT * FROM `TEMP_Matches` WHERE `matchID` = $ID;";
    $connection = returnConn();    
    if ($result = mysqli_query($connection, $query)) {
       $matchInfo = mysqli_fetch_assoc($result);
       $matchInfo['answer'] = ucwords($matchInfo['object']);
       echo json_encode($matchInfo);
    }   
    else {
       echo mysqli_error($connection);
    }
        

    //echo $matchInfo['question'];
    $json = array();
    $json['question'] = $matchInfo['question'];
    $json['answer'] = ucwords($matchInfo['object']);
    $json['subject'] = $matchInfo['subject'];
    $json['subject_tag'] = $matchInfo['subject_tag'];
    $json['subjectID'] = $matchInfo['subjectID'];
    $json['predicate'] = $matchInfo['predicate'];
    $json['mediator_predicate'] = $matchInfo['mediator_predicate'];
    $json['objectID'] = $matchInfo['objectID'];
    $json['object'] = $matchInfo['object'];
    
    //return $matchInfo;
    return $json;
}

/*function generateMatchIDsForUser($username)
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
}*/

?>
