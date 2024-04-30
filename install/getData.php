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