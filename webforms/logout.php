<?php
require_once("../includes/functions.inc");
$user = new User;
$user->logout();
if (!$user->isLoggedIn) {
die(header("Location: login.php"));
print "Log-out successful! <br />\n";
}
header('Refresh: 2; URL=login.php');
?>

<!doctype html>
<html style="background: url('../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/form.css">
<link rel="stylesheet" type="text/css" href="../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../includes/align.css">
<title>Success</title>
</head>
<body>
<div  class="div2">
<?php include '../includes/header.php'; ?>
<div id="div-ctr"><br/>

<div>
Logout Successful!<br/>
We will redirect you to the login page shortly...
</div>
<div>

</div>

</div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>