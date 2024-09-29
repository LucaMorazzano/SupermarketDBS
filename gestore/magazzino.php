<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>
			Magazzino
		</title>
        <?php
            session_start();
            require_once("../install/connection.php");
            require_once("../install/getData.php");
            require_once("navbar.php");
        ?>
        <style>
            td{
                background-color:white;
            }
            th{
                color:white;
            }
        </style>
	</head>


	<body>
        <?php
            if($_SESSION['login']){

        ?>
        <?php
        //stampa tabella prodotti in magazzino + info magazzino
                $prodotti=getProdotti_PV($connection, $_SESSION['id_punto_vendita']);
                $id_pv=$_SESSION['id_punto_vendita'];
                echo "<div style=\"display:flex;align-items:center; justify-content: space-between\">";
                echo "<table style=\"background-color:blue; font-size:18px; margin-right:auto; margin-left:auto;  margin-top:5%;\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
                echo "<caption> Prodotti in magazzino del punto vendita: $id_pv</caption>";
                    echo "<thead>
                            <tr>
                                <th>ID PRODOTTO</th>
                                <th>NOME PRODOTTO</th>
                                <th>QUANTITA</th>
                            </tr></thead><tbody>";
                foreach ($prodotti as $prodotto){
                    $prodotto=mysqli_fetch_array($prodotto);
                    $id_prodotto=$prodotto['id_prodotto'];
                    $id_magazzino= mysqli_fetch_array(getMagazzino($_SESSION['id_punto_vendita'],$connection))['id_magazzino'];
                    $nome=$prodotto['nome'];
                    $result= getQuantita($id_prodotto, $id_magazzino, $connection);
                    if($result){
                        $result=mysqli_fetch_array($result);
                        $quantita=$result['quantita'];
                        echo "<tr>
                                <td>$id_prodotto</td> <td>$nome</td> <td>$quantita</td>
                                </tr>";
                    }
                }
                
                $magazzino= getMagazzino($_SESSION['id_punto_vendita'],$connection);
                $magazzino=mysqli_fetch_array($magazzino);
                $capienza= $magazzino['capienza'];
                $spazio_d = $magazzino['spazio_disponibile'];

                echo "<div style=\"font-size: 20px; border:solid black; background-color:blue; padding:5%; margin-left: 5%; margin-top:3%;\">";
                    echo "<p style=\"border:solid; text-align:center; background-color:white; padding:2%; border-radius:20px;\"><b>Capienza</b>:<br /> $capienza</p><br />";
                    echo "<p style=\"border: solid; text-align:center; background-color:white; padding:2%; border-radius:20px;\"><b>Spazio disponibile</b>: <br />$spazio_d</p> </br>";
                echo "</div>";
                echo "</div>";
            

                
        ?>
        <?php
            }
            else    
                echo "<h1>FORBIDDEN</h1>";
        ?>

    </body>
</html>
