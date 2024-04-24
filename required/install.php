<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>
			install.php
		</title>
	</head>
	<body>
		
		<?php
			$dbname = "Supermarket";
			$connection = new mysqli("localhost", "root", "");

// Verifica la connessione al database
			if ($connection->connect_error) {
				die("Connessione fallita: " . $connection->connect_error);
			}

			$query = "DROP DATABASE IF EXISTS $dbname";
			$dropresult = mysqli_query($connection, $query);

			$query = "CREATE DATABASE IF NOT EXISTS $dbname";
			if ($connection->query($query) === TRUE && $dropresult) {
				echo "<h1>DBS creato</h1>";
			} else {
				echo "<h1 style=\"color:red\">Errore creazione DBS: " . mysqli_error($connection) . "</h1>";
			}

			$connection->close();

			require_once("connection.php");

			if (mysqli_errno($connection)) {
				echo "<h1 style=\"color:red\">DBS non raggiungibile</h1>";
			}
//tabella punto vendita
			$query = "CREATE TABLE IF NOT EXISTS Punto_vendita(
				id_punto_vendita INTEGER NOT NULL AUTO_INCREMENT,
				residenza VARCHAR(20),
				tot_vendite INTEGER,
				tot_incasso REAL,
				incasso_giornaliero REAL,
				id_ispettore INTEGER NOT NULL REFERENCES Responsabile(id_responsabile),
				id_capo_divisione INTEGER NOT NULL REFERENCES Responsabile(id_responsabile),
				PRIMARY KEY(id_punto_vendita)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella Punto vendita creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella Punto vendita: " . mysqli_error($connection) . "</h2>";
			}
//tabella prodotto
			$query = "CREATE TABLE IF NOT EXISTS Prodotto(
				id_prodotto INTEGER NOT NULL AUTO_INCREMENT,
				nome VARCHAR(20),
				fornitore VARCHAR(20),
				prezzo REAL,
				id_magazzino INTEGER NOT NULL REFERENCES Magazzino(id_magazzino),
				id_reso INTEGER NOT NULL REFERENCES Reso(id_reso),
				PRIMARY KEY(id_prodotto)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella Prodotto creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella Prodotto: " . mysqli_error($connection) . "</h2>";
			}

			$connection->close();
		?>
	</body>
</html>
