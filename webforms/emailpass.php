<?php require_once("../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../includes/email.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/form.css">
<link rel="stylesheet" type="text/css" href="../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../includes/align.css">
<title>Forgotten Credentials</title>
</head>
<body>
<div  class="div2">
<?php include '../includes/header.php'; ?>
<?php include '../includes/unused/rules/rules.php'; ?>
<?php
	$hideform = true;
	$user = new User;
	if($user->isAdmin) {
		//echo 'Registration of accounts';	
		$hideform = false;	
	}
	else{
	$hideform = true;
	}
?>
<div id="div-ctr"><br/>

<div id="hide" style="display:none;">
<table class="tableForm" style="border:1px solid black;padding:15px;margin:0 auto;">
<form id="emailForm" method="POST" action="email-process.php">
<div>

<tr><td colspan="2"><h3><center>Password Recovery</center></h3></td><tr>
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

<tr>
	<td><label for="email">E-mail Address:* </label></td>
	<td><input type="text" id="email" name="email"/></td>
	<span class="errorFeedback errorSpan" id="emailError">Email is required</span>
</tr>
<tr>
	<td colspan="2" align="right"><input type="submit" id="submit" name="submit"></td>
</tr>
</div>
</form>
</table>
</div>

</div>
</div>
<?php include '../includes/footer.php'; ?>
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