<?php
session_start();

require_once('ConnectDB.php');

$username = $_SESSION["person"];

$userinfo = array();
$userinfo['username'] = $username;

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
if ($result = mysqli_query($conn, $query)){
   $info = mysqli_fetch_assoc($result);
   $userinfo['count'] = $info['count'];
   $userinfo['total'] = $info['total'];   
}
else {
     echo "Failed to get user information.";
}
echo json_encode($userinfo);
?>