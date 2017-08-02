<?php
  require_once("ConnectDB.php");
  require("GetMatchIDs.php");
  // get server-side key
  $ini_array = parse_ini_file("config.ini");
  $serverKey = $ini_array['k'];
  // parse JSON array
  $logininfo = $_POST['logininfo'];
  $logininfo = json_decode($logininfo);
  $email = $logininfo[0];
  $username = $logininfo[1];
  $password = $logininfo[2];

  // check email to ensure correct format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit();
  }

  // check username to ensure no SQL key word injection
  if ((stripos($username, 'select') !== false) || (stripos($username, 'delete') !== false) || (stripos($username, 'drop') !== false) || (stripos($username, 'insert') !== false) || (stripos($username, 'truncate') !== false)) {
    echo "Please choose a username without SQL key words.";
    exit();
  }

  // check email to ensure no preexisting account with the same email
  $queryEmail = mysqli_prepare($conn, "SELECT `email` FROM `FreebaseQA_Users` WHERE `email` = ?;");
  mysqli_stmt_bind_param($queryEmail, "s", $email);
  mysqli_stmt_execute($queryEmail);
  mysqli_stmt_store_result($queryEmail);
  $nEmail = mysqli_stmt_num_rows($queryEmail);
  if ($nEmail >= 1) {
     echo "There is already an account associated with this email.";
     exit();
  }

  // check username to ensure no preexisting account with the same username
  $queryUser = mysqli_prepare($conn, "SELECT `username` FROM `FreebaseQA_Users` WHERE `username` = ?;");
  mysqli_stmt_bind_param($queryUser, "s", $username);
  mysqli_stmt_execute($queryUser);
  mysqli_stmt_store_result($queryUser);
  $nUser = mysqli_stmt_num_rows($queryUser);
  if ($nUser >= 1) {
     echo "That username is already taken.";
     exit();
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $insertQuery = "INSERT INTO `FreebaseQA_Users` (`email`, `username`, `password`) values ('$email', '$username', '$hash');";
  mysqli_query($conn, $insertQuery);

  generateMatchIDsForUser($username);

  echo "Your account has been sucessfully created!";
?>
