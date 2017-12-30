<?php 
require_once("../../../includes/functions.inc");
require_once("../../../includes/unused/dbstuff.inc");
$user = new User;
//prevent access if they haven't submitted the form.
if (!isset($_POST['submit'])) {
die(header("Location: TrAddConfirm.php"));
}

$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
unset($_SESSION['error']);
}


$_SESSION['error'] = array();
$required = array("trCustId2","trDesc");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
	switch($requiredField) {
		case "trCustId2": $requiredField = "Customer";break;
		case "trDesc": $requiredField = "Description";break;
		default:break;
	}
	$_SESSION['error'][] = $requiredField . " is required.";
}
}
/*
if (!preg_match('/^[\w .]+$/',$_POST['lname'])) {
$_SESSION['error'][] = "Last Name must be letters and numbers only.";
}*/

if (isset($_POST['trCustId']) && $_POST['trCustId2'] != "") {
	$_SESSION['error'][] = "Customer No. : " . $_POST['trCustId'];
}

//$_POST['trCredit'] = floatval($_POST['trCredit']);

function is_valid_payment($payment) {
	if(is_numeric($payment)) {
		return true;
	}
	else {
		return false;
	}
}

if (isset($_POST['trDebit']) && $_POST['trDebit'] != "") {
	if(!is_valid_payment($_POST['trDebit']))  {
		$_SESSION['error'][] = "Debit must be numbers only. : " . $_POST['trCredit'];
	}
	else {
		$_POST['trDebit'] = floatval($_POST['trDebit']);
	}
}


if (isset($_POST['trCredit']) && $_POST['trCredit'] != "") {
	if(!is_valid_payment($_POST['trCredit']))  {
		$_SESSION['error'][] = "Credit must be numbers only. : " . $_POST['trCredit'];
	}
	else {
		$_POST['trCredit'] = floatval($_POST['trCredit']);
	}
}

if (!preg_match('/^[\w .]+$/',$_POST['trDesc'])) {
$_SESSION['error'][] = "Description must be letters and numbers only. : " . $_POST['trDesc'];
}

function is_valid_desc($str) {
	switch($str) {
		case "Foam Fee":
		case "Payment":
		case "Room Fee":
		//case "Cancellation":
		return true;
		break;
		default: return false;break;
	}
}

if(!is_valid_desc($_POST['trDesc'])) {
$_SESSION['error'][] = "Description must valid : " . $_POST['trDesc'];
}

//final disposition
if (count($_SESSION['error']) > 0) {
	die(header("Location: TrAdd.php"));
}
else {
	if(!is_null($user) && $user->isLoggedIn) {
		if(addTransaction($_POST)) {
		unset($_SESSION['formAttempt']);
		die(header("Location: TrAddConfirmSuccess.php"));
		} 
		else {
		error_log("Problem adding transaction.");
		$_SESSION['error'][] = "Problem adding transaction";
		die(header("Location: TrAdd.php"));
		}
	}
	else {
		error_log("You are not logged in.");
		$_SESSION['error'][] = "You are not logged in.";
		die(header("Location: TrAdd.php"));
	}
}

function addTransaction($userData) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
	error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
	return false;
	}
$custID = $mysqli->real_escape_string($_POST['trCustId2']);
/*
//check for an existing user
$findUser = "SELECT AccountID from accounts where AccEmail = '{$custID}'";
$findResult = $mysqli->query($findUser);
$findRow = $findResult->fetch_assoc();
if (isset($findRow['AccountID']) && $findRow['AccountID'] != "") {
$_SESSION['error'][] = "A user with that e-mail address already exists";
return false;
}
*/

if (isset($_POST['trDebit'])) {
$debit = $mysqli->real_escape_string($_POST['trDebit']);
} else {
$debit = 0.00;
}

if (isset($_POST['trCredit'])) {
$credit = $mysqli->real_escape_string($_POST['trCredit']);
} else {
$credit = 0.00;
}

if (isset($_POST['trDesc'])) {
$desc = $mysqli->real_escape_string($_POST['trDesc']);
} else {
$desc = "";
}
$newBalance = 0;

$query1 = "SELECT CBalance FROM customers WHERE CustomerNo = '{$custID}'";
if ($result = $mysqli->query($query1)) {
	$row = $result->fetch_assoc();
	$currentBalance = $row['CBalance'];
	$newBalance = $currentBalance + $debit - $credit;
$newBalance = $mysqli->real_escape_string($newBalance);
}

$trStatus = "OK";
$trStatus = $mysqli->real_escape_string($trStatus);
$query2 = "INSERT INTO transactions (TrCustID,TrDebit,TrCredit,TrDescription,TrBalance,TrStatus) " ." VALUES ('{$custID}','{$debit}','{$credit}','{$desc}','{$newBalance}','{$trStatus}')";
$query3 = "UPDATE customers SET CBalance = '{$newBalance}' WHERE CustomerNo = '{$custID}'";
if(!$mysqli->query($query3)) {
	error_log("Problem inserting {$query3}");
}


if ($mysqli->query($query2)) {
error_log("Inserted a new transaction");

return true;
} else {
error_log("Problem inserting {$query2}");
return false;
}
} //end function addTransaction
?>