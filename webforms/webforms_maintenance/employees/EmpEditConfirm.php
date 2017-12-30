<?php
	 session_start();
	 if ($_SESSION['login'] != '1') {
	 	session_destroy();
	 	header("Location:login.php");
	 } 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Wed, 31 Aug 2016 00:01:48 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>EDITING OF EMPLOYEE RECORDS</title>
  <link rel="stylesheet" href="css/coffeegrinder.min.css">
  <link rel="stylesheet" href="css/wireframe-theme.min.css">
  <script>document.createElement( "picture" );</script>
  <script src="js/picturefill.min.js" class="picturefill" async="async"></script>
  <link rel="stylesheet" href="css/main.css">
  </head>
  
<body>
	<?php
		include 'header.php';
		include_once 'connect.php';
	?>
	<div id="container">
		<br /><br />
		<h1><p align="center"><strong>EDIT AN EMPLOYEE RECORD</strong></p></h1>
			
		<?php

			if($con) {
				$var_empsssno = $_POST['empsssno'];
				$var_empfname = $_POST['empfname'];
				$var_emplname = $_POST['emplname'];
				$var_empaddress = $_POST['empaddress'];
				$var_empzcode = $_POST['empzcode'];
				$var_empbdate = $_POST['empbdate'];
				$var_empage = $_POST['empage'];	
				$var_empstatus = $_POST['empstatus'];				
				$var_empfee = $_POST['empfee'];
				$var_empsalary = $_POST['empsalary'];
				$var_emprateperhour = $_POST['emprateperhour'];
				$var_empdeptno = $_POST['empdeptno'];		

				$SQLQuery = "select * from employee";				
				$QueryResult = mysqli_query($con, $SQLQuery);
				$numrows = mysqli_num_rows($QueryResult);

				if ($numrows > 0) {
					$SQLQuery = "UPDATE employee SET EFirstName='$var_empfname', ELastName='$var_emplname',
					CityAddress='$var_empaddress', EZipCode='$var_empzcode', EBirthdate='$var_empbdate', EAge='$var_empage',
					EmpStatus='$var_empstatus', Fee='$var_empfee', Salary='$var_empsalary', RatePerHour='$var_emprateperhour',EDeptNo='$var_empdeptno'
					WHERE SSSNo='$var_empsssno'";
					mysqli_query($con, $SQLQuery);
					echo '<p align="center"><font color="blue" size=+1>The record has been updated.</font></p>';
				}
				mysqli_close($con);
			}
		?>
			
		<p align="center"><a href="maintenance.php">Back to Maintenance Module</a></p>
		<br /><br />
		
	</div>
	<?php
			include 'footer.php';
	?>
</body>
</html>