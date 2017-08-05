<?php
require_once("ConnectDB.php");

$matchesPerUser = 20000;

// get server-side key
//$ini_array = parse_ini_file("config.ini");
//$serverKey = $ini_array['k'];
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
/*$queryEmail = mysqli_prepare($conn, "SELECT `email` FROM `FreebaseQA_Users` WHERE `email` = ?;");
mysqli_stmt_bind_param($queryEmail, "s", $email);
mysqli_stmt_execute($queryEmail);
mysqli_stmt_store_result($queryEmail);*/
$query = "SELECT `email` FROM `FreebaseQA_Users` WHERE `email` = '$email';";
$result = mysqli_query($conn, $query);
//$nEmail = mysqli_stmt_num_rows($queryEmail);
$nEmails = mysqli_num_rows($result);
if ($nEmails >= 1) {
    echo "There is already an account associated with this email.";
    exit();
}

// check username to ensure no preexisting account with the same username
/*$queryUser = mysqli_prepare($conn, "SELECT `username` FROM `FreebaseQA_Users` WHERE `username` = ?;");
mysqli_stmt_bind_param($queryUser, "s", $username);
mysqli_stmt_execute($queryUser);
mysqli_stmt_store_result($queryUser);*/
$query = "SELECT `username` FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);
//$nUser = mysqli_stmt_num_rows($queryUser);
$nUsers = mysqli_num_rows($result);
if ($nUsers >= 1) {
    echo "That username is already taken.";
    exit();
}
// save password as hash
$hash = password_hash($password, PASSWORD_DEFAULT);
// generate random minID for user based on total number of matches
$query = "SELECT * FROM `FreebaseQA_Matches`;";
$result = mysqli_query($conn, $query);
$nMatches = mysqli_num_rows($result);
$minID = rand(0, $nMatches);

$query = "INSERT INTO `FreebaseQA_Users` (`username`, `password`, `email`, `minID`, `currentID`, `count`) VALUES ('$username', '$hash', '$email', $minID, $minID, 0);";
mysqli_query($conn, $query);

//$conn = returnConn();

//generateMatchIDsForUser($username);

echo "Your account has been sucessfully created!";
?>
