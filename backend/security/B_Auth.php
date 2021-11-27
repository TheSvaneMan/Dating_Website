<?php
session_start();
// Static, needs to be updated manually
$_baseUrl = "http://localhost:5600/";

// Update these frequently, make an encryption method to control authorization processes
$valid_passwords = array("penda" => "password1234");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    // Basic header description for user to understand why they can't enter
    header('WWW-Authenticate: Basic realm="Entanglement_App Authentication Required"');
    header('HTTP/1.0 401 Unauthorized');
    die("Not authorized");
} else if ($validated) {
    // If arrives here, is a valid user.
    $_SESSION['auth'] = $_SERVER['PHP_AUTH_USER'];
    // The function will refresh the page
    // in 3 seconds and the passed url
    header("refresh: 3; url = " . $_baseUrl . "index.html");
    exit;
}
?>  