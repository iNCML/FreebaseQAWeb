<?php
session_start();
// Connect to DB
require_once('dbopen.php');
// Parse input
// Note it is send as a JSON array
// So need to decode it
$artIds = $_POST['artIds'];
$artIds = json_decode($artIds);
$prevArt1 = $artIds[0];
$prevArt2 = $artIds[1];

$user = $_SESSION["person"];
// Get current time
$nowtime = time() - 180;

// Insert new row
$query = "delete from `artRatings` where (art1_id = $prevArt1) and (art2_id = $prevArt2) and (username = '$user') and (time > $nowtime);";
mysqli_query($conn, $query);

 ?>
