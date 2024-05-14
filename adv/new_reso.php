<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Nuovo reso</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("../install/connection.php");
            require_once("../install/getData.php");
        ?>
      <style type="text/css">
            .list-group-item{
                display:flex;
                justify-content:space-between;
            }
            .bottone{
                color: #fff;
                background-color: #28a745;
                border-color: #28a745;
            }
        </style>

        <script src="../install/funzioniJS.js" > </script>

    </head>

    <body>
        <?php
            if(isset($_POST['aggiungi'])){
                
            }

        ?>
            
        <?php
        //stampiamo tutti i prodotti di un determinato p.v che possono essere resi
                require_once("navbar.php");
                $prodotti=getProdotti_PV($connection, $_SESSION['id_punto_vendita']);
                echo "<form action=\"new_reso.php\" method=\"POST\" style=\"margin-top: 2%; display:flex; justify-content: space-between\">";
                echo "<div><ul class=\"list-group\" style=\"font-size:20px\">";
                foreach ($prodotti as $prodotto){
                    echo "<li class=\"list-group-item\">";
                    $prodotto=mysqli_fetch_array($prodotto);
                    $id_prodotto=$prodotto['id_prodotto'];
                    $id_magazzino= mysqli_fetch_array(getMagazzino($_SESSION['id_punto_vendita'],$connection))['id_magazzino'];
                    $nome=$prodotto['nome'];
                    $result= getQuantita($id_prodotto, $id_magazzino, $connection);
                    if($result){
                        $result=mysqli_fetch_array($result);
                        $quantita=$result['quantita'];
                        echo "
                        <p style=\"background-color: yellow\"><b>Nome:</b> $nome <b>Quantità in magazzino:</b> $quantita </p> ";
                        echo "Inserire quantita: <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\"><input name=\"quantita\" type=\"number\" min=\"1\" max=\"$quantita\">
                        <input type=\"submit\" name=\"$id_prodotto\" class=\"bottone\" value=\"Aggiungi al reso\" onclick=\"responsivebutton(this,'aggiungi')\" / >
                        </div>";
                    }
                    echo "</li>";
                }
                echo "</ul></div>";

        ?>


        </div>
    </body>
</html>