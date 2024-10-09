<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Lista ordini</title>

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
                    text-align:center;
                }
                th{
                    color:white;
                }
        </style>

        <script>
            function formvalidator(){
                var radio = document.getElementsByName('id_ordine');
                var ischecked= false;
                for (var i = 0; i < radio.length; i++) {
                if (radio[i].checked) {
                    ischecked = true;
                    break;
                    }
                }

                if (!ischecked) {
                    alert("Per favore, seleziona almeno un'opzione.");
                    return false; 
                }
                
                return true; 
            }   

        </script>
    </head>
    <body>

    <?php
         $id_gestore=$_SESSION['id'];

         if(isset($_SESSION['error'])){
            $error=$_SESSION['error'];
            echo "<p style=\"color:red\">Impossibile inviare ordine numero: $error  spazio in magazzino non sufficiente</p>";
         }

         echo "<table style=\"background-color:blue; font-size:18px; margin-right:auto; margin-left:auto;  margin-top:5%;\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
         echo "<caption> Ordini effettuati</caption>";
             echo "<thead>
                     <tr>
                        <th>SELEZIONA</th>
                         <th>ID ORDINE</th>
                         <th>DATA</th>
                         <th>NUMERO PRODOTTI</th>
                         <th>STATO</th>
                         <th>DEPOSITO</th>
                         <th>CAMIONISTA</th>
                     </tr></thead><tbody>";

                     $query="SELECT * FROM ordine WHERE id_gestore LIKE $id_gestore ORDER BY id_ordine DESC";
                     $result= mysqli_query($connection, $query);
                     if(!$result)
                            echo" $query...$connection->error<br />";
                    if(mysqli_num_rows($result)>0){
                    echo "<form action=\"chiudi_ordine.php\" method=\"POST\" onsubmit=\"return formvalidator()\">";
                    foreach($result as $ordine){
                        $id_ordine=$ordine['id_ordine'];
                        $n_prodotti=$ordine['n_prodotti'];
                        $data=$ordine['data'];
                        $stato=$ordine['stato'];
                        if($stato == "aperto"){
                            $id_deposito="ATTESA INVIO";
                            $id_camionista="ATTESA INVIO";
                        }
                        else{
                            $id_deposito=$ordine['id_deposito'];
                            $id_camionista=$ordine['id_camionista'];
                        }

                        echo "<tr>";

                                if($stato == "aperto")
                                    echo "<td><input type=\"radio\" name=\"id_ordine\" value=\"$id_ordine\"></td>";
                                else    
                                    echo "<td style=\"background-color:red\"></td>";

                                echo "<td>$id_ordine</td> <td>$data</td> <td> $n_prodotti</td>";
                                if($stato == "aperto")
                                    echo "<td style=\"background-color:green; color:white;\">$stato</td>";
                                else
                                    echo "<td style=\"background-color:red; color:white;\">$stato</td>"; 
                            echo "<td>$id_deposito</td>
                            <td>$id_camionista</td>
                            </tr>";
                    }
                     echo "</tbody>
                     <tfoot >
                    <tr><td colspan=\"3\"><input type=\"submit\" name=\"modifica\" value=\"Modifica\" style=\"background-color:azure; border-radius:20px;\"></td>
                    <td></td>
                    <td colspan=\"3\"><input type=\"submit\" name=\"elimina\" value=\"Elimina\" style=\"background-color:red; color:white; border-radius:20px;\"></td></tr>
                    </tfoot></form>";
                }
                
                echo "</table>";
                
                if(isset($_SESSION['error']))
                    unset($_SESSION['error']);
                ?>

            </body>
            </html> 


    ?>

    <body>
</html>