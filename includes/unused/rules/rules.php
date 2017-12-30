<?php
	switch (basename($_SERVER['PHP_SELF'])) {
		case "register.php":
		case "emailpass.php":
			if (!$user->isAdmin) {
				echo "<br><center>Access denied. Only Administrators can access this page.</center>";
				echo "<meta http-equiv=\"refresh\" content=\"3; url=index.php\">";
			} 
			break;
		case "maintenance.php":
			if (!$user->isLoggedIn) {
				echo "<br><center>Access Denied. You are not logged in.</center>";
				echo "<meta http-equiv=\"refresh\" content=\"3; url=index.php\">";
			} 
			break;
		default:break;
	}
	
?>