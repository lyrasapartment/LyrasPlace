<?php
include_once '../connect.php';

	if (isset($_POST["query"])) {
		$query = json_decode($_POST["query"]);	
	}

	$s = $query->Search;
	$d = $query->defaultCustomer;

	if($con) {
		$safeSearch = $con->real_escape_string($s);

			if($s!="") {
				$SQLQuery = "select * FROM customers c WHERE CONCAT(CFirstName,' ',CLastName) LIKE '%{$q}%' AND c.CStatus = 'Active'";
			}
					
			if($QueryResult = mysqli_query($con,$SQLQuery)){
				$rows = mysqli_fetch_all($QueryResult,MYSQLI_ASSOC);
			print json_encode($rows);
			}
			
	}
?>
