<?php
session_start();

require_once('ConnectDB.php');

$username = $_SESSION["person"];

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);
$minID = $userInfo['minID'];
$currentID = $userInfo['currentID'];
$count = $userInfo['count'];
$total = $userInfo['total'];

if ($count >= $total) {
   $completed = array();
   $completed['question'] = "COMPLETE";
   $completed['answer'] = "COMPLETE";
   echo json_encode($completed);
}
else {
     // if the current matchID goes past the last match in the table, start from the beginning again
     $query = "SELECT * FROM `FreebaseQA_Matches`;";
     $result = mysqli_query($conn, $query);
     $nMatches = mysqli_num_rows($result);
     if ($currentID > $nMatches) {
     	$currentID = 1;
	$query = "UPDATE `FreebaseQA_Users` SET `currentID` = $currentID WHERE `username` = '$username';";
	mysqli_query($conn, $query);
     }

    // finds matches deferred by the user, and if user gets to the end of their assigned range, look through these matches
    $query = "SELECT `matchID` FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `rating` = 3;";
    $result = mysqli_query($conn, $query);
    $nDeferred = mysqli_num_rows($result);
    if ($count > $total - $nDeferred - 1) {
       $matchID = mysqli_fetch_row($result)[0];
       obtainInfo($matchID, $conn);
    }
    else {
       obtainInfo($currentID, $conn);
    }
}

function obtainInfo($ID, $conn) {
    $query = "SELECT * FROM `FreebaseQA_Matches` WHERE `matchID` = $ID;";
    if ($result = mysqli_query($conn, $query)) {
       $matchInfo = mysqli_fetch_assoc($result);
       foreach ($matchInfo as $key => $value) {
          $info[$key] = utf8_encode($value);
       }
       $info['answer'] = ucwords($info['object']);
       echo json_encode($info);
    }   
    else {
       echo mysqli_error($conn);
    }
}
?>
