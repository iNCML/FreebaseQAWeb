<?php
session_start();

require_once('ConnectDB.php');

$matchesPerUser = 20000;

//require('GetMatchIDs.php');
//$inUseIDs = $_POST['artId'];
//$inUseIDs = json_decode($inUseIDs);
//$pairNum = $inUseIDs[0];
$username = $_SESSION["person"];
//$username = "atjoseph";
// Get array of article ids to select from
//$allPairs = array_map('str_getcsv', file('articlePairs.csv'));
// Get individual user pairs
//$pairs = getUserPairs($username);
//print_r($pairs);
// Generate a random number
//$num =  rand( 0, count($pairs) );
// Select the article
//$artId1 = $allPairs[$pairs[$num]][0];
//$artId2 = $allPairs[$pairs[$num]][1];

// exit();
/* check connection */
/*if ($conn->connect_error) {
    //printf("Connect failed: %s\n", $conn->connect_error);
    echo("Conn failed");
    exit();
}*/
echo($username);

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);
$minID = mysqli_fetch_assoc($result)['minID'];
$currentID = mysqli_fetch_assoc($result)['currentID'];
$count = mysqli_fetch_assoc($result)['count'];

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
    $query = "SELECT * FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `matchID` > $minID AND `matchID` < $maxID AND `rating` = 3 LIMIT 1;"; // rating = 3 is a skipped match
    $result = mysqli_query($conn, $query);
    $matchID = mysqli_fetch_assoc($result)['matchID'];
    
    echo json_encode(obtainInfo($matchID));
}
else {
    echo json_encode(obtainInfo($currentID));
}


/* free result set */
//mysqli_free_result($result);

// Return results to client
// echo("Something");

function obtainInfo($matchID) {
    $query = "SELECT * FROM `TEMP_Matches` WHERE `matchID` = $matchID;";
    $result = mysqli_query($conn, $query);

    $json = array();
    $json['question'] = mysqli_fetch_assoc($result)['question'];
    $json['answer'] = ucwords(mysqli_fetch_assoc($result)['object']);
    $json['subject'] = mysqli_fetch_assoc($result)['subject'];
    $json['subjectTag'] = mysqli_fetch_assoc($result)['subject_tag'];
    $json['subjectID'] = mysqli_fetch_assoc($result)['subjectID'];
    $json['predicate'] = mysqli_fetch_assoc($result)['predicate'];
    $json['mediatorPredicate'] = mysqli_fetch_assoc($result)['mediator_predicate'];
    $json['objectID'] = mysqli_fetch_assoc($result)['objectID'];
    $json['object'] = mysqli_fetch_assoc($result)['object'];
    
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
