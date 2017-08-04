<?php
session_start();

require_once('ConnectDB.php');
$prevMatchID = $_POST['previnfo'];
$username = $_SESSION["person"];

$time = time() - 60;

$query = "DELETE FROM `FreebaseQA_Evaluations` WHERE (`matchID` = $prevMatchID) AND (`username` = '$username') AND (`time` > $time);";
mysqli_query($conn, $query);
?>
