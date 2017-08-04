<?php
session_start();

require_once('ConnectDB.php');
require('GetMatchIDs.php');
// parse JSON array
$ratinginfo = $_POST['ratinginfo'];
$ratinginfo = json_decode($ratinginfo);
$matchID = (int) $ratinginfo[0];
$rating = (int) $ratinginfo[1];
$username = $_SESSION["person"];

/*$art1 = (int) $artIds[0];
$art2 = (int) $artIds[1];
$rating = (int) $artIds[2];
$goodRec = (int) $artIds[3];
$art1Cat = $artIds[4];
$art2Cat = $artIds[5];
$pairNum = $artIds[6];
$art1Like = (int) $artIds[6];
$art2Like = (int) $artIds[7];*/
// error_log($user,3,"/var/tmp/my-errors.log");

if (is_int($matchID) && is_int($rating)) {
    if (($rating == 0) || ($rating == 1) || ($rating == 2)) {
        $time = time();
        $query = "INSERT INTO `FreebaseQA_Evaluations` (`matchID`, `rating`, `username`, `time`) VALUES ($matchID, $rating, $username, $time);";
        mysqli_query($conn, $query);
        
        //$json = updateCurrentPairsRemoveDone($user);
        //echo(json_encode($json));
    }
}
?>
