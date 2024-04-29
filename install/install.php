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

//CREAZIONE TABELLE

//tabella punto vendita
			$query = "CREATE TABLE IF NOT EXISTS Punto_vendita(
				id_punto_vendita INTEGER NOT NULL AUTO_INCREMENT,
				residenza VARCHAR(20),
				tot_vendite INTEGER,
				tot_incasso REAL,
				incasso_giornaliero REAL,
				incasso_settimanale REAL, 
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
				id_reso INTEGER REFERENCES Reso(id_reso),
				PRIMARY KEY(id_prodotto)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella Prodotto creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella Prodotto: " . mysqli_error($connection) . "</h2>";
			}
//tabella vendita
			$query = "CREATE TABLE IF NOT EXISTS Vendita(
				id_vendita INTEGER NOT NULL AUTO_INCREMENT,
				data VARCHAR(20),
				quantita INTEGER NOT NULL, 
				id_prodotto INTEGER NOT NULL REFERENCES Prodotto(id_prodotto),
				id_punto_vendita INTEGER NOT NULL REFERENCES Punto_vendita(id_punto_vendita),
				PRIMARY KEY(id_vendita)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella vendita creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella vendita: " . mysqli_error($connection) . "</h2>";
			}
//tabella magazzino
			$query = "CREATE TABLE IF NOT EXISTS Magazzino(
				id_magazzino INTEGER NOT NULL AUTO_INCREMENT,
				capienza INTEGER NOT NULL,
				spazio_disponibile INTEGER NOT NULL, 
				id_punto_vendita INTEGER NOT NULL REFERENCES Punto_vendita(id_punto_vendita),
				PRIMARY KEY(id_magazzino)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella magazzino creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella magazzino: " . mysqli_error($connection) . "</h2>";
			}
//tabella in_magazzino
			$query = "CREATE TABLE IF NOT EXISTS in_magazzino(
				id_in_magazzino INTEGER NOT NULL AUTO_INCREMENT,
				quantita INTEGER NOT NULL,
				id_prodotto INTEGER NOT NULL REFERENCES Prodotto(id_prodotto),
				id_magazzino INTEGER NOT NULL REFERENCES Magazzino(id_magazzino),
				PRIMARY KEY(id_in_magazzino)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella in magazzino creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella in magazzino: " . mysqli_error($connection) . "</h2>";
			}
//tabella dipendente
			$query = "CREATE TABLE IF NOT EXISTS Dipendente(
				id_dipendente INTEGER NOT NULL AUTO_INCREMENT,
				ruolo ENUM('gestore','addetto vendite'),
				nome VARCHAR(20),
				cognome VARCHAR(20),
				data_assunzione VARCHAR(20),
				data_scadenza VARCHAR(20),
				retribuzione REAL,
				id_punto_vendita INTEGER NOT NULL REFERENCES Punto_vendita(id_punto_vendita),
				PRIMARY KEY(id_dipendente)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella dipendente creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella dipendente: " . mysqli_error($connection) . "</h2>";
			}
//tabella reso
			$query = "CREATE TABLE IF NOT EXISTS Reso(
				id_reso INTEGER NOT NULL AUTO_INCREMENT,
				n_prodotti INTEGER NOT NULL,
				data VARCHAR(20),
				id_deposito INTEGER NOT NULL REFERENCES Deposito(id_deposito),
				PRIMARY KEY(id_reso)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella reso creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella reso: " . mysqli_error($connection) . "</h2>";
			}
//tabella assoc_reso
			$query = "CREATE TABLE IF NOT EXISTS Assoc_reso(
				id_assoc_reso INTEGER NOT NULL AUTO_INCREMENT,
				id_dipendente INTEGER NOT NULL REFERENCES Dipendente(id_dipendente),
				id_reso INTEGER NOT NULL REFERENCES Reso(id_reso),
				PRIMARY KEY(id_assoc_reso)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella assoc_reso creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella assoc_reso: " . mysqli_error($connection) . "</h2>";
			}
