<?php
  // Connect to DB
  require_once('dbopen.php');
  // Parse JSON array
  $infoArray = $_POST['loginInfo'];
  $infoArray = json_decode($infoArray);
  $key = $infoArray[0];
  $username = $infoArray[1];
  $password = $infoArray[2];

  // Create and execute query
  $query = "SELECT key_hash FROM `recoveryemails_enc` WHERE username = '$username'";
  $res = mysqli_query($conn, $query);
  $count = mysqli_num_rows($res);
  if($count == 1){  
    // Get key
    $r = mysqli_fetch_assoc($res);
    $checkKey = $r['key_hash'];
    // Check for match
    if(password_verify($key,$checkKey))
    {
      // Update password in accDB
      
      // Hash password
      $hash = password_hash($password, PASSWORD_DEFAULT);  
     
      // Update database 
      $query = "UPDATE `accDB` set password='$hash' where username = '$username';";
      mysqli_query($conn, $query);

      // Delete key
      $query = "DELETE from `recoveryemails_enc` WHERE username = '$username';";
      mysqli_query($conn, $query);

      echo "Successful reset";
      exit();
    }
    else
    {
        echo "Incorrect Key or Username";
        exit();
    }
 }
  else
  {
	echo "No key available for user";
  }
?>
