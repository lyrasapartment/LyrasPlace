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

function UpdateCustomer() {

$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
return false;
}

$curtime = time();

$SQLQuery = "SELECT * FROM customers c, transactions t WHERE c.CustomerNo = t.TrCustID AND c.CStatus = 'Active' AND t.TrStatus == 'Unpaid' AND c.CRate == 'Monthly' ";
$QueryResult = mysqli_query($mysqli, $SQLQuery);
$numrows = mysqli_num_rows($QueryResult);
	while ($object = mysqli_fetch_object($QueryResult)) {
		$cID = $object->TrCustID;
		$tID = $object->TransactionID;
		$dd =  $object->TrDueDate;
		$allowance = $object->TrAllowance;
		if(is_null($allowance)) {
			$allowance = 0;
		}
		$daysAllowance = "+". $allowance . " days";
		$dd = strtotime($daysAllowance, $dd);

		if($curtime > $dd) {
			if(!AddInterest($tID,$cID)) {
				error_log("Problem Adding Interest.");
			}
		}
	}
}

function AddInterest($tID,$custNo) {
	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
	error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
	return false;
	}

	$oldTrID = $mysqli->real_escape_string($tID);
	$oldTrSql = "SELECT * FROM transactions WHERE TransactionID = '{$oldTrID}'";
	$findResult = $mysqli->query($oldTrSql);
	$findRow = $findResult->fetch_assoc();
	$Debit = $findRow['TrDebit'];
	$Credit = 0;
	$Interest = $Debit*5/100;
	}

	$query1 = "SELECT CBalance FROM customers WHERE CustomerNo = '{$custNo}'";
	if ($result = $mysqli->query($query1)) {
		$row = $result->fetch_assoc();
		$currentBalance = $row['CBalance'];
		$newBalance = $currentBalance +$Interest;
		$newBalance = $mysqli->real_escape_string($newBalance);
		if(UpdateCustBalance($custNo,$newBalance)) {
			$custNo = $mysqli->real_escape_string($custNo);
			$Debit = $mysqli->real_escape_string($Debit);
			$Credit = $mysqli->real_escape_string($Credit);

			$query2 = "INSERT INTO transactions (TrCustID,TrDebit,TrCredit,TrDescription,TrBalance,TrStatus,TrReference) " ." VALUES ('{$custNo}','{$Debit}','{$Credit}','Surcharge','{$newBalance}','OK','{$oldTrID}')";
			if(!$mysqli->query($query2)) {
				error_log("Problem inserting {$query2}");
				return false;
			}
			else {
				return true;
			}		
		}
		else {
			error_log("Problem Updating Customer Balance.");
			return false;
		}
	}

}



function UpdateCustBalance($custNo,$newBalance) {

	$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	if ($mysqli->connect_errno) {
	error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
	return false;
	}

	$query3 = "UPDATE customers SET CBalance = '{$newBalance}' WHERE CustomerNo = '{$custNo}'";
	if(!$mysqli->query($query3)) {
		error_log("Problem inserting {$query3}");
		return false;
	}
	else {
		return true;
	}
}


?>