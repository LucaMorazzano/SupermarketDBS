<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
     session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Account</title>
	    <style type="text/css">
			body{
        background-color:white;
				display:flex;
				text-align:center; /*il contenuto della pagina avrà un allineamento del testo centrale per mantenere comunque un layout disposto a colonne*/
				flex-direction:column;		/*impostiamo il body in modo da avere un layout a colonne*/
				font-family:Arial;
			}


			/*CLASSE MAIN CHE CONTIENE IL CONTENUTO AL CENTRO DELLA PAGINA OVVERO LE SEZIONI LEFT, RIGHT E CENTER*/
			.main{
				display:flex; /*impostiamo display flex in modo da avere una maggiore libertà sul posizionamento degli elementi, in questo esercizio viene usato
									principalmente per mettere in evidenza il contenuto principale rispetto a le sezioni left e right*/
				padding:1%; /*diamo un lieve padding in modo da non avere */
			}
			/*FINE MAIN*/


			/*HEADER SECTION*/
			#header{
				display:flex;
				background-color:#1e1e1e;
				border-radius: 20px 20px 20px 20px;
				justify-content:space-between;
				align-items:center;
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
				color:red;
			}

			.selezione{
				border:solid;
				border-color:green;
				border-radius:5px;
				width:160px;
			}
			.selezione:hover{
				font-size:30px;
				color:green;
			}

			/*FINE HEADER*/

			/*LEFT SECTION*/
			#left{
				color:white;
				background-color:white;
        border:solid;
        border-color:orange;
				border-radius: 20px 20px 20px 20px;
				text-align:justify;
				padding:1%;
				flex:5 5 100px;
      	}
			#left h3{
				color:orange;
			}
			#left h2{
				color:orange;
				text-align:center;
				}
			#left h4{
				color:green;
			}
			#left .bottone{
				margin-left:30%;
				background-color:orange;
				color: white;
				font-size: 15px;
				font-family:Arial;
				padding: 5px 5px;
				border: none;
				border-radius: 5px;
			}
			/*SEZIONE RIGHT*/
			#right{
        background-color: white;
        border: solid;
        border-color:orange;
        border-radius: 20px 20px 20px 20px;
				padding:1%;
				flex:5 5 100px;
			}
			#right .storico{
				overflow:scroll;
				height:500px;
			}
			#right h3{
					 color:orange;
			}
			#right h2{
				color:orange;
				text-align:center;
				padding:5px;
				border-radius:20px;
			}
			#right .discussioni{
				overflow:scroll;
				height:200px;
				color:black;
			}
			#right input{
				border:none;
				font-size:18px;
				background-color:white;
			}
			#right input:hover{
				color:red;
			}
			#right a{
				color:red;
				text-decoration:none;
			}
			#right h1{
				text-align:center;
				font-size:20px;
			}
			#right h4{
				text-align:center;
			}
      #contenitore{
        text-align: center;
        border:solid;
        border-color:green;
        margin-top: 2%;
      }
      #contenitore img{
         width:238px;
         height: 275px;
         float:left;
      }

	  #right .selezione{
		border:solid;
		border-color:green;
		border-radius:5px;
		width:230px;
		justify-content:center;
		align-items:center;
		font-size:17px;
		background-color:orange;	
			}
		#right .selezione:hover{
				font-size:20px;
				color:green;
				width:270px;
			}


			/*FINE RIGHT*/

			/*STILIZZAZIONE SCROOLLBAR*/
			::-webkit-scrollbar{
				width:10px;
				height:10px;
			}
			::-webkit-scrollbar-track {
			  background: white;
			}
			::-webkit-scrollbar-thumb {
			  background: white;
			}

			::-webkit-scrollbar-thumb:hover {
			  background: #a61022;
			}


		</style>
		<script>
			function formvalidator(password){
				var nuovapass=document.forms['ModForm']['nuova'].value;
				var nuovapass2=document.forms['ModForm']['nuova2'].value;
				var oldpass=document.forms['ModForm']['old'].value;
				if(oldpass=="" || oldpass==null || nuovapass=="" || nuovapass== null || nuovapass2=="" || nuovapass2== null){
					alert("Dati mancanti");
					return false;
				}
				if(oldpass!=password){
					alert("La password inserita non corrisponde alla password attuale");
					return false;
				}
				if(nuovapass!=nuovapass2){
					alert("Le due password inserite non corrispondono");
					return false;
				}
				if(oldpass==password && nuovapass==nuovapass2){
					return true;
				}
			}
		</script>
	</head>
	<body>
	<?php
		if(isset($_SESSION['login'])){ //pagina visibile solo se si è loggati
	?>

	<?php

		require_once("connection.php");
		$userTable="Utente";
		$nome=$_SESSION['nome'];
		$cognome=$_SESSION['cognome'];
		$username=$_SESSION['username'];
		$password=$_SESSION['password'];
		$email=$_SESSION['email'];
		$arrayacquisti=array();
		///////////////////////////////////////////////
		if(isset($_POST['bot1'])) {
			$newPass=$_POST['nuova'];
			$sql = "UPDATE Cliente SET password_1 = '$newPass' WHERE username = '$username' ";
			$result=mysqli_query($connection,$sql); //inviamo query
			if($result){ //query valida ora estraiamo informazioni dal risultato della query
                echo "<script> alert(\"Password aggiornata\") </script>";
				$_SESSION['password']=$newPass;
				header("Location:accountbdd.php");
			}
			else{
				echo "<script>alert(\"Errore inaspettato\")</script>";
			}
		}

	?>
	<?php
		require_once("menu.php");
	?>
	<div class="main">
	<div id="left">
	<?php
	 //recuperiamo i valori salvati nella sessione al momento del login
			echo "<h2> IL MIO ACCOUNT </h2>";
	        echo "<hr>";
			echo "<h3> NOME e COGNOME: </h3><h4>$nome $cognome</h4>";
            echo "<h3> USERNAME: </h3><h4>$username</h4>";
			echo "<h3> EMAIL: </h3><h4>$email</h4>";
		 ?>
			<hr>
			<h3>MODIFICA LA TUA PASSWORD: <h3>
			<form name="ModForm" action="accountbdd.php" method="POST" onsubmit="return formvalidator('<?php echo $_SESSION['password'] ?>')">
				<p>Vecchia Password        <input type="password" name="old" ></p>
				<p>Nuova Password        <input type="password" name="nuova" ></p>
				<p>Ripeti Nuova Password        <input type="password" name="nuova2"></p>
				<input class="bottone" type="submit" name="bot1" value="Modifica Password" >
		</form>
		<?php
		?>


	</div>

	<div id="right">
	<?php
      $p=0;
      $idutente=$_SESSION['id'];
			echo "<h2> BIGLIETTI PRENOTATI:</h2><div class=\"storico\">";
      $sql2=array();
      $i=0;
      $sql2="SELECT * FROM Prenotazione WHERE id_utente='$idutente'";
      if($result2=mysqli_query($connection,$sql2)){
      foreach($result2 as $ticket){
        $p++;
		$idprenotazione=$ticket['id'];
        $idproiez=$ticket['id_proiezione'];
		$numero=$ticket['quantita'];
        $sql=array();
		$sql="SELECT * FROM Proiezione WHERE id='$idproiez'";
		if($result=mysqli_query($connection,$sql)){
			foreach($result as $pro){
				$orario=$pro['orario'];
				$prezzo=$pro['prezzo'];
				$sala=$pro['sala'];
				$idfilm=$pro['id_film'];
		$sql1=array();
        $sql1="SELECT * FROM Film WHERE id='$idfilm'";
        if($result1=mysqli_query($connection,$sql1)){
            foreach($result1 as $film){
            echo "<div id=\"contenitore\">";
            $titolo=$film['titolo'];
            echo "<img src=\"$titolo.png\">";
            echo "<h1> $titolo </h1><br>";
            echo "<h4> Riprodotto in :$sala</h4><br>";
            echo "<h4> Biglietti prenotati: $numero</h4>";
			echo "<h4> ORARIO: $orario</h4>";
			echo "<form name=\"ok\" action=\"accountbdd.php\" method=\"POST\">
			      <input type=\"hidden\" name=\"idprenotazione\" value=$idprenotazione>
			      <input type=\"submit\" class=\"selezione\" name=\"annulla\" value=\"ANNULLA PRENOTAZIONE\">
				  </form>";		
			echo "</div>";
			}
				}
        }
      }
    }
}
    if($p==0)
    {
				echo "<h3>Nessun biglietto prenotato fino ad ora</h3>";
     }
			echo"</div>"; //fine right
	if(isset($_POST['annulla'])){
		$idannulla=$_POST['idprenotazione'];
		echo "$idannulla";
		$sql111=array();
		$sql111="DELETE FROM Prenotazione WHERE id='$idannulla' AND id_utente='$idutente'";
		if(mysqli_query($connection,$sql111)){
			echo "<script>alert(\"PRENOTAZIONE ANNULLATA\")</script>";
		   }
		   else
		   {	
			echo "<script>alert(\"ERRORE\")</script>";
		   }
	}
	 
		
		
		} //fine session login==true
		 else{
			 echo "<h1>FORBIDDEN</h1>"; //se non siamo loggati
		 }
	?>
	</div>
	</body>
</html>
