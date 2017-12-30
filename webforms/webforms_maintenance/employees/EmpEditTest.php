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

		<br><br>
		<h1><p align="center"><strong>EDIT AN EMPLOYEE RECORD</strong></p></h1>
		<?php

			if($con) {
				$var_empsssno = $_POST['empsssno'];
				$SQLQuery = "SELECT * FROM employee WHERE SSSNo='$var_empsssno'";
				$QueryResult = mysqli_query($con, $SQLQuery);
				$object = mysqli_fetch_object($QueryResult);
		?>
		<center>
		<form action="EmpEditConfirm.php" method="POST" style="width:80%">
			<table cellpadding="5" align="center">
				<tr>
					<td> </td>
					<td align="center"><strong><em>Current Data</em></strong></td>
					<td align="center"><strong><em>Data to Edit</em></strong></td>
				</tr>
				
				<tr>
					<td>SSS No.:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" name="empsssno" id="empsssno" readonly="true" value="'.$object->SSSNo.'"></td>';
		?>
				</tr>
				
				<tr>
					<td>First Name:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->EFirstName.'"></td>';
		  			echo '<td><input type="text" name="empfname" id="empfname2" value="'.$object->EFirstName.'"></td>';
		?>

				</tr>
				<tr>
					<td>Last Name:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->ELastName.'"></td>';
		  			echo '<td><input type="text" name="emplname" id="emplname2"  value="'.$object->ELastName.'"></td>';
		?>

				</tr>
				<tr>
					<td>City Address:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->CityAddress.'"></td>';
		  			echo '<td><input type="text" name="empaddress" id="empaddress2"  value="'.$object->CityAddress.'"></td>';
		?>

				</tr>
				<tr>
					<td>Zip Code:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->EZipCode.'"></td>';
		  			echo '<td><input type="text" name="empzcode" id="empzcode2"  value="'.$object->EZipCode.'"></td>';
		?>

				</tr>
				
				<tr>
					<td>Birthdate:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->EBirthdate.'"></td>';
		  			echo '<td><input type="text" name="empbdate" id="empbdate2"  value="'.$object->EBirthdate.'"></td>';
		?>

				</tr>
				<tr>
					<td>Age:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->EAge.'"></td>';
		  			echo '<td><input type="text" name="empage" id="empage2"  value="'.$object->EAge.'"></td>';
		?>

				</tr>	

				<tr>
					<td>Employee Status:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" name="empstatus3" id="empstatus3" readonly="true" value="'.$object->EmpStatus.'"></td>';
		

			if($con) {
				 $SQLQuery2 = "SELECT EmpStatus from employee GROUP BY EmpStatus";
				 $result2 = mysqli_query($con, $SQLQuery2);
				 $SQLQuery6 = "SELECT EmpStatus, SSSNo from employee WHERE SSSNo='$var_empsssno'";
				 $result6 = mysqli_query($con, $SQLQuery6);
				 $object6 = mysqli_fetch_object($result6);
					echo '<td><select name="empstatus" id="empstatus2" style="width:250px;">';
	
				while ($object2 = mysqli_fetch_object($result2)) {
					echo '<option value="'.$object2->EmpStatus.'" '.($object2->EmpStatus==$object6->EmpStatus ? 'selected="selected"' : '').'>'.$object2->EmpStatus.'</option>';
				}
			}

						echo '</select></td>';
		?>
				</tr>

				<tr>
					<td>Fee:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->Fee.'"></td>';
		  			echo '<td><input type="text" name="empfee" id="empfee2"  value="'.$object->Fee.'"></td>';
		?>

				</tr>				
				<tr>
					<td>Salary:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->Salary.'"></td>';
		  			echo '<td><input type="text" name="empsalary" id="empsalary2"  value="'.$object->Salary.'"></td>';
		?>

				</tr>	
				<tr>
					<td>Rate per hour:</td>
		<?php
					echo '<td bgcolor="lightgray"><input type="text" readonly="true" value="'.$object->RatePerHour.'"></td>';
		  			echo '<td><input type="text" name="emprateperhour" id="emprateperhour2"  value="'.$object->RatePerHour.'"></td>';
		?>

				</tr>				
				
				
				
					
				<tr>
					<td>Department No:</td>
		<?php
					
		

			if($con) {
				 $SQLQuery4 = "select SSSNo, EDeptNo, DeptName from employee e 
				 INNER JOIN department d ON e.EDeptNo=d.DeptNo
				 WHERE SSSNo='$var_empsssno'";
				 $result4 = mysqli_query($con, $SQLQuery4);
				 $object4 = mysqli_fetch_object($result4);
				  
				 $SQLQuery3 = "select * from department";
				 $result3 = mysqli_query($con, $SQLQuery3);
				
				 	echo '<td bgcolor="lightgray"><input type="text" name="empdeptno2b" id="empdeptno2b" readonly="true" value="'.$object4->EDeptNo.' -- '.$object4->DeptName.'"></td>';
					echo '<td><select name="empdeptno" id="empdeptno2" style="width:250px">';
				
				while ($object3 = mysqli_fetch_object($result3)) {
					echo '<option value="'.$object3->DeptNo.'" '.($object3->DeptNo==$object4->EDeptNo ? 'selected="selected"' : '').'>'.$object3->DeptNo.' -- '.$object3->DeptName.'</option>';
				}
			}

						echo '</select></td>';
		?>
				</tr>
							
				<tr>
					<td colspan="3"><center><input type="submit" name="submit" value="Update the Employee record" /></center></td>';
				</tr>		
			</table>
		</form>
		</center>
		<?php
			}
			mysqli_close($con);
		?>
		
		<p align="center"><a href="maintenance.php">Back to Maintenance Module</a></p>
		<br /><br />
	</div>
	<?php
			include 'footer.php';
	?>
</body>
</html>