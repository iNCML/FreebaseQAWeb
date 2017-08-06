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
$query = "SELECT `email` FROM `FreebaseQA_Users` WHERE `email` = '$email';";
$result = mysqli_query($conn, $query);
$nEmails = mysqli_num_rows($result);
if ($nEmails >= 1) {
    echo "There is already an account associated with this email.";
    exit();
}

// check username to ensure no preexisting account with the same username
$query = "SELECT `username` FROM `FreebaseQA_Users` WHERE `username` = '$username';";
$result = mysqli_query($conn, $query);
$nUsers = mysqli_num_rows($result);
if ($nUsers >= 1) {
    echo "That username is already taken.";
    exit();
}

// save password as hash
$hash = password_hash($password, PASSWORD_DEFAULT);
// generate random minID for user based on total number of matches
$query = "SELECT * FROM `TEMP_Matches`;";
$result = mysqli_query($conn, $query);
$nMatches = mysqli_num_rows($result);
$minID = rand(0, $nMatches);

$query = "INSERT INTO `FreebaseQA_Users` (`username`, `password`, `email`, `minID`, `currentID`, `count`) VALUES ('$username', '$hash', '$email', $minID, $minID, 0);";
mysqli_query($conn, $query);

echo "Your account has been sucessfully created!";
?>
