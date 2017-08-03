<?php
session_start();
// Connect to DB
require_once('dbopen.php');
require('computeUserPairs.php');
// Parse input
// Note it is send as a JSON array
// So need to decode it
$artIds = $_POST['artIds'];
$artIds = json_decode($artIds);
$art1 = (int) $artIds[0];
$art2 = (int) $artIds[1];
$rating = (int) $artIds[2];
$goodRec = (int) $artIds[3];
$art1Cat = $artIds[4];
$art2Cat = $artIds[5];
$pairNum = $artIds[6];
//$art1Like = (int) $artIds[6];
//$art2Like = (int) $artIds[7];

$user = $_SESSION["person"];
// error_log($user,3,"/var/tmp/my-errors.log");
if (is_int($art1) && is_int($art2) && is_int($rating) && is_int($goodRec))
{
    if (($rating == 0) || ($rating == 1) || ($rating == 2) && (($goodRec == 1) || ($goodRec == 0))) 
    {
        // Get current time
        $nowtime = time();
        // Insert new row
        $query = "insert into `artRatings` (art1_id,art2_id,rating,goodR,username,time,pair_id) values ($art1,$art2,$rating,$goodRec,'$user',$nowtime,$pairNum);";
        mysqli_query($conn, $query);
        // When ready to implement 
        $json = updateCurrentPairsRemoveDone($user);
        echo(json_encode($json));
    }
}
?>
