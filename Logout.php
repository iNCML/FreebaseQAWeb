<?php
session_start();

// unset all of the session variables.
$_SESSION = array();

// if it's desired to kill the session, also delete the session cookie (will destroy the session and not just session data)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();
?>
