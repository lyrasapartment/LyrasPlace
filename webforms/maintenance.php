<?php
require_once("../includes/functions.inc");
?><!doctype html>
<html style="background: url('../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/form.css">
<link rel="stylesheet" type="text/css" href="../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../includes/align.css">

<title>Maintenance</title>
</head>
<body>
<div  class="div2"><?php include '../includes/header.php'; 
?><div id="div-ctr"><br/>

<div>


</div>
<div><?php 
	include '../includes/unused/rules/rules.php';
	?>
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
		<div id="hide_show" style="display:none;">
		<table class="tableForm" style="margin-top:50px;">
		<tr><td><h3><center>Maintenance</center></h3></td></tr>
		<tr><td><a href="webforms_maintenance/employees/Employees.php"><div style="">Manage Employees</div></a></td></tr>
		<tr><td><div><a href="webforms_maintenance/transactions/Transactions.php">Manage Transactions</a></div></td></tr>
		<tr><td><div><a href="webforms_maintenance/customers/Customers.php">Manage Customers</a></div></td></tr>
		</table>
		</div>
	
</div>
</div>
</div><?php include '../includes/footer.php'; ?></body>
<?php 
	if(!$hideform) {
	?>
	<script type="text/javascript">
		document.getElementById('hide_show').style.display = 'block';
	</script>
	<?php
	} else {
	?>
	<script type="text/javascript">
		document.getElementById('hide_show').style.display = 'none';
	</script>
	<?php
	}
		
?>
</html>
