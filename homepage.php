<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Home</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("install/connection.php");
            require_once("install/getData.php");
            require_once("navbar.php");
        ?>

        <style type="text/css">
            .container{
                border:solid black;
                border-radius:20px;
            }
            .row{
                padding:10%;
            }
            .col-sm-6 a:hover{
                color:red;
            }
            .list-group-item{
                display:flex;
                justify-content:space-between;
            }
        </style>

        <?php
//menu gestore
            function home_gestore(){
                echo "
                <div class=\"container\" style=\"margin-top:7%;\">
                <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <h3><a class=\"nav-link active\" href=\"gestore/ordini.php\">Ordini</a></h3>
                        </div>
                        <div class=\"col-sm-6\">
                            <h3><a class=\"nav-link active\" href=\"gestore/info_puntovendita.php\">Informazioni punto vendita</a></h3>
                        </div>
                        <div class=\"col-sm-6\">
                            <h3><a class=\"nav-link active\" href=\"gestore/lista_adv.php\">Lista addetti vendita</a></h3>
                        </div>
                        <div class=\"col-sm-6\">
                            <h3><a class=\"nav-link active\" href=\"gestore/magazzino.php\">Magazzino</a></h3>
                        </div>
                </div>
                </div>
                
                ";
            }
//menu addetto vendite
            function home_adv($connection){
                $result=getResi($_SESSION['id'],$connection);
                echo "<ul class=\"list-group\" style=\"font-size:20px\">
                <li class=\"list-group-item\" style=\"font-size:30px; background-color:grey; color:white;\">
                <b>Gestione resi</b>
                </li>";
                echo "<li class=\"list-group-item\"><a href=\"adv/new_reso.php\" class=\"btn btn-success\">+ Inserisci reso</a></li>";
                foreach($result as $reso){
                    $idreso=$reso['id_reso'];
                    $data=$reso['data'];
                    $deposito=$reso['id_deposito'];
                    $stato=$reso['stato'];
                    echo "<li class=\"list-group-item\"><p>Reso numero:$idreso in $data a deposito: $deposito </p>
                    <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">";

                    if($stato == "aperto"){
                        echo "<a href=\"adv/reso.php\" class=\"btn btn-secondary\">Modifica reso</a>
                       <p class=\"btn btn-succsess\">Reso Aperto</p>";
                    }
                    else{
                        echo "<a href=\"adv/reso.php\" class=\"btn btn-primary\">Informazioni reso</a>
                        <p class=\"btn btn-danger\">Reso chiuso</p>";
                    }
                    echo "</div></li>";
                }
                echo "</ul>";
            }
//menu ispettore
            function home_ispettore($connection){
                $result= getPuntiVenditaResp($_SESSION['id'],0,$connection);
                echo"
                <ul class=\"list-group\" style=\"font-size:20px\">
                <li class=\"list-group-item\" style=\"font-size:30px; background-color:grey; color:white;\">
                <b>Lista punti vendita</b>
                </li>";
                foreach($result as $pv){
                    $id=$pv['id_punto_vendita'];
                    $residenza=$pv['residenza'];
                    echo "<li class=\"list-group-item\"><p>$residenza $id</p>
                    <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">
                        <a href=\"info_pv.php\" class=\"btn btn-primary\">Informazioni</a>
                        <a href=\"ispettore/gestisci_dipendenti.php\" class=\"btn btn-success\">Visualizza dipendenti</a>
                        <a href=\"ispettore/controllo.php\" class=\"btn btn-secondary\">Controllo</a>
                        <a href=\"ispettore/report.php\" class=\"btn btn-danger\">Report</a>
                    </div>

                    </li>";
                }

                
                echo "<li class=\"list-group-item\" style=\"font-size:30px; background-color:grey; color:grey\">.</li></ul>";
                ;
            } 

//menu capo divisione
            function home_cdiv($connection){
                $result= getPuntiVenditaResp($_SESSION['id'],1,$connection);
                echo"
                <ul class=\"list-group\" style=\"font-size:20px\">
                <li class=\"list-group-item\" style=\"font-size:30px; background-color:grey; color:white;\">
                <b>Lista punti vendita</b>
                </li>";
                foreach($result as $pv){
                    $id=$pv['id_punto_vendita'];
                    $residenza=$pv['residenza'];
                    echo "<li class=\"list-group-item\"><p>$residenza $id</p>
                    <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">
                        <a href=\"info_pv.php\" class=\"btn btn-primary\">Informazioni</a>
                        <a href=\"cdiv/simulazione.php\" class=\"btn btn-success\">Simula vendite</a>
                        <a href=\"cdiv/reportlist.php\" class=\"btn btn-warning\">Visualizza report</a>
                        <a href=\"cdiv/chiusura.php\" class=\"btn btn-danger\">Chiudi punto vendita</a>
                    </div>

                    </li>";
                }

                
                echo "<li class=\"list-group-item\" style=\"font-size:30px; background-color:grey; color:grey\">.</li></ul>";
                ;
            }  
        ?>

    </head>

    <body>
        <?php
            if(!isset($_SESSION['login']))
                echo "<h1>FORBIDDEN</h1>";
            else{
                if(isset($_SESSION['login'])&& $_SESSION['ruolo']=="gestore")
                    home_gestore();
                else if(isset($_SESSION['login'])&& $_SESSION['ruolo']== "addetto vendite")
                    home_adv($connection);
                else if(isset($_SESSION['login'])&& $_SESSION['ruolo']== "Ispettore")
                    home_ispettore($connection);
                else if(isset($_SESSION['login'])&& $_SESSION['ruolo']== "Capo Divisione")
                    home_cdiv($connection);
            }

        ?>


    </body>

</html>