<?php require_once("../../includes/functions.inc"); ?>
<!doctype html>
<html style="background: url('../../includes/img/bg/bg2.jpg') no-repeat center center fixed;background-size: cover;">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../includes/form.css">
<link rel="stylesheet" type="text/css" href="../../includes/footer.css">
<link rel="stylesheet" type="text/css" href="../../includes/align.css">
<title>Home</title>
</head>
<body>
<div  class="div2">
<div class="header" style="min-height:100px;">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
      <div class="page-heading" style="height:100%;width:100%;"><br/>
		<div style="position:relative;width:80%;height:auto;display:table-cell;left:20px;">
        <h1 class="page-heading"><a style="text-decoration:none;color: #FFDAAA;" href="index.php">Welcome to the Lyra's Place - Pension House </a></h1>
		
		</div>
		<div style="position:absolute;text-align:right;width:250px;display:table-cell;right:25px;top:15px;"><?php
		//echo !extension_loaded('openssl')?"Not Available":"Available";
						$user = new User;
						function is_valid_login_page() {
							switch (basename($_SERVER['PHP_SELF'])) {
								case "index.php":
								case "sitemap.php":
								case "about.php":
								case "register.php":
								case "contact.php": return true;break;
								default:break;
							} 
							return false;
						}
						
						if ($user->isLoggedIn) {
							echo '<a href="../logout.php" style=""><small>Log-out</small></a>';
							$fn = $user->firstName; $ln = $user->lastName;
							echo "<br><small style=\"color:black ;\">logged in as ". ($user->isAdmin ? "Admin" : "Moderator")
							."<br>$fn $ln</small>";
						}
						else if(is_valid_login_page()){
							echo '<a href="../login.php" style=""><small>Log-in</small></a>';
							echo "<br><small style=\"color:black ;\">You are not logged in</small>";
						}


		?></div>
		<div style="clear:both;margin-left:2%;" id="reloadthepage"> 
        <p class="paragraph tagline">This is a demo of database security.

		<br/>
		<br/>
        </p>
		</div>
      </div>
	  <script>
	 
	  </script>;
 </div>
<div id="div-ctr"><br/>
Access Denied. You are not logged in.
<meta http-equiv="refresh" content="3; url=../index.php">

<div>


</div>

</div>
</div>
 <div class="footer stick-to-bottom">
    <div>
      <footer class="footer2">
        <div class="">
          <div class=""></div>
          <div class="" >
            <a class="link-text footer-nav" href="../index.php">Home</a>
            <a class="link-text footer-nav" href="../maintenance.php">Maintenance</a>
            <a class="link-text footer-nav" href="../about.php">About Us</a>
            <a class="link-text footer-nav" href="../contact.php">Contact Us</a>
            <a class="link-text footer-nav" href="../sitemap.php">Site Map</a>
          </div>
        </div>
        <div>
          <div class=""></div>
          <div class="">
            <div >
			<small>
				Please use the latest version of your browser.<br>
			</small>
			</div>

          </div>
        </div>
      </footer>
    </div>
  </div>
</body>
</html>