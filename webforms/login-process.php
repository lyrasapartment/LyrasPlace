<?php
require_once('../includes/functions.inc');
//prevent access if they haven't submitted the form.
if (!isset($_POST['submit'])) {
die(header("Location: login.php"));
}
$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
unset($_SESSION['error']);
}

$_SESSION['error'] = array();
$required = array("uname","password");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
	switch($requiredField) {
		case "uname": $requiredField = "Username";break;
		case "password": $requiredField = "Password";break;
		default:break;
	}
	$_SESSION['error'][] = $requiredField . " is required.";
}
}
/*
if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
$_SESSION['error'][] = "Invalid e-mail address";
} */
if (count($_SESSION['error']) > 0) {
die(header("Refresh: 2;Location: login.php"));
} else {
$user = new User;
if ($user->authenticate($_POST['uname'],$_POST['password']))
{
unset($_SESSION['formAttempt']);
die(header("Location: authenticated.php"));
} else {
$_SESSION['error'][] = "There was a problem with your username or password.";
die(header("Location: login.php"));
}
}
?>