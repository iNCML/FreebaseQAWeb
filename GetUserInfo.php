<?php
session_start();

require_once('ConnectDB.php');
//$conn = returnConn();

$username = $_SESSION["person"];

$userinfo = array();
$userinfo['username'] = $username;

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username';";
if ($result = mysqli_query($conn, $query)){
   $userinfo['count'] = mysqli_fetch_assoc($result)['count'];
}
else {
     echo $query;
}
echo json_encode($userinfo);
?>