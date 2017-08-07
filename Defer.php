<?php
session_start();

require_once('ConnectDB.php');
// parse JSON array
$matchID = $_POST['matchinfo'];
$username = $_SESSION["person"];

$time = time();
// submit the rating, with a rating value of 3 to denote deferral
$query = "INSERT INTO `FreebaseQA_Evaluations` (`matchID`, `rating`, `username`, `time`) VALUES ($matchID, 3, '$username\
', $time);";
mysqli_query($conn, $query);

// update user currentID, NOT count
$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);

$currentID = mysqli_fetch_assoc($result)['currentID'];
$currentID = $currentID + 1;

$query = "UPDATE `FreebaseQA_Users` SET `currentID` = $currentID WHERE `username` = '$username';";
mysqli_query($conn, $query);

?>