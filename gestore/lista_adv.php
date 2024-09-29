<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Lista addetti vendita</title>

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
                //barra ricerca
                echo"
                <form name=\"form\" class=\"form-inline\" style=\" display:flex; align-items:center;margin-left:5%; margin-top:3%\" method=\"POST\" action=\"lista_adv.php\" >
                    <input name=\"info\" style=\"class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca dipendente\" aria-label=\"Search\">
                    <input style=\"margin-left: 5px; padding:3px;\" class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" value=\"Cerca\" name=\"cerca\">
                </form>";

                echo "<table style=\"background-color:blue; font-size:18px; margin-right:auto; margin-left:auto;  margin-top:5%;\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
                echo "<caption> Informazioni punto vendita: $id_pv</caption>";
                    echo "<thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>COGNOME</th>
                                <th>DATA ASSUNZIONE</th>
                                <th>DATA SCADENZA</th>
                                <th>RETRIBUZIONE</th>
                            </tr></thead><tbody>";

                            if(!isset($_POST['cerca']) || $_POST['info']==""){
                            $query="SELECT * FROM dipendente WHERE ruolo LIKE 'addetto vendite' AND id_punto_vendita LIKE $id_pv";
                            $res= mysqli_query($connection, $query);
                            }

                            else{
                                $input=$_POST['info'];
                                // % operatore jolly substring corr
                                $query= "SELECT * FROM dipendente WHERE ruolo LIKE 'addetto vendite' AND (nome LIKE '%$input%' OR cognome LIKE '%$input%' OR id_dipendente LIKE '%$input%') AND id_punto_vendita LIKE $id_pv ";
                                $res=mysqli_query($connection, $query);
                                if(!$res)
                                    echo" $query...$connection->error<br />";
                               
                            }

                            foreach($res as $result){
                                $id=$result['id_dipendente'];
                                $nome=$result['nome'];
                                $cognome=$result['cognome'];
                                $data_assunzione=$result['data_assunzione'];
                                $data_scadenza=$result['data_scadenza'];
                                $retribuzione=$result['retribuzione'];
                                echo "<tr>
                                         <td>$id</td> <td>$nome</td> <td> $cognome</td> <td>$data_assunzione</td><td>$data_scadenza</td>
                                         <td>$retribuzione&euro;</td> 
                                        </tr>";
                            }
                        
                            echo "</tbody></table>";
            

                ?>

        </body>
        </html>