<!doctype html>
<html>
<head>
</head>
<body>
<?php
include('../rules.php');
include_once '../connect.php';
$q = $_GET['q'];
	

	if($con) {
		$SQLQuery = "select * FROM customers WHERE CustomerNo = '{$q}'";
		$result = mysqli_query($con, $SQLQuery);
		//$result = $mysqli->query($SQLQuery);
		$row = $result->fetch_assoc();
		$fullname = $row['CFirstName'] . ' ' . $row['CLastName'];
		$status = $row['CStatus'];
		$currentBalance = $row['CBalance'];
		$room = $row['CRoomNo'];
		echo "<div style=\"position:absolute;top:180px;left:70%;\">";
		echo "<table class=\"tableDesign\">";
		echo "<tr><td><b>Customer Information :</b></tr></td>";
		echo "<tr><td>name : " . $fullname . "</td></tr>";
		echo "<tr><td>status : " . $status . "</td></tr>";
		echo "<tr><td>room : " . $room . "</td></tr>";
		echo "<tr><td>balance : " . $currentBalance . "</td></tr>";
		echo "</table";
	}	
	
	

	
mysqli_close($con);
?>

</body>
</html>