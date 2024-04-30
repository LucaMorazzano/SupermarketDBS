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
//funzione fopen
			function fileopen($filename) {
				$filepath = "Dataset/$filename.csv";
				
				
				if (!file_exists($filepath)) {
					echo "Il file $filename non esiste.";
					return;
				}
				
				
				$file = fopen($filepath, "r");
				return $file;
			}
		?>

		<?php
//funzione popola
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

							$query="INSERT INTO $tabella(id_prodotto,nome,fornitore,prezzo,id_reso) VALUES ($id, '$nome', '$fornitore', $prezzo, 0)";
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
						}
//tabella responsabile
						if($tabella=="responsabile"){
							$id=$row[0];
							$ruolo=$row[1];
							$nome=$row[2];
							$cognome=$row[3];

							$query="INSERT INTO $tabella(id_responsabile, ruolo, nome, cognome) VALUES ($id, '$ruolo', '$nome', '$cognome' )";
						}




//invio query
						if(!mysqli_query($connection,$query)){
							echo "<span style=\"color:red\">$query <b> $connection->error </b></span>";
							return false;
						}


					} //fine while
					
				} 
				else {
					echo "Errore nell'apertura del file $filename.";
					return false;
				}
				return true;
			}
        ?>

		<?php
//crea punti vendita (per ogni gestore creiamo un punto vendita)
			function build_pv($connection){
				require_once("getData.php");
				$gestori= getGestori($connection);
				$ispettori=getIspettori($connection);
				$cdiv=getCapiDivisione($connection);
				$adv= getAddettiVendita($connection);
				$i=0; $j=0;

				if($gestori && $ispettori && $cdiv && $adv){
					$id=100;
					foreach($gestori as $gestore){
						$id_gestore=$gestore['id_dipendente'];
						if($i == mysqli_num_rows($ispettori))
							$i=0;
						mysqli_data_seek($ispettori, $i);
						$id_ispettore=$ispettori['id_responsabile'];
						$i++;
						$residenza=getResidenza();

						$query="INSERT INTO punto_vendita(id_punto_vendita, residenza, tot_vendite, tot_incasso, incasso_giornaliero, incasso_settimanale, id_ispettore ) VALUES ($id, '$residenza', 0, 0, 0, 0, $id_ispettore)";
						$id++;
						if(!mysqli_query($connection,$query)){
							echo "$query ... $connection->error";
							return false;
						}

						$query="UPDATE dipendente 
									SET id_punto_vendita = $id
									WHERE id_dipendente LIKE $id_gestore";
						if(!mysqli_query($connection,$query)){
							echo "$query ... $connection->error";
							return false;
						}
					}
					if(!insert_adv($adv,$connection))
							return false;
					if(!insert_magazzino($connection))
						return false;
				}
				else
					return false;
				return true;
			}
//inserimento addetti vendita
			function insert_adv($advs,$connection){
				$punti_vendita= getPuntiVendita("tutti",$connection);
				foreach($advs as $adv ){
					$id=$adv['id_dipendente'];
					$id_pv=rand(100, 99+ mysqli_num_rows($punti_vendita));
					$query= "UPDATE dipendente 
								SET id_punto_vendita = $id_pv
								WHERE id_dipendente LIKE $id";
					if(!mysqli_query($connection,$query)){
						echo "$query ... $connection->error";
						return false;
					}
				}
				return true;
			}
//popola magazzini
			function insert_magazzino($connection){
				$punti_vendita=getPuntiVendita("tutti", $connection);
				foreach($punti_vendita as $pv){
					$id_pv= $pv['id_punto_vendita'];
					$capienza=rand(100,800);
					$query="INSERT INTO magazzino(capienza, spazio_disponibile, id_punto_vendita) VALUES ($capienza, $capienza, $id_pv)";
					if(!mysqli_query($connection,$query)){
						echo "$query ... $connection->error";
						return false;
					}
				}
				return true;
			}

		?>

        
    </body>
</html>