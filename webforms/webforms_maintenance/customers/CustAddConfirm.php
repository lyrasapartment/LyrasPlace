<?php 
require_once("../functions.inc");
$user = new User;
//prevent access if they haven't submitted the form.
if (!isset($_POST['submit'])) {
die(header("Location: CustAdd.php"));
}

$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
unset($_SESSION['error']);
}
$_SESSION['error'] = array();
$required = array("uname","lname","fname","email","accountType","password1","password2");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
	switch($requiredField) {
		case "uname": $requiredField = "Username";break;
		case "lname": $requiredField = "Last name";break;
		case "fname": $requiredField = "First name";break;
		case "email": $requiredField = "email";break;
		case "accountType": $requiredField = "Account type";break;
		case "password1": $requiredField = "Password";break;
		case "password2": $requiredField = "Username";break;
		default:break;
	}
	$_SESSION['error'][] = $requiredField . " is required.";
}
}

if (!preg_match('/^[\w .]+$/',$_POST['uname'])) {
$_SESSION['error'][] = "Username must be letters and numbers only.";
}
if (!preg_match('/^[\w .]+$/',$_POST['fname'])) {
$_SESSION['error'][] = "First Name must be letters and numbers only.";
}
if (!preg_match('/^[\w .]+$/',$_POST['lname'])) {
$_SESSION['error'][] = "Last Name must be letters and numbers only.";
}

if (isset($_POST['accountType']) && $_POST['accountType'] != "") {
	if (!is_valid_accountType($_POST['accountType'])) {
	$_SESSION['error'][] = "Account Type error.";
	}
}

if (isset($_POST['phone']) && $_POST['phone'] != "") {
	if (!preg_match('/^[\d]+$/',$_POST['phone'])) {
	$_SESSION['error'][] = "Phone number should be digits only";
	} else if (strlen($_POST['phone']) < 10) {
	$_SESSION['error'][] = "Phone number must be at least 10 digits";
	}
}

if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
$_SESSION['error'][] = "Invalid e-mail address";
}

if ($_POST['password1'] != $_POST['password2']) {
$_SESSION['error'][] = "Passwords don't match";
}
//final disposition
if (count($_SESSION['error']) > 0) {
die(header("Location: EmpAdd.php"));
} 
else {
if(!is_null($user) && $user->isAdmin) {
	if(registerUser($_POST)) {
	unset($_SESSION['formAttempt']);
	die(header("Location: EmpConfirmSuccess.php"));
	} 
	else {
	error_log("Problem registering user: {$_POST['email']}");
	$_SESSION['error'][] = "Problem registering account";
	die(header("Location: EmpAdd.php"));
	}
}
else {
	error_log("Only administrators can create accounts.");
	$_SESSION['error'][] = "Only administrators can create accounts.";
	die(header("Location: EmpAdd.php"));
}

}

function registerUser($userData) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
return false;
}
$email = $mysqli->real_escape_string($_POST['email']);
//check for an existing user
$findUser = "SELECT AccountID from accounts where AccEmail = '{$email}'";
$findResult = $mysqli->query($findUser);
$findRow = $findResult->fetch_assoc();
if (isset($findRow['AccountID']) && $findRow['AccountID'] != "") {
$_SESSION['error'][] = "A user with that e-mail address already exists";
return false;
}
$username = $mysqli->real_escape_string($_POST['uname']);
$lastName = $mysqli->real_escape_string($_POST['lname']);
$firstName = $mysqli->real_escape_string($_POST['fname']);
$accounttype = $mysqli->real_escape_string($_POST['accountType']);
$cryptedPassword = crypt($_POST['password1']);
$password = $mysqli->real_escape_string($cryptedPassword);
if (isset($_POST['addr'])) {
$address = $mysqli->real_escape_string($_POST['addr']);
} else {
$address = "";
}

if (isset($_POST['phone'])) {
$phone = $mysqli->real_escape_string($_POST['phone']);
} else {
$phone = "";
}

$query = "INSERT INTO accounts (AccountID,AccountPass,AccCreateDate,AccountType,AFirstName,ALastName,AContactNo,AccEmail,AccAddress) " ." VALUES ('{$username}','{$password}',NOW(),'{$accounttype}','{$firstName}','{$lastName}','{$phone}','{$email}','{$address}')";
if ($mysqli->query($query)) {
$id = $mysqli->insert_id;
error_log("Inserted {$email} as ID {$id}");
return true;
} else {
error_log("Problem inserting {$query}");
return false;
}
} //end function registerUser
?>