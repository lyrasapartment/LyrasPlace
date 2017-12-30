<?php
require_once("../includes/functions.inc");

?>
<!doctype html>
<html style="background: url('../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../includes/login.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/form.css">
<link rel="stylesheet" type="text/css" href="../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../includes/align.css">
<title>Login</title>
</head>
<body>
<div  class="div2" >
<?php include '../includes/header.php'; ?>
<div id="div-ctr" style=""><br/>

<table class="tableForm" style="">
<form id="loginForm" method="POST" action="login-process.php" style="">


<div id="errorDiv">
<?php
if (isset($_SESSION['error']) && isset($_SESSION['formAttempt'])) {
unset($_SESSION['formAttempt']);
print "Errors encountered<br />\n";
foreach ($_SESSION['error'] as $error) {
print $error . "<br />\n";
} //end foreach
} //end if
?>
</div>

<tr><td colspan="2"><h3><center>Login</center></h3></td><tr>
<tr><td colspan="2" style="visibility:hidden;"><h3><center>Login</center></h3></td></tr>
<tr>
	<td><label for="uname">Username:* </label></td>
	<td><input type="text" id="uname" name="uname"></td>
	<span class="errorFeedback errorSpan" id="emailError"><br/>Username is required</span>
</tr>
<tr>
	<td><label for="password">Password:* </label></td>
	<td><input type="password" id="password" name="password"></td>
	<span class="errorFeedback errorSpan" id="passwordError" style="position:absolute;top:200px;right:100px;"><br/>Password required</span>
</tr>
<tr><td colspan="2" style="visibility:hidden;"><h3><center>Login</center></h3></td></tr>
<tr>
	<td><a href="emailpass.php" class="link-text footer-nav"><small>Forgot your password?</small></a></td>
	<td align="right"><input type="submit" id="submit" name="submit" style="width:auto;"></td>
</tr>
<a href="register.php" class="link-text footer-nav" style="display:none;"><small>Register</small></a>

</form>
</table>

</div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>