<?php 
require_once("../../../includes/functions.inc");
require_once("../../../includes/unused/dbstuff.inc");
$user = new User;
//prevent access if they haven't submitted the form.
if (!isset($_POST['submit'])) {
die(header("Location: TrEditConfirm.php"));
}

$_SESSION['formAttempt'] = true;
if (isset($_SESSION['error'])) {
unset($_SESSION['error']);
}


$_SESSION['error'] = array();
$required = array("trStatus");
//Check required fields
foreach ($required as $requiredField) {
if (!isset($_POST[$requiredField]) || $_POST[$requiredField]== "") {
	switch($requiredField) {
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

function is_valid_status($str) {
	switch ($str) {
		case "OK":
		case "Cancelled": return true;
		break;
		
		default: return false;break;
	}
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
		if(deleteTransaction($_POST)) {
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

function deleteTransaction($userData) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
	error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
	return false;
	}
$custID = $mysqli->real_escape_string($_POST['defaultCustomer']);

if (isset($_POST['defaultTrID'])) { 
$oldTrID = $mysqli->real_escape_string($_POST['defaultTrID']);
$oldTrSql = "SELECT * FROM transactions WHERE TransactionID = '{$oldTrID}'";
$findResult = $mysqli->query($oldTrSql);
$findRow = $findResult->fetch_assoc();
$oldDebit = $findRow['TrDebit'];
$oldCredit = $findRow['TrCredit'];
}


$query1 = "SELECT CBalance FROM customers WHERE CustomerNo = '{$custID}'";
if ($result = $mysqli->query($query1)) {
	$row = $result->fetch_assoc();
	$currentBalance = $row['CBalance'];
	$newBalance = $currentBalance -$oldDebit + $oldCredit;
	$newBalance = $mysqli->real_escape_string($newBalance);
}

$trStatus = "OK";
$trStatus = $mysqli->real_escape_string($trStatus);
$desc = "Cancellation";
$desc = $mysqli->real_escape_string($desc);
$ref = $oldTrID;
$ref =  $mysqli->real_escape_string($ref);
$query2 = "INSERT INTO transactions (TrCustID,TrDebit,TrCredit,TrDescription,TrBalance,TrStatus,TrReference) " ." VALUES ('{$custID}','{$oldCredit}','{$oldDebit}','{$desc}','{$newBalance}','{$trStatus}','{$ref}')";
$query3 = "UPDATE customers SET CBalance = '{$newBalance}' WHERE CustomerNo = '{$custID}'";
$query4 = "UPDATE transactions SET TrStatus = 'Cancelled' WHERE TransactionID = '{$oldTrID}'";
if(!$mysqli->query($query3)) {
	error_log("Problem inserting {$query3}");
}
if(!$mysqli->query($query4)) {
	error_log("Problem inserting {$query4}");
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