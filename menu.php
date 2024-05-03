<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Menu</title>

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
        </style>
        <?php
//menu gestore
            function menu_gestore(){
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
        ?>

    </head>

    <body>
        <?php
            if(!isset($_SESSION['login']))
                echo "<h1>FORBIDDEN</h1>";

            else{
                if(isset($_SESSION['login'])&& $_SESSION['ruolo']=="gestore")
                    menu_gestore();
            }

        ?>


    </body>

</html>