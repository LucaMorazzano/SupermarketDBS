<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Informazioni punto vendita</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("navbar.php");
            require_once("../install/connection.php");
            require_once("../install/getData.php");
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
                
                $id_pv=$_SESSION['id_punto_vendita'];
                echo "<table style=\"background-color:blue; font-size:18px; margin-right:auto; margin-left:auto;  margin-top:5%;\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
                echo "<caption> Informazioni punto vendita: $id_pv</caption>";
                    echo "<thead>
                            <tr>
                                <th>ID PUNTO VENDITA</th>
                                <th>RESIDENZA</th>
                                <th>VENDITE TOTALI</th>
                                <th>INCASSO TOTALE</th>
                                <th><a style=\"text-decoration:none;color:white;\" href=\"lista_adv.php\" title=\"lista addetti vendita\">NUMERO DIPENDENTI</a></th>
                                <th>ISPETTORE (ID)</th>
                                <th>CAPO DIVISIONE (ID)</th>
                            </tr></thead><tbody>";

                            $query="SELECT * FROM punto_vendita WHERE id_punto_vendita LIKE $id_pv";
                            $result= mysqli_query($connection, $query);

                            if($result){
                                $result=mysqli_fetch_array($result);
                                $residenza= $result['residenza'];
                                $totale_vendite= $result['tot_vendite'];
                                $tot_incasso=$result['tot_incasso'];
                                $tot_dipendenti=$result['tot_dipendenti'];
                                $id_ispettore=$result['id_ispettore'];
                                $id_capo_divisione=$result['id_capo_divisione'];
                                $query="SELECT cognome FROM responsabile WHERE id_responsabile LIKE $id_ispettore";
                                $ispettore=mysqli_fetch_array(mysqli_query($connection, $query))['cognome'];
                                $query="SELECT cognome FROM responsabile WHERE id_responsabile LIKE $id_capo_divisione";
                                $cdiv=mysqli_fetch_array(mysqli_query($connection, $query))['cognome'];
                                echo "<tr>
                                         <td>$id_pv</td> <td>$residenza</td> <td> $totale_vendite</td> <td>$tot_incasso</td><td>$tot_dipendenti</td>
                                         <td>$ispettore ($id_ispettore)</td> <td>$cdiv ($id_capo_divisione)</td>
                                        </tr>";
                            }
                            echo "</tbody></table>";
            

                ?>

        </body>
        </html>