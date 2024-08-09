<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Lista resi</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("../install/connection.php");
            require_once("../install/getData.php");
        ?>
      <style type="text/css">
            #lista_resi{
                border: solid black;
            }
            .list-group-item{
                display:flex;
                justify-content:space-between;
            }
            .bottone{
                color: #fff;
                background-color: #28a745;
                border-color: #28a745;
            }
            table{
                margin-left:auto;
                margin-right:auto;
            }
            thead{
                background-color:beige;
            }
            th, td{
                text-align:center;
            }
        </style>

        <?php
            require_once("navbar.php");
            $id_adv=$_SESSION['id'];
            $query="SELECT * FROM reso WHERE id_addetto_vendita LIKE $id_adv";
            $result=mysqli_query($connection, $query);
            echo "<h2 style=\"text-align:center; margin-top:30px\"> LISTA RESI</h2>";
            echo "<form action=\"new_reso.php\" method=\"POST\">";
            echo "<table border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
            echo "<caption> Addetto vendite: $id_adv </caption>";
                echo "<thead>
                        <tr>
                            <th>ID RESO</th>
                            <th>DATA</th>
                            <th>NUMERO PRODOTTI</th>
                            <th>STATO</th>
                            <th>ID ADDETTO VENDITA RESPONSABILE</th>
                            <th>ID DEPOSITO</th>
                            <th>SELEZIONA</th>
                        </tr></thead><tbody>";
            if($result){
                foreach($result as $reso){
                    $id_reso= $reso['id_reso'];
                    $n_prodotti= $reso['n_prodotti'];
                    $stato= $reso['stato'];
                    $data=$reso['data'];
                    $id_deposito= $reso['id_deposito'];
                    $id_adv =$reso['id_addetto_vendita'];
                    echo "<tr>
                        <td>$id_reso</td>
                        <td>$data</td>
                        <td>$n_prodotti</td>";
                        if($stato=="aperto")
                            echo"<td style=\"background-color:green;color:white\">$stato</td>";
                        else
                         echo"<td style=\"background-color:red;color:white\">$stato</td>";
                            echo"
                        <td>$id_deposito</td>
                        <td>$id_adv</td>
                        <td><input type=\"radio\" name=\"selection\" value=\"$id_reso\"></input></td>
                    </tr>";
                }
                echo "<caption> <input style=\"background-color:red;color:white\" type=\"submit\" value=\"Chiudi reso\">
                <input style=\"background-color:blue; color:white\" type=\"submit\" value=\"Modifica reso\"></caption>";
                echo "</tbody></table></form>";

            }
            else
                echo "<script> alert(\"sql error()\")</script>";


        ?>