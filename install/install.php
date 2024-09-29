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
				tot_dipendenti INTEGER,
				id_ispettore INTEGER NOT NULL ,
				id_capo_divisione INTEGER NOT NULL,
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
				totale REAL,
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
				id_prodotto INTEGER NOT NULL REFERENCES Prodotto(id_prodotto) ,
				id_magazzino INTEGER NOT NULL REFERENCES Magazzino(id_magazzino) ,
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
				id_punto_vendita INTEGER NOT NULL REFERENCES Punto_vendita(id_punto_vendita) ,
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
				stato ENUM ('aperto' , 'chiuso'),
				id_deposito INTEGER NOT NULL REFERENCES Deposito(id_deposito) ,
				id_addetto_vendita INTEGER NOT NULL REFERENCES Dipendente(id_dipendente),
				PRIMARY KEY(id_reso)
			)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella reso creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella reso: " . mysqli_error($connection) . "</h2>";
			}
//tabella in_reso
			$query="CREATE TABLE IF NOT EXISTS in_reso(
				id_in_reso INTEGER NOT NULL AUTO_INCREMENT,
				quantita INTEGER NOT NULL,
				id_reso INTEGER NOT NULL REFERENCES Reso(id_reso),
				id_prodotto INTEGER NOT NULL REFERENCES Prodotto(id_prodotto),
				PRIMARY KEY (id_in_reso)
				)";
			echo $query;
			if (mysqli_query($connection, $query)) {
				echo "<h2 style=\"color:green\">Tabella in_reso creata</h2>";
			} else {
				echo "<h2 style=\"color:red\">Errore creazione tabella in_reso: " . mysqli_error($connection) . "</h2>";
			}

//tabella ordine
			$query = "CREATE TABLE IF NOT EXISTS Ordine(
				id_ordine INTEGER NOT NULL AUTO_INCREMENT,
				n_prodotti INTEGER NOT NULL,
				data VARCHAR(20),
				stato ENUM('ricevuto', 'in transito', 'in preparazione'),
				id_gestore INTEGER NOT NULL REFERENCES Dipendente(id_dipendente) ,
				id_deposito INTEGER NOT NULL REFERENCES Deposito(id_deposito) ,
				id_camionista INTEGER NOT NULL REFERENCES Camionista(id_camionista) ,
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
				id_ordine INTEGER NOT NULL REFERENCES Ordine(id_ordine) ,
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
				stato ENUM('disponibile', 'occupato' ),
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
				id_ispettore INTEGER NOT NULL REFERENCES Responsabile(id_responsabile) ,
				id_report INTEGER NOT NULL REFERENCES Report(id_report)ON UPDATE CASCADE ,
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

//Trigger
			$trigger=array();

//chiusura punto vendita (effettuata da capo divisione)
			$trigger[0]="CREATE DEFINER=`root`@`localhost` TRIGGER `chiusura_pv` AFTER DELETE ON `punto_vendita` FOR EACH ROW BEGIN
			DELETE FROM dipendente WHERE id_punto_vendita=OLD.id_punto_vendita;
			DELETE FROM magazzino WHERE id_punto_vendita=OLD.id_punto_vendita;
			DELETE FROM controllo WHERE id_punto_vendita=OLD.id_punto_vendita;
			END;";

//licenziamento dipendente (chiusra pv | licenziamento da ispettore)
			$trigger[1]="CREATE DEFINER=`root`@`localhost` TRIGGER `licenziamento_dipendente` AFTER DELETE ON `dipendente` FOR EACH ROW BEGIN
			DELETE FROM assoc_reso WHERE id_dipendente= OLD.id_dipendente;
			DELETE FROM ordine WHERE id_gestore = OLD.id_dipendente;
			END;";

//assunzione dipendente (apertura pv | assunzione da ispettore)
			$trigger[2]="CREATE DEFINER=`root`@`localhost` TRIGGER `assunzione_dipendente` AFTER INSERT ON `dipendente` FOR EACH ROW BEGIN
			UPDATE punto_vendita SET tot_dipendenti= tot_dipendenti + 1 WHERE id_punto_vendita = NEW.id_punto_vendita;
			END;";
			
//trasferimento dipendente
			$trigger[3]="CREATE DEFINER=`root`@`localhost` TRIGGER `update_dipendente` AFTER UPDATE ON `dipendente` FOR EACH ROW BEGIN
			IF OLD.id_punto_vendita != NEW.id_punto_vendita THEN
				UPDATE punto_vendita SET tot_dipendenti= tot_dipendenti + 1 WHERE id_punto_vendita = NEW.id_punto_vendita;
				UPDATE punto_vendita SET tot_dipendenti= tot_dipendenti + 1 WHERE id_punto_vendita = OLD.id_punto_vendita;
			END IF;
			END;";
//cancellazione ordine
			$trigger[4]="CREATE DEFINER=`root`@`localhost` TRIGGER `cancellazione_ordine` AFTER DELETE ON `ordine` FOR EACH ROW BEGIN
			DELETE FROM comprendere WHERE id_ordine= OLD.id_ordine;
			UPDATE magazzino SET capienza= capienza + OLD.n_prodotti;
			UPDATE camionita SET stato= 'disponibile' WHERE ordine.id_camionista = camionista.id_camionista;
			END;";

