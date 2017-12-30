<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/Transactions-Add-Error.js.js"></script>
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
			<legend><h3>ADD TRANSACTIONS</h3></legend>
			<tr>
				<td>Customer Search</td> 
			  	<td><input type="text" name="trCustSearch" id="trCustSearch" maxlength="50" onchange="showUser(this.value)"/></td>
			</tr>
			
		
					<tr>
						<td ><label for="trCustIDtd">Choose a customer: </label></td>
						<td id="trCustIDtd">
						</td>
						<span id="custinfo"></span>
						<span class="errorFeedback errorSpan" id="trCustIDtdError">Customer Name is required</span>
						
					</tr>
					<input style="display:none;" type="hidden" id="trCustId2" name="trCustId2" value=""/>

			<tr>
			  	<td><label for="trDebit">Debit</label></td>
			  	<td><input type="text" name="trDebit" id="trDebit" maxlength="11" value="0.00"/></td>
				<span class="errorFeedback errorSpan" id="trDebitError">Debit is required</span>
			</tr>
			<tr>
			  	<td><label for="trCredit">Credit</label></td>
			  	<td><input type="text" name="trCredit" id="trCredit" maxlength="11" value="0.00"/></td>
				<span class="errorFeedback errorSpan" id="trCreditError">Credit is required</span>
			</tr>
			<tr>
			  	<td><label for="trDesc">Description</label></td>
			  	<td><select id="trDesc" name="trDesc">
					<option value="Payment" selected>Payment</option>
					<option value="Room Fee">Room fee</option>
					<option value="Foam Fee">Foam fee</option>
			  </select></td>
			  <span class="errorFeedback errorSpan" id="trDescError">Description is required</span>

			</tr >
			<tr class="debt">
			  	<td><label for="trDueDate">Due Date</label></td>
			  	<td><input type="date" name="trDueDate" id="trDueDate" value="<?php echo date('Y-m-d',strtotime('+30 Days')); ?>"/></td>
				<span class="errorFeedback errorSpan" id="trDueDateError">Credit is required</span>
				<td>Daily <input type="checkbox" name="daily" id="daily"> </td>
			</tr>
			<tr class="debt">
			  	<td><label for="trAllowance">Days Allowance</label></td>
			  	<td><input type="number" name="trAllowance" id="trAllowance" maxlength="3" value="5"/></td>
				<span class="errorFeedback errorSpan" id="trAllowanceError">Credit is required</span>
			</tr>
		  <tr>		
				<td align="center" style="padding:5px;"><input type="reset" name="clear" id="clear" value="Clear Values"/></td>
				<td align="center"style="padding:5px;"><input type="submit" name="submit" id="submit" value=" Add This Record"/></td>
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
	$("#daily").change( function() {		
		if(this.checked) {
			document.getElementById('trDueDate').value = "<?php echo date('Y-m-d',strtotime('+1 Days')); ?>";
    	}
    	else {
    		document.getElementById('trDueDate').value = "<?php echo date('Y-m-d',strtotime('+30 Days')); ?>";
    	}

	});
});
</script>

</html>