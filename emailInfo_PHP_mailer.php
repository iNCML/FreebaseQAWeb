<?php
  // Import Encryption
  include("Encryption.php");
  include("keyFuns.php");
  // Connect to DB
  require_once('dbopen.php');
  // email
  include('phpMailerTest.php');

  // Get Server side key
  $ini_array = parse_ini_file("config.ini");
  $serverKey = $ini_array['k'];

  if(isset($_POST) & !empty($_POST)){
  	$email= mysqli_real_escape_string($conn, $_POST['emailInfo']);
    error_log($email,3,"/var/tmp/my-errors.log");
  	$query = "SELECT * FROM `accDB` WHERE email = '$email'";
  	$res = mysqli_query($conn, $query);
  	$count = mysqli_num_rows($res);
  	if($count == 1){
      $r = mysqli_fetch_assoc($res);
      $password = $r['password'];
      $username = $r['username'];
      $userkey = $r['userkey'];
      // Decrypt Password
      $e2 = new Encryption(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
      $key = combineKeys($userkey, $serverKey);
      $decryptedPass = $e2->decrypt($password, $key);

      $message = "Here is your user name: " . $username . " and your password: " . $decryptedPass ;
      sendMail($message,$email);
  	}
  }
?>
