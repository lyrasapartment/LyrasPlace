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
$required = array("trDesc,trStatus");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
	switch($requiredField) {
		case "trDesc": $requiredField = "Description";break;
		case "trStatus": $requiredField = "Status";break;
		default:break;
	}
	$_SESSION['error'][] = $requiredField . " is required.";
}
}
/*
if (!preg_match('/^[\w .]+$/',$_POST['lname'])) {
$_SESSION['error'][] = "Last Name must be letters and numbers only.";
}*/


//$_POST['trCredit'] = floatval($_POST['trCredit']);

function is_valid_payment($payment) {
	if(is_numeric($payment)) {
		return true;
	}
	else {
		return false;
	}
}

function is_valid_status($str) {
	switch ($str) {
		case "OK":
		case "Cancelled": return true;
		break;
		
		default: return false;break;
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

if (!preg_match('/^[\w .]+$/',$_POST['trStatus'])) {
$_SESSION['error'][] = "Description must be letters and numbers only. : " . $_POST['trStatus'];
}

if(!is_valid_status($_POST['trStatus'])) {
$_SESSION['error'][] = "Status is not valid. : " . $_POST['trStatus'];
}
else if($_POST['trStatus'] == "Cancelled") {
$_SESSION['error'][] = "You cannot edit cancelled transactions.";
}

//final disposition
if (count($_SESSION['error']) > 0) {
	die(header("Location: TrEdit.php"));
}
else {
	if(!is_null($user) && $user->isAdmin) {
		if(addTransaction($_POST)) {
		unset($_SESSION['formAttempt']);
		die(header("Location: TrEditConfirmSuccess.php"));
		} 
		else {
		error_log("Problem editing transaction.");
		$_SESSION['error'][] = "Problem editing transaction";
		die(header("Location: TrEdit.php"));
		}
	}
	else {
		error_log("You are not logged in.");
		$_SESSION['error'][] = "You are not logged in.";
		die(header("Location: TrEdit.php"));
	}
}

function addTransaction($userData) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
	error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
	return false;
	}
$custID = $mysqli->real_escape_string($_POST['defaultCustomer']);
$status = $mysqli->real_escape_string($_POST['trStatus']);

if (isset($_POST['defaultTrID'])) { 
$oldTrID = $mysqli->real_escape_string($_POST['defaultTrID']);
$oldTrSql = "SELECT * FROM transactions WHERE TransactionID = '{$oldTrID}'";
$findResult = $mysqli->query($oldTrSql);
$findRow = $findResult->fetch_assoc();
$oldDebit = $findRow['TrDebit'];
$oldCredit = $findRow['TrCredit'];
$oldCBalance = $findRow['TrBalance'];
$oldCBalance = -$oldDebit + $oldCredit;
}


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
	$newBalance = $oldCBalance + $debit - $credit;
	if($status=="Cancelled") {
		$newBalance = $oldCBalance;
	}
$newBalance = $mysqli->real_escape_string($newBalance);
}
$trStatus = $mysqli->real_escape_string($status);

$query2 = "UPDATE transactions SET TrDebit = '{$debit}',TrCredit = '{$credit}',TrDescription = '{$desc}', TrBalance = '{$newBalance}',TrStatus = '{$trStatus}' WHERE TransactionID = '{$oldTrID}'";
$query3 = "UPDATE customers SET CBalance = '{$newBalance}' WHERE CustomerNo = '{$custID}'";
if(!$mysqli->query($query3)) {
	error_log("Problem inserting {$query3}");
}


if ($mysqli->query($query2)) {
error_log("Edited a new transaction");

return true;
} else {
error_log("Problem inserting {$query2}");
return false;
}
} //end function addTransaction
?>