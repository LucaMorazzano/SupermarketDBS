<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>
			Popola tabelle
		</title>
	</head>
	<body>
		
		<?php
			function fileopen($filename) {
				$filepath = "Dataset/$filename.csv";
				
				
				if (!file_exists($filepath)) {
					echo "Il file $filename non esiste.";
					return;
				}
				
				
				$file = fopen($filepath, "r");
				return $file;
			}

			function popola($filename,$tabella,$connection) {
				$file=fileopen($filename);
				$skipfirstrow=true;

				if ($file) {
					while($row = fgetcsv($file)){

						if($skipfirstrow){
							$skipfirstrow=false;
							continue;
						}
//tabella prodotto
						if($tabella=="prodotto"){
							$id=$row[0]; 
							$nome=$row[1]; 
							$fornitore=$row[2];  
							$prezzo=$row[3];

							$query="INSERT INTO $tabella(id_prodotto,nome,fornitore,prezzo,id_magazzino,id_reso) VALUES ($id, '$nome', '$fornitore', $prezzo, 0,0)";
							if(!mysqli_query($connection,$query)){
								echo "<span style=\"color:red\">$query <b> $connection->error </b></span>";
								return false;
							}
						}
//tabella dipendente
						if($tabella=="dipendente"){					
							$id=$row[0];
							$ruolo=$row[1];
							$nome=$row[2];
							$cognome=$row[3];
							$data_a=$row[4];
							$data_s=$row[5];
							$retribuzione=$row[6];

							$query="INSERT INTO $tabella(id_dipendente,ruolo,nome,cognome,data_assunzione,data_scadenza,retribuzione,id_punto_vendita) VALUES ($id, '$ruolo','$nome', '$cognome', '$data_a', '$data_s', $retribuzione, 0)";
							if(!mysqli_query($connection,$query)){
								echo "<span style=\"color:red\">$query <b> $connection->error </b></span>";
								return false;
							}
						}
					}
				} 
				else {
					echo "Errore nell'apertura del file $filename.";
					return false;
				}
				return true;
			}
        ?>
        
    </body>
</html>