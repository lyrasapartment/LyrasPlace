<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/TrAdd_Ajax.js"></script>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css">
<link rel="stylesheet" type="text/css" href="../../../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../../../includes/align.css">
<title>Add Transaction Records</title>
</head>
<body>
<div  class="div2">
<?php 
include '../header2.php'; 
include_once '../connect.php';
?>
<div id="div-ctr"><br/>

<!--
<label for="uname">Username:* </label>
<input type="text" id="uname" name="uname">
<span class="errorFeedback errorSpan"
id="fnameError">First Name is required</span>
!-->

	<center>
	<h3>Added a new transaction</h3>
	</center>	
  <br/><p align="center"><a href="TrAdd.php">Add another transaction</a></p>
		<br /><br />

		
		
		

</div>
</div>
			<span id="custinfo">
		
			</span>
<?php include '../footer2.php'; ?>

</body>
</html>