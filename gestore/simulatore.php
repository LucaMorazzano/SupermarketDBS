<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Simulatore</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("navbar.php");
            require_once("../install/connection.php");
            require_once("../install/getData.php");
        ?>
        <style type="text/css">
            #container{
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:45px;
            }

            .start-btn{
                background-color:green;
                color:white;
                border-radius:20px;
                padding:10px;
                font-size:30px;
            }

            .stop-btn{
                background-color:red;
                color:white;
                border-radius:20px;
                padding:10px;
                font-size:30px;
                margin-top:5%;
            }
            #finestra_vendite{
                border:solid black;
                background-color:black;
                color:white;
                font-family:Courier;
                overflow:scroll;
                height:400px;
                width:300px;
                
            }
            #center{
               text-align:center;
                
            }
            #resoconto{
                border:solid black;
                background-color:blue;
                color:white;
                font-size:20px;
                border-radius:10px;
                padding:20px;
                text-align:center;
            }
            #header{
                display:flex;
                justify-content:space-between;
                padding:45px;
                background-color:blue;
                border:solid black;
                color:white;
                border-radius:20px;
                margin-right:2%;
                margin-left:2%;
                font-family:Courier;
            }
            
        </style>
        <script>
            function waitFiveSeconds() {
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve();
                    }, 5000); // 5000 millisecondi = 5 secondi
                });
            }
            async function example() {
                console.log("Attendo 5 secondi...");
                
                await waitFiveSeconds(); // Aspetta 5 secondi
                
                console.log("5 secondi trascorsi!");
            }

        </script>
        </head>

        <body>
            <?php
            echo "<div id=\"header\">";
                echo "<h3> Finestra vendite</h3>";
                echo "<h3>Start/Stop</h3>";
                echo "<h3>Resoconto</h3>";
            echo "</div>";

            echo "<div id=\"container\">
                <div id=\"finestra_vendite\">";
                if(!isset($_POST['start'])){
                    echo "<p>In attesa...</p>";
                }
                else{
                    $id_pv=$_SESSION['id_punto_vendita'];
                    echo "<p>Sessione iniziata...</p>";
                    $magazzino=mysqli_fetch_array(getMagazzino($id_pv,$connection));
                    $sd=$magazzino['spazio_disponibile'];
                    $capienza=$magazzino['capienza'];
                    while($sd<$capienza && !(isset($_POST['stop']))){
                        $prodotti=getProdotti_PV($connection,$id_pv);
                        foreach($prodotti as $prodotto){
                            $prodotto=mysqli_fetch_array($prodotto);
                            $id_prodotto=$prodotto['id_prodotto'];
                            $nome_prodotto=$prodotto['nome'];
                            $price=$prodotto['prezzo'];
                            $query="SELECT * FROM vendita WHERE id_prodotto LIKE $id_prodotto AND id_punto_vendita LIKE $id_pv";
                            $result=mysqli_query($connection,$query);
                            if(!$result){
                                echo" $query...$connection->error<br />";
                                break;
                            }
                            else if(mysqli_num_rows($result)>0){ //prodotto gia presente
                                $totale=$price*5;
                                $query= "UPDATE vendita SET quantita= quantita + 5, totale= totale+ $totale WHERE id_prodotto LIKE $id_prodotto AND id_punto_vendita LIKE $id_pv";
                                $result=mysqli_query($connection,$query);
                                if(!$result)
                                    echo" $query...$connection->error<br />";
                            }
                            else{ //prodotto non presente
                                $totale=$price*5;
                                $query="INSERT INTO vendita (totale, quantita, id_prodotto, id_punto_vendita) VALUES ($totale, 5, $id_prodotto, $id_pv)";
                                $result=mysqli_query($connection,$query);
                                if(!$result)
                                    echo" $query...$connection->error<br />";
                            }
                            $totale=$price*5;
                            echo "<p>Prodotto: $nome_prodotto ($id_prodotto); Quantit&agrave;: 5; Totale: $totale&euro;  ";
                            $sd=$sd+5; //vendiamo 5 prodotti per volta (il trigger aggiornerà il tutto)
                            if ($sd >= $capienza) {
                                echo "<p>Sessione terminata...</p>";
                                break;
                            }
                            if (isset($_POST['stop'])) {
                                echo "<p>Sessione terminata...</p>";
                                break;
                            }
                        }
                        
                        echo "<p>Loading...</p>";
                        echo "<script>example();</script>";
                    }
                        
                    }
                if(isset($_POST['stop'])){
                    echo "<p>Sessione terminata...</p>";
                }

               echo " </div>";

            echo "<div id=\"center\">
                <form method=\"POST\" action=\"simulatore.php\" name=\"simulazione\">
                    <input class=\"start-btn\" type=\"submit\" name=\"start\" value=\"Avvia simulazione\"> <br />
                    <input  class=\"stop-btn\" type=\"submit\" name=\"stop\" value=\"Interrompi simulazione\">
                </form>

                </div>";
            
            //resoconto
            $id_pv=$_SESSION['id_punto_vendita'];
            $query="SELECT * FROM punto_vendita WHERE id_punto_vendita LIKE $id_pv";
            $result=mysqli_query($connection,$query);
            if(!$result){
                echo" $query...$connection->error<br />";
            }
            else{
            $info=mysqli_fetch_array($result);
            $vendite=$info['tot_vendite'];
            $incasso=$info['tot_incasso'];
            $magazzino=getMagazzino($id_pv,$connection);
            $magazzino=mysqli_fetch_array($magazzino);
            $spazio_disponibile=$magazzino['spazio_disponibile'];
            echo "<div id=\"resoconto\">
                <p>Totale vendite: <span style=\"color:yellow\">$vendite</span></p>
                <p>Totale incasso: <span style=\"color:yellow\">$incasso&euro;</span></p>
                <p>Spazio disponibile magazzino: <span style=\"color:yellow\">$spazio_disponibile</span></p>
                


            </div>";

            }

            echo "</div>";
        ?>
        </body>

</html>