//nuovo ordine
			$trigger[5]="CREATE DEFINER=`root`@`localhost` TRIGGER `ordine_transito` AFTER INSERT ON `ordine` FOR EACH ROW BEGIN
			UPDATE camionista SET stato = 'occupato' WHERE id_camionista = NEW.id_camionista;
			UPDATE ordine SET stato='in transito' WHERE id_camionista= NEW.id_camionista;
			END;";

//ordine consegnato
			$trigger[6]="CREATE DEFINER=`root`@`localhost` TRIGGER `ordine_consegnato` AFTER UPDATE ON `camionista` FOR EACH ROW BEGIN
			IF NEW.stato ='disponibile' THEN
				UPDATE ordine SET stato='ricevuto' WHERE id_camionista = NEW.id_camionista;
			END IF;
			END;";
//aggiornamento magazzino
			$trigger[7]="CREATE DEFINER=`root`@`localhost` TRIGGER `aggiorna_capienza` AFTER UPDATE ON `ordine` FOR EACH ROW BEGIN
			IF NEW.stato ='ricevuto' THEN
				UPDATE magazzino INNER JOIN punto_vendita INNER JOIN dipendente
				 SET spazio_disponibile= spazio_disponibile - NEW.n_prodotti WHERE dipendente.id_dipendente = NEW.id_gestore AND dipendente.id_punto_vendita = punto_vendita.id_punto_vendita
				 AND magazzino.id_punto_vendita = punto_vendita.id_punto_vendita;
			END IF;
			END;";

//vendita prodotto
			$trigger[8]="CREATE DEFINER=`root`@`localhost` TRIGGER `magazzino_remove` AFTER DELETE ON `magazzino` FOR EACH ROW BEGIN
			DELETE FROM in_magazzino WHERE id_magazzino= OLD.id_magazzino;
			END;";

			$trigger[9]="CREATE DEFINER=`root`@`localhost` TRIGGER `vendita_prodotto` AFTER INSERT ON `vendita` FOR EACH ROW BEGIN
			UPDATE punto_vendita SET tot_vendite = tot_vendite + NEW.quantita WHERE id_punto_vendita LIKE NEW.id_punto_vendita;
			UPDATE punto_vendita SET tot_incasso = tot_incasso + NEW.totale WHERE id_punto_vendita LIKE NEW.id_punto_vendita;
			UPDATE magazzino SET capienza= capienza + NEW.quantita WHERE id_punto_vendita LIKE NEW.id_punto_vendita;
			UPDATE in_magazzino SET quantita= quantita - NEW.quantita WHERE id_prodotto LIKE NEW.id_prodotto;
			END;";

//aggiorna capienza
			$trigger[10]= "CREATE DEFINER =`root`@`localhost` TRIGGER `inserimento_magazzino` AFTER INSERT ON `in_magazzino` FOR EACH ROW BEGIN
			UPDATE magazzino SET spazio_disponibile= spazio_disponibile - NEW.quantita WHERE id_magazzino = NEW.id_magazzino;
			END;";

//inserimento prodotto in reso
			$trigger[11]= "CREATE DEFINER =`root`@`localhost` TRIGGER `inserimento_in_reso` AFTER INSERT ON `in_reso` FOR EACH ROW BEGIN
			UPDATE reso SET n_prodotti= n_prodotti + NEW.quantita WHERE id_reso = NEW.id_reso;
			UPDATE in_magazzino SET quantita= quantita- NEW.quantita WHERE id_prodotto = NEW.id_prodotto; 
			END;";
//inserimento in_reso di prodotto già presente
			$trigger[12]= "CREATE DEFINER =`root`@`localhost` TRIGGER `update_in_reso` AFTER UPDATE ON `in_reso` FOR EACH ROW BEGIN
			UPDATE reso SET n_prodotti= n_prodotti + NEW.quantita WHERE id_reso = NEW.id_reso;
			UPDATE in_magazzino SET quantita= quantita- NEW.quantita WHERE id_prodotto = NEW.id_prodotto; 
			END;";

//rimozione prodotto da reso 
			$trigger[13]= "CREATE DEFINER =`root`@`localhost` TRIGGER `rimozione_in_reso` AFTER DELETE ON `in_reso` FOR EACH ROW BEGIN
			UPDATE reso SET n_prodotti= n_prodotti - OLD.quantita WHERE id_reso = OLD.id_reso;
			UPDATE in_magazzino SET quantita= quantita + OLD.quantita WHERE id_prodotto = OLD.id_prodotto; 
			END;";

			for($i=0;$i<sizeof($trigger);$i++){
				if(!mysqli_query($connection,$trigger[$i])){
					echo $trigger[$i];
					echo "<h2 style=\"color:red\">Errore definizione trigger</h2>";
					break;
				}
			}
			echo "<h2 style=\"color:green\">Trigger definiti correttamente</h2>";



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

			if(popola("camionisti","camionista",$connection))
				echo "<h2 style=\"color:green\">popolamento camionista riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento camionista</h2>";

			if(popola("depositi","deposito",$connection))
				echo "<h2 style=\"color:green\">popolamento deposito riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento deposito</h2>";

			if(build_pv($connection))
				echo "<h2 style=\"color:green\">popolamento punti vendita riuscito</h2>";
			else 
				echo "<h2 style=\"color:red\">errore popolamento punti vendita</h2>";

			if(insert_prodotti($connection))
				echo "<h2 style=\"color:green\">prodotti inseriti nei punti vendita</h2>";
			else 
				echo "<h2 style=\"color:red\">errore inserimento prodotti nei punti vendita</h2>";
			$connection->close();
			
		?>
	</body>
</html>
