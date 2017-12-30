<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User {
public $id;
public $email;
public $firstName;
public $lastName;
public $phone;
public $isLoggedIn = false;
public $isAdmin = false;
public $isModerator = false;
public $errorType = "fatal";


function __construct() {
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
$this->_initUser();
}
} //end __construct


public function authenticate($user,$pass) {
if (session_id() == "") {
session_start();
}
$_SESSION['isLoggedIn'] = false;
$this->isLoggedIn = false;
$_SESSION['isAdmin'] = false;
$this->isAdmin = false;
$_SESSION['isModerator'] = false;
$this->isModerator = false;

$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " .$mysqli->connect_error);
return false;
}
$safeUser = $mysqli->real_escape_string($user);
$incomingPassword = $mysqli->real_escape_string($pass);
$query = "SELECT * from accounts WHERE AccountID = '{$safeUser}' OR AccEmail = '{$safeUser}'";
if (!$result = $mysqli->query($query)) {
error_log("Cannot retrieve account for {$user}");
return false;
}
// Will be only one row, so no while() loop needed
$row = $result->fetch_assoc();
$dbPassword = $row['AccountPass'];
if (crypt($incomingPassword,$dbPassword) != $dbPassword) {
error_log("Passwords for {$user} don't match");
$errorpass = crypt($incomingPassword,$dbPassword);
error_log("" . crypt($incomingPassword,$dbPassword) . " !=  {$dbPassword}");
return false;
}

$this->id = $row['AccountID'];
$this->email = $row['AccEmail'];
$this->firstName = $row['AFirstName'];
$this->lastName = $row['ALastName'];
$this->phone = $row['AContactNo'];
$this->isLoggedIn = true;
if($row['AccountType']=="Admin") {
	$this->isAdmin = true;
	$this->isModerator = false;
}
else if($row['AccountType']=="Employee"){
	$this->isAdmin = false;
	$this->isModerator = true;
}
else {
	$this->isAdmin = false;
	$this->isModerator = false;
}
$this->_setSession();
return true;
} //end function authenticate

//set session, if session id is empty then session start; assign each Session index to the value of each variable 
private function _setSession() {
if (session_id() == '') {
session_start();
}
$_SESSION['id'] = $this->id;
$_SESSION['email'] = $this->email;
$_SESSION['firstName'] = $this->firstName;
$_SESSION['lastName'] = $this->lastName;
$_SESSION['phone'] = $this->phone;
$_SESSION['isLoggedIn'] = $this->isLoggedIn;
$_SESSION['isAdmin'] = $this->isAdmin;
$_SESSION['isModerator'] = $this->isModerator;
} //end function setSession

//init user, if session id is empty then session start; assign each variable to the Session index values
private function _initUser() {
if (session_id() == '') {
session_start();
}

$this->id = $_SESSION['id'];
$this->email = $_SESSION['email'];
$this->firstName = $_SESSION['firstName'];
$this->lastName = $_SESSION['lastName'];
$this->phone = $_SESSION['phone'];
$this->isLoggedIn = $_SESSION['isLoggedIn'];
$this->isAdmin = $_SESSION['isAdmin'];
$this->isModerator = $_SESSION['isModerator'];
} //end function initUser


public function logout() {
$this->isLoggedIn = false;
if (session_id() == '') {
session_start();
}
$_SESSION['isLoggedIn'] = false;
$_SESSION['isAdmin'] = false;
$_SESSION['isModerator'] = false;
foreach ($_SESSION as $key => $value) {
	$_SESSION[$key] = "";
unset($_SESSION[$key]);
}
$_SESSION = array();
if (ini_get("session.use_cookies")) {
$cookieParameters = session_get_cookie_params();
setcookie(session_name(), '', time() - 28800,
$cookieParameters['path'],$cookieParameters['domain'],
$cookieParameters['secure'],$cookieParameters
['httponly']
);
} //end if
session_destroy();
} //end function logout


public function emailPass($user) {
$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
return false;
}
// first, lookup the user to see if they exist.
$safeUser = $mysqli->real_escape_string($user);
$query = "SELECT AccountID,AccEmail,AFirstName,ALastName FROM accounts WHERE AccEmail ='{$safeUser}'";
if (!$result = $mysqli->query($query)) {
$_SESSION['error'][] = "Unknown Error";
return false;
}

if ($result->num_rows == 0) {
$_SESSION['error'][] = "User not found";
return false;
}

