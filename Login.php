<?php
// start session to get sessional variables
session_start();
require_once('ConnectDB.php');
// parse JSON array
$logininfo = $_POST['logininfo'];
$logininfo = json_decode($logininfo);
$username = $logininfo[0];
$password = $logininfo[1];

$queryLogin = mysqli_prepare($conn, "SELECT `username`,`password` FROM `FreebaseQA_Users` WHERE `username` = ?");
mysqli_stmt_bind_param($queryLogin, "s", $username);
mysqli_stmt_execute($queryLogin);
mysqli_stmt_bind_result($queryLogin, $userCheck, $passCheck);
mysqli_stmt_fetch($queryLogin);

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
