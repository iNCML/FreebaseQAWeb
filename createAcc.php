<?php
  // Connect to DB
  require_once('dbopen.php');
  // For creation of user pairs
  require("computeUserPairs.php");
  // Get Server side key
  $ini_array = parse_ini_file("config.ini");
  $serverKey = $ini_array['k'];
  // Parse JSON array
  $infoArray = $_POST['loginInfo'];
  $infoArray = json_decode($infoArray);
  $email = $infoArray[0];
  $username = $infoArray[1];
  $password = $infoArray[2];

  // Check to insure email is correct
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
    echo $emailErr;
    exit();
  }

  // Check username input to insure no SQL injection
  if ((stripos($username, 'select') !== false) || (stripos($username, 'delete') !== false) || (stripos($username, 'drop') !== false) || (stripos($username, 'insert') !== false) || (stripos($username, 'truncate') !== false))
  {
    echo 'Please choose a username without SQL key words';
    exit();
  }

  // Pre construct query
  $query = mysqli_prepare($conn, "SELECT `email` from `accDB` where email = ?;");

  /* bind parameters for markers */
  mysqli_stmt_bind_param($query, "s", $email);

  /* execute query */
  mysqli_stmt_execute($query);

  /* store result */
  mysqli_stmt_store_result($query);

  $n = mysqli_stmt_num_rows($query);
  if ($n >= 1) {
     echo "There is already an account associated with this email.";
     exit();
  }

  // Query for username
  // Pre construct query
  $queryUser = mysqli_prepare($conn, "SELECT `username` from `accDB` where username = ?;");

  /* bind parameters for markers */
  mysqli_stmt_bind_param($queryUser, "s", $username);

  /* execute query */
  mysqli_stmt_execute($queryUser);

  /* store result */
  mysqli_stmt_store_result($queryUser);

  $nUser = mysqli_stmt_num_rows($queryUser);
  if ($nUser >= 1) {
     echo "That username is already taken.";
     exit();
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  // Pre construct query
  $insertQuery = "insert into `accDB` (email,username,password) values ('$email','$username','$hash');";
  mysqli_query($conn, $insertQuery);

  // When ready to implement
  generatePairsPerUser($username);

  echo "Your account has been made";
?>
