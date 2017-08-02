<?php
  // Start session to get sessional variables
  session_start();
  // Connect to DB
  require_once('dbopen.php');
  // Parse variables
  $loginInfo = $_POST['loginInfo'];
  $loginInfo = json_decode($loginInfo);
  $username = $loginInfo[0];
  $password = $loginInfo[1];
// $username="t";
//$password="t";

  // Query for username and userkey
  $query = mysqli_prepare($conn, "SELECT username,password FROM accDB WHERE username=?");
  /* bind parameters for markers */
  mysqli_stmt_bind_param($query, "s", $username);
  /* execute query */
  mysqli_stmt_execute($query);
  /* bind result variables */
  mysqli_stmt_bind_result($query, $userCheck,$passCheck);
  /* fetch value */
  mysqli_stmt_fetch($query);

  if(($userCheck != null) && ($passCheck != null) && ($username != '') && ($password != ''))
  {

    // Check if password is correct
    if(password_verify($password,$passCheck))
    {
      $_SESSION["person"] = $username;
      echo "go";
        // header("Location:http://php.net/manual/en/function.header.php");
        // die();
    }
    else
    {
      echo "Incorrect username or password";
    }
  }
  else
  {
    echo "Incorrect username or password";
  }

?>
