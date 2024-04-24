<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Special Home</title>
		<style type="text/css">
	     body{
	font-family:Arial;
	background-color:white;
}
#main{
	display:flex;
	flex-direction:column;
	border:solid black;
	margin-top:3%;
	background-color:white;
	border-radius:20px;
	border-color:green;
	color:green;
	text-align:center;
	padding:5%;
	margin-left:auto;
	margin-right:auto;
	height:400px;
    width:700px;
    justify-content:space-between;

}

#main a{
	color:green;
	font-size:25px;
	font-family:Courier;
	text-decoration:none;	
}

#main a:hover{
	color:orange;
	font-size:26px;
}
   </style>
	</head>
	<body>
		<?php
			if(isset($_SESSION['adlogin']) || isset($_SESSION['manlogin'])){
				require_once("menu.php");
                require_once("connection.php");
				echo "<div id=\"main\">";
				if(isset($_SESSION['adlogin'])){
                 echo  "<a href=\"adminbdd.php\">INSERISCI NUOVO FILM</a>";
		         echo  "<a href=\"proiezionibdd.php\">AGGIUNGI NUOVE PROIEZIONI</a>";
				 echo  "<a href=\"rimuovibdd.php\">RIMUOVI FILM</a>";

				}
			echo "</div>";

			}
			else{
				echo "<h1>FORBIDDEN</h1>";
			}
		?>

	</body>
</html>