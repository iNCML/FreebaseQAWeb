<?php
require_once('ConnectDB.php');
// parse JSON array
$logininfo = $_POST['logininfo'];
$logininfo = json_decode($logininfo);
$inputkey = $logininfo[0];
$username = $logininfo[1];
$password = $logininfo[2];

$query = "SELECT `key_hash` FROM `FreebaseQA_PasswordRecovery` WHERE `username` = '$username'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);
if ($count == 1) {
    $key = mysqli_fetch_assoc($result)['key_hash'];
    if (password_verify($inputkey, $key)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);  

        $query = "UPDATE `FreebaseQA_Users` SET `password` = '$hash' WHERE `username` = '$username';";
        mysqli_query($conn, $query);

        $query = "DELETE from `FreebaseQA_PasswordRecovery` WHERE `username` = '$username';";
        mysqli_query($conn, $query);

        echo "Your password has been successfully reset.";
        exit();
    }
    else {
        echo "Incorrect key or username.";
        exit();
    }
}
else {
    echo "No key available for this username.";
}
?>
