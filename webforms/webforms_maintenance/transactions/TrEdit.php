<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/Transactions-Edit-Error.js.js"></script>
<script type="text/javascript" src="../jquery/Transactions_Ajax.js"></script>
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

}


?>
<?php
	$hideform = true;
	if(is_null($user)) {
	 $user = new User;
	}
	if($user->isAdmin && $defaultStatus!="Cancelled") {
		//echo 'Registration of accounts';	
		$hideform = false;	
	}
	else{
	$hideform = true;
	}


	if ($defaultStatus=="Cancelled") {
			echo "<br><center>Access denied. You cannot edit cancelled transactions.</center>";
			echo "<meta http-equiv=\"refresh\" content=\"3; url=../../index.php\">";
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
		<table style="border:1px solid black;auto;" class="tableForm">
		<form id="trAddForm" name="trAddForm" method="POST" action="TrAddConfirm.php">
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
			  	<td><label for="trDebit">Debit</label></td>
			  	<td><input type="text" name="trDebit" id="trDebit" maxlength="11" value="<?php echo $defaultDebit; ?>"/></td>
				<span class="errorFeedback errorSpan" id="trDebitError">Debit is required</span>
			</tr>
			<tr>
			  	<td><label for="trCredit">Credit</label></td>
			  	<td><input type="text" name="trCredit" id="trCredit" maxlength="11" value="<?php echo $defaultCredit; ?>"/></td>
				<span class="errorFeedback errorSpan" id="trCreditError">Credit is required</span>
			</tr>
			<tr>
			  	<td><label for="trDesc">Description</label></td>
			  	<td><select id="trDesc" name="trDesc">
					<option value="Payment">Payment</option>
					<option value="Room Fee">Room fee</option>
					<option value="Foam Fee">Foam fee</option>
			  </select></td>
			  <span class="errorFeedback errorSpan" id="trDescError">Description is required</span>

			</tr>

			<tr>
			  	<td><label for="trStatus">Status</label></td>
			  	<td><select id="trStatus" name="trStatus">
					<option value="OK" selected >OK</option>
					<option value="Cancelled">Cancelled</option>
			  </select></td>
			  <span class="errorFeedback errorSpan" id="trStatusError">Status is required</span>

			</tr>
		  <tr>		
				<td align="center" style="padding:5px;"><input type="reset" name="clear" id="clear" value="Clear Values"/></td>
				<td align="center"style="padding:5px;"><input type="submit" name="submit" id="submit" value="Edit This Record"/></td>
		  </tr>	
		  <tr>
		  	<td>
		  		<input type="hidden" name="defaultCustomer" id="defaultCustomer" value=<?php echo "\"$defaultCustomer\""  ?> style="display:none;"/>
				<input type="hidden" name="defaultTrID" id="defaultTrID" value=<?php echo "\"$defaultTrID\""  ?> style="display:none;"/>
		  	</td>
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
	$(document).ready(function() {
		var x = "<?php echo $defaultDesc ?>";
		switch(x) {
			case "Payment": x = 0;
			$( "#trDebit" ).prop( "disabled", true );
			$( "#trCredit" ).prop( "disabled", false );
			break;
			case "Room Fee": x = 1;
			$( "#trDebit" ).prop( "disabled", false );
			$( "#trCredit" ).prop( "disabled", true );
			break;
			case "Foam Fee":
			$( "#trDebit" ).prop( "disabled", false );
			$( "#trCredit" ).prop( "disabled", true );
			 x = 2;break;
			default: break;
		}

		var e = document.getElementById("trDesc");
		e.selectedIndex = x;
	});
</script>

</html>