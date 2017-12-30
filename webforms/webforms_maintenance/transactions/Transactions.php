<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css">
<link rel="stylesheet" type="text/css" href="../../../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../../../includes/align.css">
<title>Transaction Records</title>
</head>
<body>
<div  class="div2">
<?php 
include('../header2.php'); 
include('../rules.php');
require_once('../connect.php');
?>
<div id="div-ctr"><br/>

	<table class="tableForm" style="margin-top:50px;">
			<tr><td><h3><center>ADDING OF TRANSACTION RECORDS</center></h3></td></tr>
			<tr><td><a href="TrAdd.php"><div style="">Add a new transaction</div></a></td></tr>
			<tr><td><div><a href="TrView.php"><div style="">View transactions</div></a></div></td></tr>
	</table>
	<br/><p align="center" class="back2maintenance"><a href="../../maintenance.php">Back to the Maintenance Module</a></p>

</div>
</div>
<?php include '../footer2.php'; ?>
</body>
</html>

