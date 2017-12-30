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
							echo '<a href="logout.php" style=""><small>Log-out</small></a>';
							$fn = $user->firstName; $ln = $user->lastName;
							echo "<br><small style=\"color:black ;\">logged in as ". ($user->isAdmin ? "Admin" : "Moderator")
							."<br>$fn $ln</small>";
						}
						else if(is_valid_login_page()){
							echo '<a href="login.php" style=""><small>Log-in</small></a>';
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