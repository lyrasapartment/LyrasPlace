<?php require_once("../functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../../../includes/register.js"></script>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css"/>
<link rel="stylesheet" type="text/css" href="../footer.css"/>
<link rel="stylesheet" type="text/css" href="../../../includes/align.css"/>
<title>A form</title>
</head>
<body>
<div  class="div2">
<?php include '../header2.php'; 
include('../rules.php');
?>

<div id="div-ctr"><br/>

<?php
	$hideform = true;
	if(is_null($user)) {
	 $user = new User;
	}
	if($user->isAdmin) {
		//echo 'Registration of accounts';	
		$hideform = false;	
	}
	else{
	$hideform = true;
	}
?>
<div id="hide" style="display:none;">
<table class="tableForm" style="border:1px solid black;padding:15px;margin:0 auto;">
<form id="userForm" method="POST" action="EmpConfirm.php">

<div id="errorDiv"><?php
if (isset($_SESSION['error']) && isset($_SESSION['formAttempt'])) {
unset($_SESSION['formAttempt']);
print "Errors encountered<br />\n";
foreach ($_SESSION['error'] as $error) {
print $error . "<br />\n";
} //end foreach
} //end if
?></div>
<tr><td colspan="2"><h3><center>Add a new moderator</center></h3></td><tr>
<tr>
	<td><label for="uname">Username:* </label></td>
	<td><input type="text" id="uname" name="uname"/></td>
	<span class="errorFeedback errorSpan"
	id="unameError">Username is required</span>
</tr>
<tr>
	<td><label for="fname">First Name:* </label></td>
	<td><input type="text" id="fname" name="fname"/></td>
	<span class="errorFeedback errorSpan"
	id="fnameError">First Name is required</span>
</tr>
<tr>
	<td><label for="lname">Last Name:* </label></td>
	<td><input type="text" id="lname" name="lname"/></td>
	<span class="errorFeedback errorSpan"
	id="lnameError">Last Name is required</span>
</tr>
<tr>
	<td><label for="email">E-mail Address:* </label></td>
	<td><input type="text" id="email" name="email"/></td>
	<span class="errorFeedback errorSpan"
	id="emailError">E-mail is required</span>
</tr>
<tr>
	<td><label for="accountType">Account Type:* </label></td>
	<td><select name="accountType" id="accountType">
	<option></option>
	<option value="Admin">Admin</option>
	<option value="Employee">Employee</option>
	</select>
	</td>
	<span class="errorFeedback errorSpan"
	id="emailError">Account Type is required</span>
</tr>
<tr>
	<td><label for="password1">Password:* </label></td>
	<td><input type="password" id="password1" name="password1"/></td>
	<span class="errorFeedback errorSpan"
	id="password1Error">Password required</span>
</tr>
<tr>
	<td><label for="password2">Verify Password:* </label></td>
	<td><input type="password" id="password2" name="password2"/></td>
	<span class="errorFeedback errorSpan"
	id="password2Error">Passwords don't match</span>
</tr>
<tr>
	<td><label for="addr">Address: </label></td>
	<td><input type="text" id="addr" name="addr"></td>
</tr>
<tr>
	<td><label for="phone">Phone Number: </label></td>
	<td><input type="text" id="phone" name="phone"/></td>
	<span class="errorFeedback errorSpan"
	id="phoneError">Format: xxx-xxx-xxxx</span>
</tr>
<tr>
<td colspan="2" align="right" ><input style="margin-right:20%;"type="submit" id="submit" name="submit" value="submit" onclick="return confirm('Are you sure?')"/></td>
</tr>
<tr>
	<td colspan="2"><label for="activeaccount"><font style="font-size:12px;">Already have an account?</font></label>
	<label for="login">
	<a href="../../login.php" class="link-text footer-nav"><small>Click here to login</small></a></td>
</label>
</tr>

</form>
</table>
<br/>
<p align="center" class="back2maintenance"><a href="../../maintenance.php">Back to the Maintenance Module</a></p>
</div>

</div>
</div>

<?php include '../footer2.php'; ?>
<?php 
	if(!$hideform) {
	?>
	<script type="text/javascript">
		document.getElementById('hide').style.display = 'block';
	</script>
	<?php
	} else {
	?>
	<script type="text/javascript">
		document.getElementById('hide').style.display = 'none';
	</script>
	<?php
	}
		
?>
</body>

</html>