//tabella ordine
			$query = "CREATE TABLE IF NOT EXISTS Ordine(
				id_ordine INTEGER NOT NULL AUTO_INCREMENT,
				n_prodotti INTEGER NOT NULL,
				data VARCHAR(20),
				stato ENUM('ricevuto', 'in transito', 'in preparazione'),
				id_gestore INTEGER NOT NULL REFERENCES Dipendente(id_dipendente),
				id_deposito INTEGER NOT NULL REFERENCES Deposito(id_deposito),
				id_camionista INTEGER NOT NULL REFERENCES Camionista(id_camionista),
				PRIMARY KEY(id_ordine)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella ordine creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella ordine: " . mysqli_error($connection) . "</h2>";
			}
//tabella comprendere
			$query = "CREATE TABLE IF NOT EXISTS Comprendere(
				id_comprendere INTEGER NOT NULL AUTO_INCREMENT,
				quantita INTEGER NOT NULL,
				id_ordine INTEGER NOT NULL REFERENCES Ordine(id_ordine),
				id_prodotto INTEGER NOT NULL REFERENCES Prodotto(id_prodotto),
				PRIMARY KEY(id_comprendere)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella comprendere creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella comprendere: " . mysqli_error($connection) . "</h2>";
			}
//tabella camionista
			$query = "CREATE TABLE IF NOT EXISTS Camionista(
				id_camionista INTEGER NOT NULL AUTO_INCREMENT,
				nome VARCHAR(20),
				cognome VARCHAR(20),
				targa_mezzo VARCHAR(8),
				PRIMARY KEY(id_camionista)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella camionista creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella camionista: " . mysqli_error($connection) . "</h2>";
			}		
//tabella deposito
			$query = "CREATE TABLE IF NOT EXISTS Deposito(
				id_deposito INTEGER NOT NULL AUTO_INCREMENT,
				residenza VARCHAR(20),
				PRIMARY KEY(id_deposito)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella deposito creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella deposito: " . mysqli_error($connection) . "</h2>";
			}
//tabella responsabile
			$query = "CREATE TABLE IF NOT EXISTS Responsabile(
				id_responsabile INTEGER NOT NULL AUTO_INCREMENT,
				ruolo ENUM('Capo Divisione', 'Ispettore' ),
				nome VARCHAR(20),
				cognome VARCHAR(20),
				PRIMARY KEY(id_responsabile)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella responsabile creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella responsabile: " . mysqli_error($connection) . "</h2>";
			}
//tabella controllo
			$query = "CREATE TABLE IF NOT EXISTS Controllo(
				id_controllo INTEGER NOT NULL AUTO_INCREMENT,
				data VARCHAR(20),
				id_ispettore INTEGER NOT NULL REFERENCES Responsabile(id_responsabile),
				id_report INTEGER NOT NULL REFERENCES Report(id_report),
				id_punto_vendita INTEGER NOT NULL REFERENCES Punto_vendita(id_punto_vendita),
				PRIMARY KEY(id_controllo)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella controllo creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella controllo: " . mysqli_error($connection) . "</h2>";
			}
//tabella report
			$query = "CREATE TABLE IF NOT EXISTS Report(
				id_report INTEGER NOT NULL AUTO_INCREMENT,
				n_controlli INTEGER NOT NULL,
				esito ENUM('positivo', 'negativo'),
				descrizione VARCHAR(350),
				data VARCHAR(20),
				id_ispettore INTEGER NOT NULL REFERENCES Responsabile(id_responsabile),
				id_capo_divisione INTEGER NOT NULL REFERENCES Responsabile(id_responsabile),
				PRIMARY KEY(id_report)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella report creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella report: " . mysqli_error($connection) . "</h2>";
			}
//POPOLAMENTO TABELLE
			require_once("popola.php");
			if(popola("prodotti","prodotto",$connection))
				echo "<h2 style=\"color:green\">popolamento prodotto riuscito</h2>";
				else 
				echo "<h2 style=\"color:red\">errore popolamento prodotto</h2>";

			if(popola("dipendenti","dipendente",$connection))
				echo "<h2 style=\"color:green\">popolamento dipendete riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento dipendente</h2>";

			if(popola("responsabili","responsabile",$connection))
				echo "<h2 style=\"color:green\">popolamento responsabile riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento responsabile</h2>";

			if(build_pv($connection))
				echo "<h2 style=\"color:green\">popolamento punti vendita riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento punti vendita</h2>";

			$connection->close();
			
		?>
	</body>
</html>
