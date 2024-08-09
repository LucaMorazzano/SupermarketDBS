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

        <script>
            function responsivebutton(button, name){
                var nome= button.name;
                button.value=nome;
                button.style.opacity="0";
                button.style.backgroundColor="white";
                button.style.color="white";
                button.style.borderColor="white";
                button.name=name;
                return;
            }   
         </script>

    </head>

    <body>
        <?php
            if(isset($_POST['selection'])){ //modifica
                $_SESSION['id_reso']= $_POST['selection'];
            }
            ?>

        <?php
            if(isset($_POST['aggiungi'])){
                //aggiungiamo al reso il prodotto
                $id_pv=$_SESSION['id_punto_vendita'];
                $prodotti=getProdotti_PV($connection, $_SESSION['id_punto_vendita']);
                if(!$prodotti)
                    echo "sql error";
                else {
                    foreach($prodotti as $prodotto){
                        $prodotto=mysqli_fetch_array($prodotto);
                        $id_prodotto=$prodotto['id_prodotto'];
                        //print "<pre>" ; print_r($_POST) ; print "</pre>";
                        if($_POST[$id_prodotto]>0){
                            $quantita=$_POST[$id_prodotto];
                            $data = date('Y-m-d');
                            $id_adv=$_SESSION['id'];
                            
                            //creiamo nuovo reso
                            if(!isset($_SESSION['id_reso'])){
                                $query="INSERT INTO reso(n_prodotti, data, stato, id_deposito, id_addetto_vendita) VALUES (0, \"$data\", \"aperto\", 1, $id_adv) ";
                                if(!mysqli_query($connection,$query))
                                    echo "<span style=\"color:red\">$query <b> $connection->error </b></span>"; 
                                //otteniamo ora l'id
                                $query= "SELECT id_reso FROM reso";
                                $result=mysqli_query($connection,$query);
                                foreach($result as $res)
                                    $id_reso= $res['id_reso'];
                                $_SESSION['id_reso']=$id_reso;
                            }
                            else 
                                $id_reso=$_SESSION['id_reso'];
                            $query="SELECT * FROM in_reso WHERE id_reso LIKE $id_reso AND id_prodotto LIKE $id_prodotto";
                            $result=mysqli_query($connection,$query);
                            if($result && mysqli_num_rows($result)>0)
                                $query="UPDATE in_reso SET quantita=quantita + $quantita WHERE id_reso LIKE $id_reso AND id_prodotto LIKE $id_prodotto
                                    ";
                               
                            else
                                $query="INSERT INTO in_reso(quantita, id_reso, id_prodotto) VALUES ($quantita, $id_reso, $id_prodotto)";

                            if(!mysqli_query($connection,$query))
                            echo "<span style=\"color:red\">$query <b> $connection->error </b></span>";
                            
                        }
                    }
                }
            }
        ?>
            
        <?php
        //stampiamo tutti i prodotti di un determinato p.v che possono essere resi
                require_once("navbar.php");
                echo "<div style=\"display:flex;align-items:center; justify-content: space-between\">";
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
                        if($quantita>=0){
                            echo "
                            <p style=\"background-color: yellow\"><b>Nome:</b> $nome <b>Quantità in magazzino:</b> $quantita </p> ";
                            echo "Inserire quantita: <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\"><input name=\"$id_prodotto\" value=\"0\" type=\"number\" min=\"0\" max=\"$quantita\">
                            </div>";
                        }

                    }
                    echo "</li>";
                }
                echo "</ul><input type=\"submit\" name=\"aggiungi\" class=\"bottone\" value=\"Aggiungi al reso\" / >
                </div></form>";
                
                //stampiamo tutti i prodotti nel reso
                echo "<div style=\"margin-right:30%\">
                <h4>Prodotti nel reso</h1><hr>";
                if(isset($_SESSION['id_reso'])){
                    $id_reso=$_SESSION['id_reso'];
                    $query="SELECT * FROM in_reso WHERE id_reso LIKE $id_reso";
                    $result=mysqli_query($connection, $query);
                    if($result){
                        echo "<form action=\"new_reso.php\" method=\"POST\"><table border=\"1\">";
                        foreach($result as $prodotto){
                            $quantita= $prodotto['quantita'];
                            $id_prodotto= $prodotto['id_prodotto'];
                            $query="SELECT nome FROM prodotto WHERE id_prodotto LIKE $id_prodotto";
                            $result= mysqli_query($connection, $query);
                            $result=mysqli_fetch_array($result);
                            $nome_prodotto=$result['nome'];
                            $Super_id= $prodotto['id_in_reso']; //utile per ottimizzare ricerca

                            echo "<tr>
                                    <td> $nome_prodotto</td>
                                    <td> $quantita</td> 
                                    <td> <input type=\"radio\" name=\"selection\" value=\"$id_prodotto\"></input></tr>";
                        }
                        echo "</table></form>";
                    }
                        
                }
                else{
                    echo "<p>Questo reso non contiene prodotti attualmente</p>";
                }

                echo"</div>";

                echo"</div></div>";

        ?>


        </div>
    </body>
</html>