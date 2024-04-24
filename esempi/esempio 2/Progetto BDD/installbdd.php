<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>intall.php</title>
	</head>

	<body>
		<?php
			$connection= new mysqli("localhost","root","");
			$dbname="Cinema";
			$userTable="Cliente";
			$prenotazioniTable="Prenotazione";
			$proiezioneTable="Proiezione";
			$filmTable="Film";

			if(mysqli_errno($connection)){
				echo"<h2 style=\"color:red\">Errore connessione</h2>";
			}
			/*ELIMINIAMO IL DBS SE GIA' CREATO*/
			$query= "DROP DATABASE if exists $dbname";
			$dropresult=mysqli_query($connection,$query);
			/*CREAZIONE DBS*/

			$query= "CREATE DATABASE if not exists $dbname";
			if(mysqli_query($connection,$query) && $dropresult){
				echo "<h1>DBS creato</h1>";
			}
			else {
				echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
			}
			$connection->close();




			////CREAZIONE TABELLE
			require_once("connection.php");



						//TABELLA UTENTE
						$sql="CREATE TABLE if not exists $userTable (
								id INTEGER NOT NULL AUTO_INCREMENT,
								nome VARCHAR(20) NOT NULL,
								cognome VARCHAR(20) NOT NULL,
								email VARCHAR(40) NOT NULL UNIQUE,
								password_1 VARCHAR(20) NOT NULL,
								stato INTEGER NOT NULL,
								username VARCHAR(20) UNIQUE,
								PRIMARY KEY(id))";
								if(mysqli_query($connection,$sql)){
									echo "<h1>UTENTE CREATO</h1>";
								}
								else {
									echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
								}

						//TABELLA FILM
						$sql="CREATE TABLE if not exists $filmTable (
								id INTEGER NOT NULL AUTO_INCREMENT,
								titolo VARCHAR(20) UNIQUE,
								PRIMARY KEY(id))";
								if(mysqli_query($connection,$sql)){
									echo "<h1>FILM CREATO</h1>";
								}
								else {
									echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
								}


						//TABELLA PROIEZIONE
						$sql="CREATE TABLE if not exists $proiezioneTable (
								id INTEGER NOT NULL AUTO_INCREMENT,
								id_film INTEGER NOT NULL REFERENCES $filmTable(id),
								sala INTEGER NOT NULL,
								orario varchar(10),
								disponibilita INTEGER NOT NULL,
								idcinema INTEGER NOT NULL,
								prezzo INTEGER NOT NULL,
								PRIMARY KEY(id))";
								if(mysqli_query($connection,$sql)){
									echo "<h1>PROIEZIONE CREATO</h1>";
								}
								else {
									echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
								}


						//TABELLA Prenotazione
						$sql="CREATE TABLE if not exists $prenotazioniTable (
								id INTEGER NOT NULL AUTO_INCREMENT,
								id_utente VARCHAR(20) NOT NULL REFERENCES $userTable(id),
								id_proiezione INTEGER NOT NULL REFERENCES $proiezioneTable(id),
								quantita INTEGER NOT NULL,
								PRIMARY KEY(id))";
								if(mysqli_query($connection,$sql)){
									echo "<h1>PRENOTAZIONE CREATO</h1>";
								}
								else {
									echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
								}

						//COMPLET$AMENTO
						$sql=array();
						$i=0;
						$sql[0]="INSERT INTO $userTable(nome,cognome,email,password_1,stato,username) VALUES (\"luca\",\"luca\",\"luca@gmail.com\",\"luca\",\"0\",\"luca\")";
						$sql[1]="INSERT INTO $userTable(nome,cognome,email,password_1,stato,username) VALUES (\"andrea\",\"andrea\",\"andrea@gmail.com\",\"andrea\",\"1\",\"andrea\")";
						$sql[2]="INSERT INTO $filmTable(titolo) VALUES (\"prova1\")";
						$sql[3]="INSERT INTO $filmTable(titolo) VALUES (\"prova2\")";
						$sql[4]="INSERT INTO $filmTable(titolo) VALUES (\"prova3\")";
						$sql[5]="INSERT INTO $filmTable(titolo) VALUES (\"prova4\")";
						$sql[6]="CREATE DEFINER=`root`@`localhost` TRIGGER `elimina` AFTER DELETE ON `film` FOR EACH ROW BEGIN
						DELETE FROM proiezione WHERE id_film=OLD.id;
						END;";
						$sql[7]="CREATE DEFINER=`root`@`localhost` TRIGGER `riaggiorna` AFTER DELETE ON `prenotazione` FOR EACH ROW BEGIN
						UPDATE proiezione SET disponibilita=disponibilita+OLD.quantita WHERE id=OLD.id_proiezione;
						END;";

						while($i<sizeof($sql)){
							echo "$sql[$i] \n <br />";
							if(mysqli_query($connection,$sql[$i])){
								echo "<h2 style=\"color:green\">popolamento riuscito</h2>";
							}
							else {
								echo "<h2 style=\"color:red\">errore popolamento</h2>";
							}
							$i+=1;
						}
						$connection->close();
		?>

	</body>


</html>