$row = $result->fetch_assoc();
$id = $row['AccountID'];
$Nm = $row['AFirstName'] . " " . $row['ALastName'];
$hash = uniqid("",TRUE);
$safeHash = $mysqli->real_escape_string($hash); //removes special characters to not cause errors on the query
$insertQuery = "INSERT INTO resetpassword (RAccountID,Rpass_key,Rdate_created,RStatus) VALUES ('{$id}','{$safeHash}',NOW(),'A')";
if (!$mysqli->query($insertQuery)) {
error_log("Problem inserting reset Password row for " . $id);
$_SESSION['error'][] = "Unknown problem";
return false;
}
$urlHash = urlencode($hash);
$site = "https://lyrasplace.000webhostapp.com/";
$resetPage = "LyrasPlace/webforms/reset.php";
$fullURL = $site . $resetPage . "?user=" . $urlHash;
//set up things related to the e-mail
$to = $row['AccEmail'];
$subject = "Password Reset for Site";
$message = "Password reset requested for this site.\r\n\r\n";
$message .= "Please go to this link to reset your password:\r\n";
$message .= $fullURL;
$headers = "From: lyrasapartment@gmail.com\r\n";
//mail($to,$subject,$message,$headers);

//require_once("../includes/unused/PHPMailer1/class.SMTP.php");
//require '../includes/unused/PHPMailer52/PHPMailerAutoload.php';

require '../includes/unused/PHPMailer/src/Exception.php';
require '../includes/unused/PHPMailer/src/PHPMailer.php';
require '../includes/unused/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);   
                     // Passing `true` enables exceptions
	try{
    //Server settings
	$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
	);
	//$mail->CharSet = 'UTF-8'; 
	//$mail->SMTPDebug = 2;	
	//$mail->Debugoutput = 'html';
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = "smtp.gmail.com";					  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;    
	
    $mail->Username = MailEmail;        // SMTP username
    $mail->Password = MailPass;                           // SMTP password
    $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(MailEmail, MailName);
    $mail->addAddress($to,$Nm);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->IsHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;
	
	$mail->Send();
	echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
	/*
    if(!$mail->Send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit;
	}
	else {
		echo 'Message has been sent';
	} */
	return true;
	
} //end function emailPass

public function validateReset($formInfo) {
$pass1 = $formInfo['password1'];
$pass2 = $formInfo['password2'];
if ($pass1 != $pass2) {
$this->errorType = "nonfatal";
$_SESSION['error'][] = "Passwords don't match";
return false;
}
$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
return false;
}
$decodedHash = urldecode($formInfo['hash']);
$safeEmail = $mysqli->real_escape_string($formInfo['email']);
$safeHash = $mysqli->real_escape_string($decodedHash);
$query = "SELECT c.AccountID as id, c.AccEmail as email FROM accounts c, resetpassword r WHERE " . "r.RStatus = 'A' AND r.Rpass_key = '{$safeHash}' "." AND c.AccEmail = '{$safeEmail}' " ." AND c.AccountID = r.RAccountID";
if (!$result = $mysqli->query($query)) {
$_SESSION['error'][] = "Unknown Error";
$this->errorType = "fatal";
error_log("database error: " . $formInfo['email']. " - " . $formInfo['hash']);
return false;
} else if ($result->num_rows == 0) {
$_SESSION['error'][] = "Link not active or user not found";
$this->errorType = "fatal";
error_log("Link not active: " . $formInfo['email'] . " - " . $formInfo['hash']);
return false;
} else {
$row = $result->fetch_assoc();
$id = $row['id'];
if ($this->_resetPass($id,$pass1)) {
$query2 = "UPDATE resetpassword SET RStatus = 'B' ". "WHERE Rpass_key ='{$safeHash}'" . " AND RAccountID = '{$id}'";
	if (!$mysqli->query($query2)) {
		echo "Error updating record: " . mysqli_error($mysqli);
		return false;
	}
	else {
		
		echo "Record updated successfully";
		return true;
	}

} else {
$this->errorType = "nonfatal";
$_SESSION['error'][] = "Error resetting password";
error_log("Error resetting password: " . $id);
return false;
}
}
} //end function validateReset

private function _resetPass($id,$pass) {
$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " . $mysqli->connect_error);
return false;
}
$safeUser = $mysqli->real_escape_string($id);
$newPass = crypt($pass);
$safePass = $mysqli->real_escape_string($newPass);
$query = "UPDATE accounts SET AccountPass = '{$safePass}' ". "WHERE AccountID ='{$safeUser}'";
if (!$mysqli->query($query)) {
return false;
} else {
return true;
}
} //end function _resetPass
} //end class User
?>