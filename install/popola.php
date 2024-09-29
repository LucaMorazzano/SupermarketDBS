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

							$query="INSERT INTO $tabella(id_prodotto,nome,fornitore,prezzo) VALUES ($id, '$nome', '$fornitore', $prezzo)";
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

							$query="INSERT INTO $tabella(id_dipendente,ruolo,nome,cognome,data_assunzione,data_scadenza,retribuzione,id_punto_vendita) VALUES ($id, '$ruolo','$nome', '$cognome', '$data_a', '$data_s', $retribuzione, -1)";
						}
//tabella responsabile
						if($tabella=="responsabile"){
							$id=$row[0];
							$ruolo=$row[1];
							$nome=$row[2];
							$cognome=$row[3];

							$query="INSERT INTO $tabella(id_responsabile, ruolo, nome, cognome) VALUES ($id, '$ruolo', '$nome', '$cognome' )";
						}
//tabella deposito
						if($tabella=="deposito"){
							$id=$row[0];
							$residenza=$row[1];

							$query="INSERT INTO $tabella(id_deposito, residenza) VALUES ($id, '$residenza' )";
						}
//tabella camionista
						if($tabella=="camionista"){
							$id=$row[0];
							$nome=$row[1];
							$cognome=$row[2];
							$targa_mezzo=$row[3];

							$query="INSERT INTO $tabella(id_camionista, nome, cognome, targa_mezzo, stato) VALUES ($id, '$nome', '$cognome', '$targa_mezzo', 'disponibile')";
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


				if($gestori && $ispettori && $cdiv && $adv){
					$id=100;

					$isp_arr=sql_to_array($ispettori);
					$i=0;
					$cdiv_arr=sql_to_array($cdiv);
					$j=0;

					foreach($gestori as $gestore){
						$id_gestore=$gestore['id_dipendente'];
						
						if($i== mysqli_num_rows($ispettori))
							$i=0;
						$id_ispettore=$isp_arr[$i]['id_responsabile'];
						$i++;
						if($j== mysqli_num_rows($cdiv))
							$j=0;
						$id_capo_divisione=$cdiv_arr[$j]['id_responsabile'];
						$j++;
						
						$residenza=getResidenza();

						$query="INSERT INTO punto_vendita(id_punto_vendita, residenza, tot_vendite, tot_incasso, tot_dipendenti, id_ispettore, id_capo_divisione ) VALUES ($id, '$residenza', 0, 0, 0,  $id_ispettore, $id_capo_divisione)";
						if(!mysqli_query($connection,$query)){
							echo "$query ... $connection->error";
							return false;
						}

						$query="UPDATE dipendente 
									SET id_punto_vendita = $id
									WHERE id_dipendente LIKE $id_gestore";
						$id++;
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
					$id_magazzino=1;
					$query="INSERT INTO magazzino(capienza, spazio_disponibile, id_punto_vendita) VALUES ($capienza, $capienza, $id_pv)";
					$id_magazzino++;
					if(!mysqli_query($connection,$query)){
						echo "$query ... $connection->error";
						return false;
					}
				}
				return true;
			}

//inserimento prodotti in magazzino
			function insert_prodotti($connection){
				$prodotti=getProdotti($connection);
				$pvs= getPuntiVendita("tutti",$connection);
				//per ogni punto vendita inseriamo n prodotti pari al 50% della capienza del magazzino
				foreach($pvs as $pv){
					$id_pv=$pv['id_punto_vendita'];
					//otteniamo magazzino
					$result=getMagazzino($id_pv,$connection);
					$magazzino=mysqli_fetch_array($result);
					$id_magazzino=$magazzino['id_magazzino'];
					$capienza= $magazzino['capienza'];
					$limite= ($capienza *50)/100;
					$quantita=30;
					//per ogni prodotto aggiungiamo 10 pezzi fino a raggiungere il limite
					foreach($prodotti as $prodotto){
						$id_prodotto=$prodotto['id_prodotto'];
						if($capienza >= $limite){
							$query="INSERT INTO in_magazzino(quantita,id_prodotto,id_magazzino) VALUES ($quantita,$id_prodotto,$id_magazzino)";
							if(!mysqli_query($connection,$query)){
								echo "$query ... $connection->error";
								break;
							}
							$capienza=$capienza- $quantita;
							$query="SELECT spazio_disponibile FROM magazzino WHERE id_magazzino = $id_magazzino";
							$result=mysqli_query($connection,$query);
						}
						else
							break;
					}
				}
				return true;
			}

		?>

        
    </body>
</html>