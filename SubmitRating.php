<?php
session_start();

require_once('ConnectDB.php');
// parse JSON array
$ratinginfo = $_POST['ratinginfo'];
$ratinginfo = json_decode($ratinginfo);
$matchID = $ratinginfo[0];
$rating = $ratinginfo[1];
$username = $_SESSION["person"];

if ($rating == 0 || $rating == 1 || $rating == 2 || $rating == 3) {
   // if the previous rating was a deferral rating (3), delete that rating first
   $query = "SELECT * FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `matchID` = $matchID;";
   $result = mysqli_query($conn, $query);
   $prevRating = mysqli_fetch_assoc($result)['rating'];
   if ($prevRating == 3) {
      $query = "DELETE FROM `FreebaseQA_Evaluations` WHERE `username` = '$username' AND `matchID` = $matchID;";
      mysqli_query($conn, $query);
   }

   $time = time();
   // submit the rating
   $query = "INSERT INTO `FreebaseQA_Evaluations` (`matchID`, `rating`, `username`, `time`) VALUES ($matchID, $rating, '$username', $time);";
   if (mysqli_query($conn, $query)) {  
      // update user count and currentID
      $query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
      $result = mysqli_query($conn, $query);
      $userInfo = mysqli_fetch_assoc($result);
           
      $count = $userInfo['count'];
      if ($rating != 3) { // if the rating is a deferral rating (3), the count doesn't get increased
      	 $count = $count + 1;
      }
      $currentID = $userInfo['currentID'];
      $currentID = $currentID + 1;

      $query = "UPDATE `FreebaseQA_Users` SET `currentID` = $currentID, `count` = $count WHERE `username` = '$username';";
      if (mysqli_query($conn, $query)) {
      	 echo "Success.";
      }
      else {
      	 echo "Failed to update user counter.";
      }      
   }
   else {
      echo "Failed to save rating.";
   }  
}
?>
