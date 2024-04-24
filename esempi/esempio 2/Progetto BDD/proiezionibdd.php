<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Gestione Proiezioni</title>
		<style type="text/css">
			.film{
				border:solid thin black;
				text-align:center;
				padding:2%;
				margin-top:2%;
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
				button.name="modifica";
				return;
			}
		</script>
	</head>
	
	<body>
		<?php
		require_once("connection.php");
		require_once("menu.php");
			if(isset($_SESSION['adlogin'])){
				echo "<div id=\"box\">";
				
				$sql="SELECT * FROM Film";
				if($result=mysqli_query($connection,$sql)){
					foreach($result as $film){
						echo "<form action=\"addproiezioni.php\" method=\"POST\"\>";
                        $idf=$film['id'];
						$nome=$film['titolo'];	
						echo "<div class=\"film\">
							<p>TITOLO FILM: $nome</p>
							<input type=\"hidden\" name=\"idf\" value=$idf>
							<input type=\"submit\" name=\"bottone\" value=\"AGGIUNGI PROIEZIONI\">
							</form></div>;
						</div>";
					}
				}
			}
			else {
				echo "<h1>FORBIDDEN</h1>";
			}
		?>
	
	</body>
	




</html>