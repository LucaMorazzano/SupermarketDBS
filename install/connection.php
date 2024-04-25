<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>Connessione al dbs</title>
	</head>
	
	<body>
		<?php
			$dbname="Supermarket";
			$connection= new mysqli("localhost","root","",$dbname);
			
			if(mysqli_errno($connection)){
				echo "<h2 style=\"color:red\">Errore connessione dbs</h2>";
			}
		?>
	
	</body>




</html>