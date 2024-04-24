<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Home</title>
		<style>
            body{
                background-color: white;
            }
            #contenitorre{
                display:flex;
                justify-content:center;
            }
			.h1{
				font-size: 25px;
				color:black;
			}
		</style>
	</head>

	<body>

		<?php
		 require_once("connection.php");
		 require_once("menu.php");
         ?> 
         
         <div id="contenitorre">
        <h1>Andrea Fionda matricola:1847591</h1></div>
        <div id="contenitorre">
        <h1>Simone Rossato matricola:1912095</h1></div>
        <div id="contenitorre">
        <h1>Giorgia Belvisi matricola:1894148</h1>
        </div>
	</body>
</html>
