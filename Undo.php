<?php
session_start();

require_once('ConnectDB.php');
$prevMatchID = $_POST['previnfo'];
$username = $_SESSION["person"];

// can only undo ratings within a minute
$time = time() - 60;

$query = "DELETE FROM `FreebaseQA_Evaluations` WHERE (`matchID` = $prevMatchID) AND (`username` = '$username') AND (`time` > $time);";
mysqli_query($conn, $query);

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);

$count = mysqli_fetch_assoc($result)['count'];
$count = $count - 1;

$query = "UPDATE `FreebaseQA_Users` SET `currentID` = $prevMatchID, `count` = $count WHERE `username` = '$username';";
mysqli_query($conn, $query);
?>
