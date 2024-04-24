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
		</style>
		<script>
		var i=0;
			//Slideshow
			function slideshow(){
				var img =["Slideshow/img1.png","Slideshow/img2.png","Slideshow/img3.png","Slideshow/img4.png"];

				document.slider.src=img[i]; /*l'elemento slider del dom avrà src l'elemento dell'array*/
				if(i<img.length-1)
					i++;
				else
					i=0;
				setTimeout(slideshow,3000);
			}
			//funzione per bottone carrello
			window.onload=slideshow; /*metodo classe window del bom*/
		</script>
	</head>

	<body>
		<?php
		// require_once("menu.php");
		 require_once("connection.php");
		 require_once("menu.php");
         ?>

		<div class="main">
			<div id="center"> <!-- Sezione che contiene il catalogo dei prodotti -->
				<div id="contenitorefilm">
					<a href="oxer1.php"><img src="oxer.png"></a>
					<h3> V.le P. Nervi, 124 - Latina, LT - Telefono: 0773604055
          <br>
					<br>
					<br>
          Qui trovi gli orari dei film in programmazione al Cinema Oxer.
          Scopri le sale, gli orari delle proiezioni dei film al cinema e il prezzo del biglietto.
          Il Cinema Oxer si trova a Latina , V.le P. Nervi, 124.
          Per informazioni sui film programmati, orari, prezzi, sconti e offerte speciali è possibile contattare il cinema al numero 0773604055. </h3>
				</div>
				<div id="contenitorefilm">
				<a href="multisala.php"><img src="multisala.png"></a>
				<h3> Corso della Repubblica, 279, 04100 Latina (LT) Telefono 0773481260
				<br>
				<br>
				<br>
				Scopri le sale, gli orari delle proiezioni dei film al cinema e il prezzo del biglietto.
				Il Cinema Multisala si trova a Latina , Corso della Repubblica, 279.
				Per informazioni sui film programmati, orari, prezzi, sconti e offerte speciali è possibile contattare il cinema al numero 0773481260
		  	</h3>
				</div>
				<div id="contenitorefilm">
 		<a href="corso.php"><img src="corso.png"></a>
		<h3> Corso Della Repubblica, 148 - Latina, LT - Telefono: 0773693183
<br>
<br>
<br>
Qui trovi gli orari dei film in programmazione al Cinema Corso.
Scopri le sale, gli orari delle proiezioni dei film al cinema e il prezzo del biglietto.
Il Cinema Corso si trova a Latina , Corso Della Repubblica, 148.
Per informazioni sui film programmati, orari, prezzi, sconti e offerte speciali è possibile contattare il cinema al numero 0773693183. </h3>
 			 </div>
					</div>

			<div id="right"> <!-- Sezione che contiene lo slideshow di alcune immagini (funzione prettamente estetica) -->
			<img name="slider" height="720px" width="300px" alt="slideshow" />
			</div>

		</div>
		<?php

		if(isset($_POST['bottone'])){
			  if(isset($_SESSION['login'])) {
				$id=$_POST['bottone'];
		        array_push($_SESSION['carrello'],$id);
				}
				echo "<script>alert(\"Elemento aggiunto al carrello\");</script>";
				}
			?>
	</body>




</html>
