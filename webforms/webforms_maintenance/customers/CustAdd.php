<?php require_once("../functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/register-customer.js"></script>
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
	if($user->isLoggedIn) {
		//echo 'Registration of accounts';	
		$hideform = false;	
	}
	else{
	$hideform = true;
	}
?>
<div id="hide" style="display:none;">
<table class="tableForm" style="border:1px solid black;padding:15px;margin:0 auto;">
<form id="userForm" method="POST" action="CustAddConfirm.php">

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
	<td><label for="gender">Gender:* </label></td>
	<td><select name="gender" id="gender">
	<option></option>
	<option value="M">Male</option>
	<option value="F">Female</option>
	</select>
	</td>
	<span class="errorFeedback errorSpan"
	id="emailError">Gender is required</span>
</tr>
<tr>
	<td><label for="phone">Phone Number: </label></td>
	<td><input type="text" id="phone" name="phone"/></td>
	<span class="errorFeedback errorSpan"
	id="phoneError">Format: xxx-xxx-xxxx</span>
</tr>
<tr>
	<td><label for="addr">Address: </label></td>
	<td><input type="text" id="addr" name="addr"></td>
</tr>
<tr>
	<td><label for="birthdate">Birthdate: </label></td>
	<td><input type="date" id="birthdate" name="birthdate" value="<?php echo date('Y-m-d'); ?>" /></td>
</tr>
<tr>
	<td><label for="school">School: </label></td>
	<td><input type="text" id="school" name="school"/></td>

</tr>
<tr>
	<td><label for="parent">Parent's name: </label></td>
	<td><input type="text" id="parent" name="parent"/></td>

</tr>

<tr style="display: none;">
	<td><input type="hidden" id="status" name="status"/></td>
	<td><input type="hidden" id="room" name="room"/></td>
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