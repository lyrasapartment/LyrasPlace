<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../includes/form.css">
<script type="text/javascript" src="../transactions/Transactions.js"></script>
</head>
<body>
<?php
include_once '../connect.php';
$q = $_GET['q'];
				
	echo "<select name=\"trCustId\" id=\"trCustId\" onchange=\"showUser2(this.value)\"  onclick=\"showUser2(this.value)\">";
												
	if($con) {

		$SQLQuery = "select * FROM customers c WHERE CONCAT(CFirstName,' ',CLastName) LIKE '%{$q}%' AND c.CStatus = 'Active'";
		$QueryResult = mysqli_query($con, $SQLQuery);
		$numrows = mysqli_num_rows($QueryResult);
		while ($object = mysqli_fetch_object($QueryResult)) {
					echo '<option value="'.$object->CustomerNo.'">'.$object->CFirstName.' '.$object->CLastName.'</option>';
		}
	}
	else {
    die('Could not connect: ' . mysqli_error($con));
	}
	echo "</select>";
	
mysqli_close($con);
?>

</body>
</html>