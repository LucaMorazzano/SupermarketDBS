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
			@import url("stile1.css");
			.orario{
				padding-left: 7%;
				padding-right: 7%;
			}
			.selezione{
				background-color:orange;
				color:white;
				font-size:17px;
				border:solid;
				border-color: white;
				margin-bottom: 4%;
				height: 23px;
			}
			.h1{
				font-size: 50px;
				color:black;
			}
		</style>
	</head>

	<body>

		<?php
		// require_once("menu.php");
		 require_once("connection.php");
		 require_once("menu.php");
         ?>

		<div class="main">
			<div id="center">
				<?php
				$sql=array();
				$i=0;
                $sql="SELECT f.* from film f,proiezione p where p.idcinema='2' and p.id_film=f.id group by f.id";
				if($result=mysqli_query($connection,$sql)){
				foreach($result as $film){
					$idf=$film['id'];
					echo "<div id=\"contenitore\">";
							$titolo=$film['titolo'];
							echo "<img src=\"$titolo.png\">";
							echo "<h1> $titolo </h1><br>";
							echo "<p></p>";
							echo "<p></p>";
							echo "</hr>";
							echo "<div id=\"contenitore1\">";
							$sql1=array();
							$sql1="SELECT P.* from proiezione p where p.id_film='$idf'";
							if($result2=mysqli_query($connection,$sql1)){
							echo "<p>";
						    echo "<form class=\"orario\" action=\"fineacquistibdd.php\" method=\"POST\" return>";
							echo "<input type=\"hidden\" name=\"idf\" value=$idf>";
					 		$x=0;
						    foreach($result2 as $proiez){
							$sala=$proiez['sala'];
							$orario=$proiez['orario'];
							if(!empty($_SESSION)){
							echo "<input type=\"radio\" name=\"tipo\" value=\"$orario\"";
							if($x==0){echo"checked";} echo"/>SALA $sala: $orario&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
								$x++;
							}
							else{
								echo"SALA $sala: $orario&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
							}
						}
				if(!empty($_SESSION)){
					echo "<p style=\"display:flex; justify-content:center\"><input type=\"submit\" class=\"selezione\" name=\"add\" value=\"PRENOTA ORARIO\"></p></form>";
			  }
			  echo "</p>";
			}
			echo "</div>";
			echo "</div>";
		}
	}	
?>
</div>
</div>
</body>
</html>