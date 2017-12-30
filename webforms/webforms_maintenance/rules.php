<?php
	require_once("../functions.inc");
	
	function sayError($errorNo) {
		$user = new User;
		switch($errorNo) {
			case 1:
			if (!$user->isAdmin) {
				echo "<br><center>Access denied. Only Administrators can access this page.</center>";
				echo "<meta http-equiv=\"refresh\" content=\"3; url=../../index.php\">";
			} 
			break;
			case 2:
			if (!$user->isLoggedIn) {
			echo "<br><center>Access denied. You are not logged in.</center>";
			echo "<meta http-equiv=\"refresh\" content=\"3; url=../../index.php\">";
			}
			break;
			default:break;
		}
		
	}
	switch (basename($_SERVER['PHP_SELF'])) {
		
		case "Employees.php":
		case "EmpAdd.php":
		case "EmpDelete.php":
		case "EmpEdit.php":
		case "EmpEditTest.php":
		case "EmpView.php":
		case "TrEdit.php":
		case "TrEditTest.php":
				sayError(1);
				break;
		case "TrAdd.php":
		case "TrAddConfirmSuccess.php":
		case "Transactions.php":
		case "TrView.php":
		case "TrAdd_Ajax.php":
		case "TrAdd_Ajax2.php":
		case "CustAdd.php":
		case "CustAddConfirmSuccess.php":
				sayError(2);
				break;
		default:break;
	}
	
?>