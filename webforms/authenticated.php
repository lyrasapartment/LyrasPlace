<?php
require_once("../includes/functions.inc");

header('Refresh: 2; URL=index.php');
?>
<!doctype html>
<html style="background: url('../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<title>Super Secret Authenticated Page</title>
<link rel="stylesheet" type="text/css" href="../includes/form.css">
<link rel="stylesheet" type="text/css" href="../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../includes/align.css">
</head>
<body>
<div  class="div2">
<?php include '../includes/header.php'; ?>
<div id="div-ctr"><br/>
<center>
<div>
<?php print "Welcome {$user->firstName}<br />\n"; ?>
</div>
<div>
Please wait while we redirect you to another link..
</div>
</center>
</div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>