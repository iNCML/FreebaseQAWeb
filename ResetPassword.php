<?php
require_once('ConnectDB.php');
// parse JSON array
$logininfo = $_POST['logininfo'];
$logininfo = json_decode($logininfo);
$inputkey = $logininfo[0];
$username = $logininfo[1];
$password = $logininfo[2];

$query = "SELECT * FROM `FreebaseQA_PasswordRecovery` WHERE `username` = '$username'";
$result = mysqli_query($conn, $query);
//mysqli_stmt_execute($query);
//mysqli_stmt_store_result($query);
$count = mysqli_num_rows($result);
if ($count == 1) {
    $key = mysqli_fetch_assoc($result)['key_hash'];
    // check reset key
    if (password_verify($inputkey, $key)) {
        // update user password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE `FreebaseQA_Users` SET `password` = '$hash' WHERE `username` = '$username';";
        mysqli_query($conn, $query);
        // delete user key
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
