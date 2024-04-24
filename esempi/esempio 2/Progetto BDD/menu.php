<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Menu</title>
		<style type="text/css">
			#header{
				display:flex;
				background-color:orange;
				border-radius: 20px 20px 20px 20px;
				justify-content:space-between;
				align-items:center;
			}
			#header img{
				padding-top:2%;
				padding-bottom: 2%;
				padding-left: 2%;
				border-radius: 20px 20px 20px 20px;
			}
			.navbar{
				list-style-type:none;
				margin-right:15%;
			}
			.navbar a{
				text-decoration:none;
				color:white;
			}
			.navbar li{
				display:inline; /*disposizione orizzontale della lista*/
				padding-right:10%;
				color:white;
				font-size:25px;
				font-family:Courier;
			}
			.navbar a:hover{
				color:green;
			}
		</style>
	</head>

	<body>
		<div id="header">
			<a href="homepagebdd.php"><img src="logo1.png" height="60px" width="240px"  /></a>
			<ul class="navbar">
				<nobr>
					<?php
						if(isset($_SESSION['login'])){
							echo "<li><a href=\"accountbdd.php\">ACCOUNT</a></li>";
							echo "<li><a href=\"info.php\">INFO</a></li>";
							echo "<li><a href=\"logoutbdd.php\">LOGOUT</a></li>";
						}
						else if(!isset($_SESSION['login'])&&!isset($_SESSION['adlogin'])){
							echo "<li><a href=\"info.php\">INFO</a></li>";
							echo "<li><a href=\"loginbdd.php\">LOGIN</a></li></nobr>";
						}
						else if(!isset($_SESSION['login'])&& (isset($_SESSION['adlogin']))) {
							echo "<li><a href=\"Specialhome.php\">MAIN</a></li>";
							echo "<li><a href=\"logoutbdd.php\">LOGOUT</a></li>";
						}
					?>
				</nobr>
			</ul>
		</div>
	</body>


	</html>
