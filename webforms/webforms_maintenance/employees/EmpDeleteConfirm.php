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
    <title>DELETING OF EMPLOYEE RECORDS</title>
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
		<h1><p align="center"><strong>DELETE AN EMPLOYEE RECORD</strong></p></h1>	
		<?php
			if($con) {
				//accept the value of empSSSno from EmpDelete.php and store it in $var_empSSSno
				$var_empSSSno = $_POST['empSSSno'];
				
				//get the first and last name of the employee
				$SQLQuery = "select EFirstName, ELastName from employee where SSSNo = '$var_empSSSno'";
				$result = mysqli_query($con, $SQLQuery);
		
				//place the values of this tuple/record in a temporary placeholder $object
				$object = mysqli_fetch_object($result);
		
				//assign the values to local variables $var_empfirstname and $var_emplastname
				//use these values in the informative message to the user -- "The record ___ has been deleted." 
				$var_empfirstname = $object->EFirstName;
				$var_emplastname = $object->ELastName; 

				$numrows = mysqli_num_rows($result);			
				if ($numrows > 0) {
					$SQLQuery = "delete from employee where SSSNo = '$var_empSSSno'";
					mysqli_query($con, $SQLQuery);
					echo '<p align="center"><font color="blue" size="+1">The employee record '.$var_empfirstname.' '.$var_emplastname.' has been deleted.</font></p>';
				}
				
				mysqli_close($con);
			}
		?>
		
		<br />	
		<p align="center"><a href="maintenance.php">Back to Maintenance Module</a></p>
		<br /><br />
	</div>
	<?php
		include 'footer.php';
	?>
</body>
</html>