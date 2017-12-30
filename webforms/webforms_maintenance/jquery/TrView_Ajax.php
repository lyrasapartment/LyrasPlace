<?php
include_once '../connect.php';

	if (isset($_POST["query"])) {
		$query = json_decode($_POST["query"]);	
	}

	$s = $query->Search;
	$d1 = $query->DateFrom;
	$d2 = $query->DateTo;
	//$opt = $query->Options;
	//$start = $query->Start;
	//$end = $query->End;
	//$all = $query->All;

	if($con) {
		$safeSearch = $con->real_escape_string($s);
		$safeDateFrom = $con->real_escape_string($d1);
		$safeDateTo = $con->real_escape_string($d2);
		//$safeOptions = $con->real_escape_string($opt);
		//$safeStart = $con->real_escape_string($start);
		//$safeEnd = $con->real_escape_string($end);
		//$row = 0;

		if($s == "") {
			$SQLQuery = "SELECT * FROM transactions t,customers c WHERE t.TrCreateDate BETWEEN '" . $safeDateFrom . "' AND  '" . $safeDateTo . "'".
			" AND t.TrCustID = c.CustomerNo";
	
		}
		else {
			$SQLQuery = "SELECT * FROM transactions t,customers c WHERE t.TrCreateDate BETWEEN '" . $safeDateFrom . "' AND  '" . $safeDateTo . "'".
			" AND t.TrCustID = c.CustomerNo AND ((CONCAT(c.CFirstName,' ',c.CLastName) LIKE '%{$safeSearch}%')  OR  (t.TransactionID  LIKE '%{$safeSearch}%'))";

		}

		
			
		if($QueryResult = mysqli_query($con,$SQLQuery)){
			$rows = mysqli_fetch_all($QueryResult,MYSQLI_ASSOC);
		print json_encode($rows);
		}
		else {
			error_log("Problem $safeStart : " . $safeStart);
		}

	


	}
?>
