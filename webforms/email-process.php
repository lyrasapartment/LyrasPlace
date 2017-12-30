<?php
require_once("../includes/functions.inc");
//prevent access if they haven't submitted the form.
if (!isset($_POST['submit'])) {
die(header("Location: login.php"));
}
$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
unset($_SESSION['error']);
}
$_SESSION['error'] = array();
$required = array("email");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField] == "") {
$_SESSION['error'][] = $requiredField . " is required.";
}
}
if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
$_SESSION['error'][] = "Invalid e-mail address";
}
if (count($_SESSION['error']) > 0) {
die(header("Location: emailpass.php"));
} 
else {
$user = new User;
if ($user->emailPass($_POST['email'])) {
unset($_SESSION['formAttempt']);
die(header("Location: email-success.php"));
}
else {
$_SESSION['error'][] = "There was a problem locating the e-mail address.";
die(header("Location: emailpass.php"));
}
}
?>