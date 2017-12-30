<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css">
<link rel="stylesheet" type="text/css" href="../../../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../../../includes/align.css">
<title>Home</title>
</head>
<body>
<div  class="div2">
<?php 
include('../header2.php'); 
include('../rules.php');

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

<div id="div-ctr"><br/>
	<div id="hide_show" style="display:none;">
	<table class="tableForm" style="margin-top:50px;display:;">
			<tr><td><h3><center>ADDING OF CUSTOMER RECORDS</center></h3></td></tr>
			<tr><td><a href="CustAdd.php"><div style="">Register customer</div></a></td></tr>
			<tr><td><div><a href="EmpEdit.php"><div style="">Update Customer records</div></a></div></td></tr>
			<tr><td><div><a href="CustBalanceConfirm.php"><div style="">Update All Customer Balances</div></a></div></td></tr>
	</table>
	<br/><p align="center" class="back2maintenance"><a href="../../maintenance.php">Back to the Maintenance Module</a></p>
	</div>
</div>
</div>
<?php include '../footer2.php'; ?>
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
</body>
</html>

