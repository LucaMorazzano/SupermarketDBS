<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Ordini</title>

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
            #container{
                display:flex;
                justify-content:space-between;
                padding:45px;
            }
            #left{ 
                height: 500px; 
                overflow: auto; 
            }
            #tab thead th{
                position:sticky;
                top: 50px; /* Sposta il thead sotto il form */
                z-index: 1;
            }
            #tab tfoot{
                position:sticky;
                bottom:0;
            }
            #tab th{
                color:white;
                background-color:blue;
            }
            #tab{
                text-align:center;
            }
            #form {
            position: sticky;
            top: 0;
            background-color: #f1f1f1; /* Colore di sfondo */
            border-bottom: 2px solid black; /* Delimita visivamente il form dalla tabella */
            padding: 10px;
            z-index: 2; /* Assicura che il form sia sopra la tabella */
        }
        #tab2{
            width:50%;
        }
        #right{
            height: 500px; 
            overflow: auto; 
            margin-top:5%;
            margin-left:10%;
        }
        #tab2 tfoot{
                position:sticky;
                bottom:0;
            }
        #tab2 thead th{
                position:sticky;
                top: 0px; /* Sposta il thead sotto il form */
                z-index: 1;
         }
        </style>

        <script>
            function formvalidator(){
                var radio = document.getElementsByName('prodotti[]');
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

            if(isset($_POST['aggiungi'])){

                if(!isset($_SESSION['ordine'])){ //nuovo ordine
                    $id_gestore=$_SESSION['id'];
                    //settiamo l'id ordine nella session
                    $query="SELECT * FROM ordine ORDER BY id_ordine DESC";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    if(mysqli_num_rows($result)>0){
                        $top= mysqli_fetch_array($result)['id_ordine'];
                        $_SESSION['ordine']= $top+1;
                    }
                    else
                        $_SESSION['ordine']=1;

                    $id_ordine=$_SESSION['ordine'];
                    $data = date('Y-m-d');
                    $query="INSERT INTO ordine (id_ordine, data, stato, id_gestore, id_deposito, id_camionista) VALUES ($id_ordine, \"$data\",\"aperto\",$id_gestore,-1,-1)";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";

                }

                $id_ordine=$_SESSION['ordine'];
                $id_pv=$_SESSION['id_punto_vendita'];
                $post=$_POST['prodotti'];
                $n_prodotti=0;
                $magazzino= mysqli_fetch_array(getMagazzino($id_pv,$connection));
                $sd=$magazzino['spazio_disponibile'];

                foreach($post as $p){
                    //verifichiamo che n_prodotti non superi spazio disponibile
                    $query="SELECT n_prodotti FROM ordine WHERE id_ordine LIKE $id_ordine";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    $in_ordine= mysqli_fetch_array($result)['n_prodotti'];
                    ///////////////////////////////////////////////////////////
                    $id_prodotto=$p;
                    $quantita=$_POST[$id_prodotto];
                    $alloc= $quantita+ $in_ordine;

                    $query="SELECT * FROM prodotto WHERE id_prodotto LIKE $id_prodotto";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    $prodotto=mysqli_fetch_array($result);
                    $nome=$prodotto['nome'];
                    $fornitore=$prodotto['fornitore'];

                    if($alloc <= $sd){ //se c'è spazio
                        if($quantita>0){
                            $query="SELECT * FROM comprendere WHERE id_prodotto LIKE $id_prodotto AND id_ordine LIKE $id_ordine";
                            $result=mysqli_query($connection,$query);
                            if(!$result)
                                echo" $query...$connection->error<br />";
                            if(mysqli_num_rows($result)<=0) 
                                $query="INSERT INTO comprendere (quantita,id_ordine,id_prodotto) VALUES ($quantita, $id_ordine, $id_prodotto)";
                            else 
                                $query="UPDATE comprendere SET quantita= quantita + $quantita WHERE id_ordine LIKE $id_ordine AND id_prodotto LIKE $id_prodotto";
                                
                            $result=mysqli_query($connection,$query);
                            if(!$result)
                                echo" $query...$connection->error<br />";
                        }
                    }
                    else{
                        echo "<p style=\"color:red\">Impossibile aggiungere <b>$quantita</b> colli di <b>$nome($id_prodotto)</b>, spazio in magazzino non sufficiente </p>";
                            continue;
                    }
                }
            }

          ?>

        <?php
            if(isset($_POST['rimuovi'])){
                $post=$_POST['prodotti'];
                $id_ordine=$_SESSION['ordine'];
                foreach($post as $prodotto){
                    $id_prodotto= $prodotto;
                    echo "$id_prodotto";
                    $quantita=$_POST[$id_prodotto];
                    $query="SELECT quantita FROM comprendere WHERE id_prodotto LIKE $id_prodotto AND id_ordine LIKE $id_ordine";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    $q= mysqli_fetch_array($result)['quantita'];
                    if($quantita == $q)
                        $query="DELETE FROM comprendere WHERE id_prodotto LIKE $id_prodotto AND id_ordine LIKE $id_ordine";
                    else
                        $query="UPDATE comprendere SET quantita= quantita - $quantita WHERE id_prodotto LIKE $id_prodotto AND id_ordine LIKE $id_ordine";
                    $result=mysqli_query($connection,$query);
                            if(!$result)
                                echo" $query...$connection->error<br />";
                }
            }
        ?>

        <?php
            $id_pv=$_SESSION['id_punto_vendita'];
            echo "<div id=\"container\">";
            
            echo "<div id=\"left\">
                <form id=\"form\" class=\"form-inline\" style=\" display:flex; align-items:center; margin-top:3%\" method=\"POST\" action=\"nuovo_ordine.php\" >
                    <input name=\"info\" style=\"class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Cerca prodotto\" aria-label=\"Search\">
                    <input style=\"margin-left: 5px; padding:3px;\" class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" value=\"Cerca\" name=\"cerca\">
                </form>
            <table id=\"tab\" style=\" font-size:18px; margin-right:auto; margin-left:auto;  margin-top:5%;\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">
                <thead>
                <tr>
                    <th>ORDINA</th>
                    <th>PRODOTTI ORDINABILI</th>
                    <th>QUANTIT&Agrave; VENDUTA</th>
                    <th>QUANTIT&Agrave; IN MAGAZZINO</th>
                </tr>
                </thead><tbody>";
            if(!isset($_POST['cerca']) || $_POST['info']=="")
                $prodotti= getProdotti($connection);
            else{
                $input=$_POST['info'];
                $query="SELECT * FROM prodotto WHERE (nome LIKE '%$input%' OR fornitore LIKE '%$input%' OR id_prodotto LIKE '%$input%') ";
                $prodotti=mysqli_query($connection,$query);
                if(!$prodotti)
                    echo" $query...$connection->error<br />";
            }
                
            echo "<form action=\"nuovo_ordine.php\" method=\"POST\" onsubmit=\"return formvalidator()\">";
            foreach ($prodotti as $p){
                $id_p=$p['id_prodotto'];
                $nome=$p['nome'];
                $fornitore=$p['fornitore'];
                $query="SELECT quantita FROM vendita WHERE id_prodotto LIKE $id_p AND id_punto_vendita LIKE $id_pv";
                $result=mysqli_query($connection,$query);
                if(!$result)
                    echo" $query...$connection->error<br />";
                if(mysqli_num_rows($result)>0)
                    $quantita=mysqli_fetch_array($result)['quantita'];
                else $quantita=0;
                $magazzino= mysqli_fetch_array(getMagazzino($id_pv,$connection));
                $id_magazzino= $magazzino['id_magazzino'];
                $capienza=$magazzino['capienza'];
                $spazio_disponibile=$magazzino['spazio_disponibile'];
                $q_inmagazzino=getQuantita($id_p,$id_magazzino,$connection);
                if(mysqli_num_rows($q_inmagazzino)>0)
                    $q_inmagazzino=mysqli_fetch_array($q_inmagazzino)['quantita'];
                else
                    $q_inmagazzino=0;
                echo "<tr>
                    <td><input type=\"checkbox\" name=\"prodotti[]\" value=\"$id_p\">
                    <input name=\"$id_p\" value=\"0\" type=\"number\" min=\"0\" max=\"$spazio_disponibile\"></td>
                    <td>$nome, $fornitore ($id_p)</td>
                    <td>$quantita</td>
                    <td>$q_inmagazzino</td>
                </tr>"; 
            }
                

                    
               echo " </tbody> 
               <tfoot>
               <tr>
               <td colspan=\"4\" style=\"background-color:blue\"><input type=\"submit\" name=\"aggiungi\" value=\"Aggiungi all'ordine\" style=\"background-color:green; border-radius:20px; color:white; border:solid white; font-size:20px; padding:5px;\">
               </td></tr>
               </tfoot></table></form></div>";

            
            if(isset($_SESSION['ordine'])){
                echo "<div id=\"right\"> <p>Ordine corrente: <br /></p>";
                echo "<table id=\"tab2\" border=\"1\" cellspacing=\"3\" cellpadding=\"10\">";
                echo "<thead>
                <tr>
                <th>Rimuovi</th>
                <th>Prodotto</th>
                <th>Quantit&agrave;</th>
                </thead><tbody>";
                echo "<form action=\"nuovo_ordine.php\" method=\"POST\"  onsubmit=\"return formvalidator()\">";
                $id_ordine=$_SESSION['ordine'];
                $query="SELECT * FROM comprendere WHERE id_ordine LIKE $id_ordine";
                $result=mysqli_query($connection,$query);
                if(!$result)
                        echo" $query...$connection->error<br />";

                foreach($result as $comp){
                    $quantita=$comp['quantita'];
                    $id_prodotto=$comp['id_prodotto'];
                    $query="SELECT * FROM prodotto WHERE id_prodotto LIKE $id_prodotto";
                        $result=mysqli_query($connection,$query);
                        if(!$result)
                            echo" $query...$connection->error<br />";
                    $prodotto=mysqli_fetch_array($result);
                    $nome=$prodotto['nome'];
                    $fornitore=$prodotto['fornitore'];
                    echo "<tr>
                        <td><input type=\"checkbox\" name=\"prodotti[]\" value=\"$id_prodotto\">
                        <input name=\"$id_prodotto\" value=\"0\" type=\"number\" min=\"0\" max=\"$quantita\"></td>
                        <td>$nome, $fornitore ($id_prodotto)</td>
                        <td>$quantita</td></tr>";
                }
                echo "</tbody>
                <tfoot style=\"background-color:blue\">
                <tr>
                <td><input type=\"submit\" name=\"rimuovi\" value=\"Rimuovi\" style=\"background-color:red; border-radius:20px; color:white; border:solid white; padding:5px;\"></td>
                </form>
                <form action=\"chiudi_ordine.php\" method=\"POST\">
                 <td><input type=\"submit\" name=\"archivia\" value=\"Archivia ordine\" style=\"background-color:azure; border-radius:20px; color:black; border:solid white; padding:5px;\"></td>
                <td ><input type=\"submit\" name=\"chiudi\" value=\"Chiudi ordine\" style=\"background-color:red; border-radius:20px; color:white; border:solid white; padding:5px;\">
                </td></tr>
                </tfoot>";
                $sd=mysqli_fetch_array(getMagazzino($id_pv,$connection))['spazio_disponibile'];
                echo "<caption>Spazio in magazzino: $sd</caption>";
                echo "</table></form></div>";
            }
            echo "</div>";
        ?>
    </body>
</html>
