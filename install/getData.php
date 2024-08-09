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
//get gestori
			function getGestori($connection){
				$query= "SELECT * FROM dipendente WHERE ruolo LIKE 'gestore'";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}
//get ispettori
			function getIspettori($connection){
				$query= "SELECT * FROM responsabile WHERE ruolo LIKE 'Ispettore'";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}

//get capi divisione
			function getCapiDivisione($connection){
				$query= "SELECT * FROM responsabile WHERE ruolo LIKE 'Capo divisione'";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}
//get Punti vendita
			function getPuntiVendita($residenza,$connection){
				if($residenza=="tutti")
					$query= "SELECT * FROM punto_vendita";
				else
					$query= "SELECT * FROM punto_vendita WHERE residenza LIKE '$residenza'";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}
//get prodotti
			function getProdotti($connection){
				$query="SELECT * FROM prodotto";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}
//get prodotti di pv
			function getProdotti_PV($connection,$id_pv){
				$query= "SELECT * FROM magazzino WHERE id_punto_vendita LIKE $id_pv";
				$magazzini= mysqli_query($connection,$query);
				$prodotti=array();
				//sfruttiamo associazione 1:1 
				$magazzino= mysqli_fetch_array($magazzini);
				$id_magazzino=$magazzino['id_magazzino'];

				$query="SELECT * FROM in_magazzino WHERE id_magazzino LIKE $id_magazzino";
				$result=mysqli_query($connection,$query);

				if($result){
					foreach($result as $res){
						$id_prodotto= $res['id_prodotto'];
						$query= "SELECT * FROM prodotto WHERE id_prodotto LIKE $id_prodotto";
						array_push($prodotti, mysqli_query($connection,$query));
					}
					return $prodotti;
				}
				else return false;
			}

//get quantita prodotto in magazzino
			function getQuantita($id_prodotto, $id_magazzino, $connection){
				$query="SELECT quantita FROM in_magazzino WHERE id_prodotto = $id_prodotto AND id_magazzino= $id_magazzino";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}

//get prodotti in reso 
			//function 

//get magazzino di un punto vendita
			function getMagazzino($id_pv,$connection){
				$query="SELECT * FROM magazzino WHERE id_punto_vendita = $id_pv";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}

//get punti vendita di responsabile
			function getPuntiVenditaResp($id, $option, $connection){
				if(!$id)
					return false;
				//da ispettore
				if($option == 0)
					$query="SELECT * FROM punto_vendita WHERE id_ispettore LIKE $id";
				//da capo divisione
				if($option == 1)
					$query="SELECT * FROM punto_vendita WHERE id_capo_divisione LIKE $id";

				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}

			}
//get adv
			function getAddettiVendita($connection){
				$query= "SELECT * FROM dipendente WHERE ruolo LIKE 'addetto vendite'";
				if($res= mysqli_query($connection,$query))
					return $res;
				else{
					echo" $query...$connection->error<br />";
					return false;
				}
			}
//login
			function LoginDipendente($id, $cognome, $connection){
				$query= "SELECT * FROM dipendente 
					WHERE id_dipendente LIKE $id AND cognome LIKE '$cognome'";
				$res= mysqli_query($connection,$query);
				if($res && mysqli_num_rows($res)>0)
					return $res;
				else
					return false;
			}

			function LoginResponsabile($id, $cognome, $connection){
				$query= "SELECT * FROM responsabile
					WHERE id_responsabile LIKE $id AND cognome LIKE '$cognome'";
				$res= mysqli_query($connection,$query);
				if($res && mysqli_num_rows($res)>0)
					return $res;
				else
					return false;
			}
//getResidenza
            function getResidenza(){
                $residenza = array(
                    "Roma",
                    "Milano",
                    "Napoli",
                    "Torino",
                    "Palermo",
                    "Genova",
                    "Bologna",
                    "Firenze",
                    "Bari",
                    "Catania",
                    "Venezia",
                    "Verona",
                    "Trieste",
                    "Brescia",
                    "Reggio Calabria",
                );
                $index=rand(0,sizeof($residenza)-1);
                return $residenza[$index];
            }

//getResi
			function getResi($id_adv,$connection){
				$query= "SELECT * FROM reso WHERE id_addetto_vendita LIKE $id_adv";
				$res=mysqli_query($connection,$query);
				
				if(!$res)
					return false;
				else
					return $res;
			}
			

//convert sql to array
			function sql_to_array($sqlobject){
				$result=array();
				foreach($sqlobject as $sqlelement)
						array_push($result, $sqlelement);
				return $result;
			}
		?>
	</body>
</html>