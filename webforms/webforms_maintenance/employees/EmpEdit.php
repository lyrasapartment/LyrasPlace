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
		<center>
		<form action="EmpEditTest.php" method="POST" style="width:80%;">
			<table align="center">		
		<?php
			
			if($con) {
				$SQLQuery = "select * from employee";
				$QueryResult = mysqli_query($con, $SQLQuery);
		?>
				<tr>
					<td align="right">Choose the Employee: </td>
					<td><select name="empsssno" id="empsssno">
		<?php
				while ($deptobject = mysqli_fetch_object($QueryResult)) {
					echo '<option value="'.$deptobject->SSSNo.'">'.$deptobject->SSSNo.' - '.$deptobject->EFirstName.' '.$deptobject->ELastName.'</option>';
				}
		?>
						</select>
					</td>
		<?php
			}
			mysqli_close($con);
		?>
				<td><input type="submit" name="submit" value="Display the details of this record."/></td>
			</table>
		</form>
		</center>
		<br />
		<p align="center"><a href="maintenance.php">Back to the Maintenance Module</a></p>
		<br /><br />
	</div>
	
	<?php
			include 'footer.php';
	?>
</body>
</html>