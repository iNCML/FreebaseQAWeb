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

if ($count >= $matchesPerUser) {
   $completed = array();
   $completed['question'] = "COMPLETE";
   $completed['answer'] = "COMPLETE";
   echo json_encode($completed);
}
else {
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
     /*$maxID = $minID + $matchesPerUser - 1;
     if ($currentID > $maxID) {
     $query = "SELECT * FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `matchID` > $minID AND `matchID` < $maxID AND `rating` = 3 LIMIT 1;"; // a rating of 3 is a deferred match
    $result = mysqli_query($conn, $query);
    $matchID = mysqli_fetch_assoc($result)['matchID']; 
    obtainInfo($matchID);
    }*/

    // finds matches deferred by the user, and if user gets to the end of their assigned range, look through these matches
    $query = "SELECT `matchID` FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `rating` = 3;";
    $result = mysqli_query($conn, $query);
    $nDeferred = mysqli_num_rows($result);
    if ($count > $matchesPerUser - $nDeferred - 1) {
       $matchID = mysqli_fetch_row($result)[0];
       obtainInfo($matchID);
    }
    else {
       obtainInfo($currentID);
    }
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
}
?>
