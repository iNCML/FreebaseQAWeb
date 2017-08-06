<?php
session_start();

require_once('ConnectDB.php');
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

if (($rating == 0) || ($rating == 1) || ($rating == 2)) {
   $time = time();
   // submit the rating
   $query = "INSERT INTO `FreebaseQA_Evaluations` (`matchID`, `rating`, `username`, `time`) VALUES ($matchID, $rating, '$username', $time);";
   mysqli_query($conn, $query);
        
   // update user count and currentID
   $query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
   $result = mysqli_query($conn, $query);
   $userInfo = mysqli_fetch_assoc($result);
           
   $count = $userInfo['count'];
   $count = $count + 1;
   $currentID = $userInfo['currentID'];
   $currentID = $currentID + 1;
	
   $query = "UPDATE `FreebaseQA_Users` SET `currentID` = $currentID, `count` = $count WHERE `username` = '$username';";
   mysqli_query($conn, $query);
        
   //$json = updateCurrentPairsRemoveDone($user);
   //echo(json_encode($json));
}
?>
