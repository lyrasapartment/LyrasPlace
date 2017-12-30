<?php require_once("../../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/Transactions-View-Error.js"></script>
<script type="text/javascript" src="../jquery/TransactionsView_Ajax.js"></script>
<script type="text/javascript" src="../jquery/knockout-3.4.2.js"></script>
<script type="text/javascript" src="../jquery/lodash.min.js"></script>
<script type="text/javascript" src="../viewmodels/transaction-view.viewmodel.js"></script>
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
	<table class="tableForm">
		<tr>
			<td>
				<small>Customer Name/Transaction No:</small>
			</td>
			<td>
				<input type="text" name="trCustSearch" id="trCustSearch" maxlength="25" style="width:200px;"/>
			</td>
			<td>
				
			</td>
			<td>
				<small>Date from</small>
			</td>
			<td>
				<input type="date" name="trDateFrom" id="trDateFrom" value="<?php echo date('Y-m-d',strtotime('-12 Months')); ?>"/>
			</td>
			<td>
				<small>Date To</small>
			</td>
			<td>
				<input type="date" name="trDateTo" id="trDateTo" value="<?php echo date('Y-m-d',strtotime('+1 Days')); ?>"/>
			</td>
		
			<td>
				<input type="button" name="searchButton" id="searchButton" value="Search" data-bind="click: callToServer"/>
			</td>
		</tr>
	</table>
	
	<table class="trSearchTransactionsTable">
		<thead>
			<tr>
				<th>Transaction Id</th>
				<th>Customer</th>
				<th>Debit</th>
				<th>Credit</th>
				<th>Description</th>
				<th>Date</th>
				<th>Balance</th>
				<th>Status</th>
				<th>Reference #</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: displayedTransactions">
		<tr>
			<td>
				<span data-bind="text:TransactionID"></span>
			</td>
			<td>
				<span data-bind="text:CFirstName"></span>
				<span data-bind="text:CLastName"></span>
			</td>
			<td>
				<span data-bind="text:TrDebit"></span>
			</td>
			<td>
				<span data-bind="text:TrCredit"></span>
			</td>
			<td>
				<span data-bind="text:TrDescription"></span>
			</td>
			<td>
				<span data-bind="text:TrCreateDate"></span>
			</td>
			<td>
				<span data-bind="text:TrBalance"></span>
			</td>
			<td>
				<span data-bind="text:TrStatus"></span>
			</td>
			<td>
				<span data-bind="text:TrReference"></span>
			</td>
		</tr>
		</tbody>
		
		
		

		
	</table>
	<div class="tableControls">
	<table class="" style="cellspacing:0;">


		<tr class="pageControls">
			<td>
				<span>page : </span>
				<a href="javascript:void(0);" data-bind="text: page" style="text-decoration: none;color:black;"></a>
			</td>
			<td>
				<a href="javascript:void(0);" data-bind="click: goToFirstPage"><div class="pageButtons"><<</div></a>
				<a href="javascript:void(0);" data-bind="click: goToPreviousPage"><div class="pageButtons"><</div></a>
				<!-- ko foreach: pages -->
				<a  href="javascript:void(0);" data-bind="click: $parent.goToPage.bind($data)" >
					<div class="pageButtons" data-bind="text:$data" ></div>
				</a>
				<!-- /ko -->
				<a href="javascript:void(0);" data-bind="click: goToNextPage"><div class="pageButtons">></div></a>
				<a href="javascript:void(0);" data-bind="click: goToLastPage"><div class="pageButtons">>></div></a>
			</td>
			<td>
				<span>Go to page : </span>
				<input type="text" name="pageSearch" id="pageSearch" maxlength="25" style="width:100px;">
				<a href="javascript:void(0);" data-bind="click: jumpToPage"><div class="pageButtons">Go</div></a>
			</td>
		</tr>

	</table>
	<table style="margin: 0 auto;">
		<form id="trEditForm" name="trEditForm" method="POST" action="TrEdit.php">
			<tr>
				<td>
					Transaction ID : 
					<input type="text" name="TransactionID" id="TransactionID" maxlength="25" style="width:100px;">
				</td>
				<td>
					<input type="submit" name="submit" id="submit" value="Cancel Transaction">
				</td>
			</tr>
			<tr>
				<td>
					<span class="errorFeedback errorSpan" id="TransactionIDError">Transaction ID is required</span>
				</td>
			</tr>
		</form>
	</table>
	
	</div>
		<div id="searchForTr">
		
		</div>
		<input type="hidden" name="trCustId2" id="trCustId2" value="trCustId2" style="width:100px;"/>
    
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