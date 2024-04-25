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
				$error=0;
				if ($file) {
					while(!feof($file)){
						$row = fgetcsv($file);

						if($skipfirstrow){
							$skipfirstrow=false;
							continue;
						}

						if($tabella=="Prodotto"){
							$id=$row[0]; 
							$nome=$row[1]; 
							$fornitore=$row[2];  
							$prezzo=$row[3];

							$query="INSERT INTO $tabella(id_prodotto,nome,fornitore,prezzo,id_magazzino,id_reso) VALUES ($id, '$nome', '$fornitore', $prezzo, 0,0)";
							echo $query;
							if(!mysqli_query($connection,$query))
								$error++;
						}

					}

					if($error==0)
						echo "<h2 style=\"color:green\">popolamento $tabella riuscito</h2>";
					else 
						echo "<h2 style=\"color:red\">errore popolamento $tabella</h2>";
					
					fclose($file);
				} else 
					echo "Errore nell'apertura del file $filename.";

			}
        ?>
        
    </body>
</html>