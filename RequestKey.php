<?php
require_once('ConnectDB.php');

// check for input
if (isset($_POST) & !empty($_POST)){
    $email = mysqli_real_escape_string($conn, $_POST['emailinfo']);

    $query = "SELECT * FROM `FreebaseQA_Users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    if ($count == 1){
        $username = mysqli_fetch_assoc($result)['username'];
        // create password expiry time
        $expiry = time() + 86400;
        // create password token
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $hash = password_hash($token, PASSWORD_DEFAULT);

        // delete key info for the username if already exists
        $query = "DELETE FROM `FreebaseQA_PasswordRecovery` WHERE `username` = '$username';";
        mysqli_query($conn, $query);

        $query = "INSERT INTO `FreebaseQA_PasswordRecovery` (`username`, `key_hash`, `expiry`) VALUES ('$username', '$hash', $expiry);";
        mysqli_query($conn, $query);

        // send email
        $subject = "Reset Your Password";
        $message = "Username: " . $username . "\nHere is your password recovery key: " . $token . "\nCopy this key into the Reset Key field on the site to get a new password. Note that this key will expire in 24 hours or after 1 successful use.";
        $headers = "From: admin\n";
        $headers .= "Reply-to: NoReply@AutomatedEmail.com\n";
        @mail($email, $subject, $message, $headers);
    }
}
?>
