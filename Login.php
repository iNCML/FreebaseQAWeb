<?php
session_start();

require_once('ConnectDB.php');

$logininfo = $_POST['logininfo'];
$logininfo = json_decode($logininfo);
$username = $logininfo[0];
$password = $logininfo[1];

$query = "SELECT * FROM `FreebaseQA_Users` WHERE `username` = '$username'";
$result = mysqli_query($conn, $query);
$check = mysqli_fetch_assoc($result);
$userCheck = $check['username'];
$passCheck = $check['password'];

if(($userCheck != null) && ($passCheck != null) && ($username != '') && ($password != '')) {
    if (password_verify($password, $passCheck)) {
        $_SESSION["person"] = $username;
        echo "go";
    }
    else {
        echo "Incorrect username or password.";
    }
}
else {
    echo "Incorrect username or password.";
}
?>
