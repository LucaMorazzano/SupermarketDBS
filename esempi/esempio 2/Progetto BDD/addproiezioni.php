<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Modifica</title>
		<style type="text/css">
				.utente{
					text-align:center;
					border: solid black;
					padding:5%;
					margin-top:3%;
					margin-left:auto;
					margin-right:auto;
					width:400px;
				}
				
				form {
					text-align:center;
					padding:5%;
				}
		
		</style>
		<script type="text/javascript">
			function responsivebutton(button){
				var nome= button.name;
				button.value=nome;
				//mettiamo trasparente
				button.style.backgroundColor="white";
				button.style.color="white";
				button.style.borderColor="white";
				button.name="bottone";
				return;
			}
		</script>
	</head>
	
	<body>
		<?php 
			require_once("connection.php");
			require_once("menu.php");

		?>
		<?php
			if (isset($_POST['aggiungi'])){
				$idfilmscelto=$_POST['idf'];
				$orario=$_POST['ora'];
				$sala=$_POST['sala'];
				$disponibili=$_POST['numbiglietti'];
				$cine=$_POST['cinema'];
				$prez=$_POST['prezzo'];
				$sql="INSERT INTO Proiezione(id_film,sala,orario,disponibilita,idcinema,prezzo) VALUES (\"$idfilmscelto\",\"$sala\",\"$orario\",\"$disponibili\",\"$cine\",\"$prez\")";
				if($result=mysqli_query($connection,$sql)){
					echo "<script>alert(\"INSERIMENTO OK\")</script>";	
			}
			else
			{
				echo "<script>alert(\"PROBLEMI\")</script>";				

			}

				if(!isset($_SESSION['adlogin'])){echo "<h1>FORBIDDEN</h1>";}
		}
		?>
		<?php
			if (isset($_POST['bottone'])){
				$idfscelto=$_POST['idf'];
				echo "<form class=\"reins\" name=\"userform\" action=\"addproiezioni.php\" method=\"post\" onsubmit=\"return formvalidator()\">
				<h1>COMPILARE LA FORM PER INSERIRE UNA NUOVA PROIEZIONE:</h1>
				<p>ORARIO: <input type=\"text\" name=\"ora\"></p>
				<p>SALA: <input type=\"text\" name=\"sala\"></p>
				<p>PREZZO: <input type=\"text\" name=\"prezzo\"></p>
				<input type=\"hidden\" name=\"idf\" value=$idfscelto>
				<p>BIGLIETTI DISPONIBILI: <input type=\"text\" name=\"numbiglietti\"></p>
				<select name=\"cinema\">
                                 <option value=\"1\">OXER</option>
                                 <option value=\"2\">MULTISALA</option>
                                 <option value=\"3\">CORSO</option>
                                 </select>
				<p style=\"display:flex; justify-content:center\"><input type=\"submit\" class=\"selezione\" name=\"aggiungi\" value=\"INSERISCI PROIEZIONE\"></p></form>
				</div>";
				 }
		?>
		
		
		
	</body>

</html>