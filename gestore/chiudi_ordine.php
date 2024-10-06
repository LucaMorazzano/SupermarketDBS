<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Chiudi ordine</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("navbar.php");
            require_once("../install/connection.php");
            require_once("../install/getData.php");
        ?>

    </head>

    <body>

        <?php
            if(isset($_POST['chiudi'])){
                $id_pv=$_SESSION['id_punto_vendita'];
                $id_ordine=$_SESSION['ordine'];
                //effettuiamo operazioni chiusura
                $query="SELECT n_prodotti FROM ordine WHERE id_ordine LIKE $id_ordine";
                $result=mysqli_query($connection,$query);
                if(!$result)
                    echo" $query...$connection->error<br />";
                $n_prodotti=mysqli_fetch_array($result)['n_prodotti'];
                $magazzino=mysqli_fetch_array(getMagazzino($id_pv,$connection));
                $sd=$magazzino['spazio_disponibile'];
                $id_magazzino=$magazzino['id_magazzino'];
                if($n_prodotti>$sd){
                    $_SESSION['error']=$id_ordine;
                }
                else{
                    $id_deposito=rand(1,5);
                    $query="SELECT id_camionista FROM camionista WHERE stato LIKE 'disponibile'";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    $id_camionista=mysqli_fetch_array($result)['id_camionista'];
                    $query="UPDATE ordine SET stato= 'chiuso' , id_deposito=$id_deposito , id_camionista=$id_camionista  WHERE id_ordine LIKE $id_ordine";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    //aggiungiamo ora i nuovi prodotti al magazzino
                    $query="SELECT * FROM comprendere WHERE id_ordine LIKE $id_ordine";
                    $result=mysqli_query($connection,$query);
                    if(!$result)
                        echo" $query...$connection->error<br />";
                    foreach($result as $comp){
                        $id_prodotto=$comp['id_prodotto'];
                        $quantita=$comp['quantita'];
                        $query="SELECT id_prodotto FROM in_magazzino WHERE id_magazzino LIKE $id_magazzino";
                        $result=mysqli_query($connection,$query);
                        if(!$result)
                            echo" $query...$connection->error<br />";
                        
                        if(mysqli_num_rows($result)>0)
                            $query="UPDATE in_magazzino SET quantita= quantita + $quantita WHERE id_prodotto LIKE $id_prodotto AND id_magazzino LIKE $id_magazzino";
                        else
                            $query="INSERT INTO in_magazzino (quantita, id_prodotto, id_magazzino) VALUES ($quantita, $id_prodotto, $id_magazzino)";
                    
                        $result=mysqli_query($connection,$query);
                        if(!$result)
                            echo" $query...$connection->error<br />";
                    }
                }

                //unset session
                unset($_SESSION['ordine']);
                unset($_SESSION['sd']);
                header('Location: lista_ordini.php');
            }


            if(isset($_POST['archivia'])){
                unset($_SESSION['ordine']);
                unset($_SESSION['sd']);
                header('Location: lista_ordini.php');
            }
        ?>
    </body>
</html>