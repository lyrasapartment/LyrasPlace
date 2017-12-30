<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css">
<link rel="stylesheet" type="text/css" href="../../../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../../../includes/align.css">
<title>Add Transaction Records</title>
</head>
<body>
<div  class="div2">
<?php 
include '../header2.php'; 
include('../rules.php');
include_once '../connect.php';
unset($_POST['submit']);

if(!is_numeric($_POST['TransactionID'])) {
	echo "<br><center>Access denied. Transaction record is invalid.</center>";
	echo "<meta http-equiv=\"refresh\" content=\"3; url=TrView.php\">";
}
else {
	$dc = $_POST['TransactionID'];
	if($con) {

		$safeDC = $con->real_escape_string($dc);
		$sql = "SELECT * from transactions t,customers c WHERE t.TrCustID = c.CustomerNo AND t.TransactionID = '{$safeDC}'";
		if($QueryResult = mysqli_query($con,$sql)){
			$row = $QueryResult->fetch_assoc();
		}
		$defaultTrID = $row['TransactionID'];
		$defaultCustomer = $row['TrCustID'];
		$defaultCustomerName = "" . $row['CFirstName'] . ' ' . $row['CLastName'];
		$defaultDebit = $row['TrDebit'];
		$defaultCredit = $row['TrCredit'];
		$defaultDesc = $row['TrDescription'];
		$defaultStatus = $row['TrStatus'];
		if($defaultStatus == "Cancelled") {
			echo "<br><center>Access denied. Unable to edit cancelled transactions.</center>";
			echo "<meta http-equiv=\"refresh\" content=\"3; url=TrView.php\">";
		}

	}
}


?>
<?php
	$hideform = true;
	if(is_null($user)) {
	 $user = new User;
	}
	if($user->isLoggedIn && is_numeric($_POST['TransactionID']) && $defaultStatus!="Cancelled") {
		//echo 'Registration of accounts';	
		$hideform = false;	
	}
	else{
	$hideform = true;
	}

?>

<div id="div-ctr"><br/>

<!--
<label for="uname">Username:* </label>
<input type="text" id="uname" name="uname">
<span class="errorFeedback errorSpan"
id="fnameError">First Name is required</span>
!-->
	
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
	<div id="hide" style="display:none;">
		
		<center>
		<table style="border:1px solid black;" class="tableForm">
		<form id="trEditForm" name="trEditForm" method="POST" action="TrEditConfirm.php">
			<legend><h3>EDIT TRANSACTIONS</h3></legend>
			<tr>
				<td>Transaction ID : 
				<span ><?php echo $defaultTrID; ?></span> 
				</td> 
			</tr>
	
			
			<tr>
				<td>Customer : </td>
				<td><span><?php echo $defaultCustomerName; ?></span></td>
			</tr>
			
			<tr>
				<td>Debit : </td>
				<td><span><?php echo $defaultDebit; ?></span></td>
			</tr>
			<tr>
				<td>Credit : </td>
				<td><span><?php echo $defaultCredit; ?></span></td>
			</tr>
			<tr>
				<td>Description : </td>
				<td><span><?php echo $defaultDesc; ?></span></td>
			</tr>

			<tr>
			  	<td><label for="trStatus">Status</label></td>
			  	<td><select id="trStatus" name="trStatus">
					<option value="Cancelled" selected>Cancelled</option>
			  </select></td>
			  <span class="errorFeedback errorSpan" id="trStatusError">Status is required</span>

			</tr>
		 
		  <tr>
		  	<td>
		  		<input type="hidden" name="trStatus" id="trStatus" value="<?php echo $defaultStatus; ?>" style="display:none;"/>
		  		<input type="hidden" name="defaultCustomer" id="defaultCustomer" value="<?php echo $defaultCustomer; ?>" style="display:none;"/>
				<input type="hidden" name="defaultTrID" id="defaultTrID" value="<?php echo $defaultTrID; ?>" style="display:none;"/>
		  	</td>
		  </tr>
		   <tr>		
				<td align="center" style="padding:5px;"><input type="reset" name="clear" id="clear" value="Clear Values"/></td>
				<td align="center"style="padding:5px;"><input type="submit" name="submit" id="submit" value="Cancel This Record"/></td>
		  </tr>	
					  
  </form>
  </table>
  </center>	
    
	<br/><p align="center" class="back2maintenance"><a href="../../maintenance.php">Back to Maintenance Module</a></p>
		<br /><br />
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

<script>

</script>

</html>