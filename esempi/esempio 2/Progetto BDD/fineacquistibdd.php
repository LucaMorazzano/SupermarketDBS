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
			@import url("stile2.css");
			.orario{
				padding-left: 7%;
				padding-right: 7%;
				padding-top:2%;
			}
			.selezione{
				background-color:orange;
				color:white;
				font-size:17px;
				border:solid;
				border-color: white;
				margin-bottom: 4%;
				height: 25px;
			}
			.selezione:hover{
				color:green;
				font-size:22px;
				height:30px;
			}
			.h1{
				font-size: 50px;
				color:black;
			}
		</style>
	</head>

	<body>

		<?php
		 require_once("connection.php");
		 require_once("menu.php");
         ?>

		<div class="main">
			<div id="center">
				<?php
        if(isset($_POST['conferma'])){
            echo "<script>alert (\"PRENOTAZIONE EFFETTUATA\")</script>";
            $quanto=$_POST['quanto'];
			$idproscelto=$_POST['idpro'];
			$idut=$_SESSION['id'];
						$sql3=array();
						$sql3="UPDATE Proiezione SET disponibilita =disponibilita-$quanto WHERE id = '$idproscelto'";
						if(mysqli_query($connection,$sql3)){
							$sql5=array();
							$sql5="INSERT INTO Prenotazione(id_utente,id_proiezione,quantita) VALUES ('$idut','$idproscelto','$quanto')";
							if(mysqli_query($connection,$sql5)){

			echo "<a href=\"homepagebdd.php\"><img class=\"logo\" src=\"logo1.png\" width=\"300px\" height=\"300px\" alt=\"logo\" /></a>";
            echo "<h1> TORNA ALLA HOMEPAGE </h1>";
					}
					}

				 }
				 
           else
					 {
				$sql=array();
				$x=0;
				$orario=$_POST['tipo'];
				$idscelto=$_POST['idf'];
				$sql="SELECT P.* FROM Proiezione P WHERE P.id_film='$idscelto' AND P.orario='$orario' ";
				if($result=mysqli_query($connection,$sql)){

				foreach($result as $proiezion){
					$proiezione=$proiezion['id'];
					echo "<div id=\"contenitore\">";
					$orarioscelto=$proiezion['orario'];
					$prezzo=$proiezion['prezzo'];					
					$sala=$proiezion['sala'];

					$sql1=array();
					$sql1="SELECT * FROM Film WHERE id=(SELECT P.id_film FROM Proiezione P WHERE P.id='$proiezione' AND P.orario='$orarioscelto')";
					if($result1=mysqli_query($connection,$sql1)){
							foreach($result1 as $film){
							$titolo=$film['titolo'];
								echo "<img src=\"$titolo.png\">";
							echo "<h1> $titolo </h1><br>";
							echo "<h4> Riprodotto in :$sala</h4>";
							echo "<h4> Costo: $prezzo </h4>";
              echo "<h4> Orario selezionato: $orarioscelto </h4>";
			  echo "<div id=\"contenitore1\">";
              if($x==0){
              echo "<form class=\"orario\" action=\"fineacquistibdd.php\" method=\"POST\">";
							echo "SELEZIONA NUMERO BIGLIETTI:";
							echo "<select name=\"quanto\">
                                 <option value=\"1\">1</option>
                                 <option value=\"2\">2</option>
                                 <option value=\"3\">3</option>
                                 <option value=\"4\">4</option>
								 <option value=\"5\">5</option>
                                 </select>";
				            echo "<input type=\"hidden\" name=\"idpro\" value=$proiezione>";
                    echo "<p style=\"display:flex; justify-content:center\"><input type=\"submit\" class=\"selezione\" name=\"conferma\" value=\"CONFERMA PRENOTAZIONE\"></form>";
              $x++;	
					}
               echo "</div>";  
     }
   }
   echo "</div>";

          }
			}
			echo "</div>";
		}

			echo "</div>";


			?>

		</div>
	</body>
</html>
