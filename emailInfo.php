<?php
// Connect to DB
require_once('dbopen.php');

// Check for input
if(isset($_POST) & !empty($_POST)){
  $email= mysqli_real_escape_string($conn, $_POST['emailInfo']);
  // Pre construct query
  $query = "SELECT username FROM `accDB` WHERE email = '$email'";
  $res = mysqli_query($conn, $query);
  $count = mysqli_num_rows($res);
  if($count == 1){
    // Get username
    $r = mysqli_fetch_assoc($res);
    $username = $r['username'];
    // Create password expiry date
    $expDate = time() + 86400;
    // Create password token
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $hash = password_hash($token, PASSWORD_DEFAULT);
    
    // Make sure username doesn't have any key info in yet
    // Delete key if exists
    $query = "DELETE from `recoveryemails_enc` WHERE username = '$username';";
    mysqli_query($conn, $query);
    // Create query
    // Insert new row
    $query = "insert into `recoveryemails_enc` (username,key_hash,time) values ('$username','$hash',$expDate);";
    mysqli_query($conn, $query);

    // Send email
    $message = "Here is your user name: " . $username . " and your password recovery key: " . $token . " This key will expire after 1 successful use.";
    $headers = "From: Admin\n";
    $headers .= "Forgot Password Key: \n";
    $headers .= "Reply-To: NoReply@AutomatedEmail.com\n"; // Reply address
    $subject = "Your Lost Password";
    @mail($email,$subject,$message,$headers);
  }
}

?>
