<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
     session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Home</title>
    <style>
        @import url("stile1.css");
        .orario{
            padding-left: 7%;
            padding-right: 7%;
        }
        .reins{
            margin-top:10px;
            padding:5%;
            background-color:orange;
            color:white;
            font-size:17px;
            border:solid;
            border-color: white;
            border-radius:15px;
            display:flex;
            flex-direction:column;
        }
        .reins h1{
            font-size: 30px;
            color:green;
                 }
        .selezione{
            border:solid;
            border-color:green;
            border-radius:5px;
            color:white;
            background-color:green  ;
        }

    </style>
</head>
<body>
<?php
require_once("menu.php");
require_once("connection.php");
    echo "<form class=\"reins\" name=\"userform\" action=\"adminbdd.php\" method=\"post\" onsubmit=\"return formvalidator()\">
        <h1>COMPILARE LA FORM PER INSERIRE IL NUOVO FILM </h1>
        <p>NOME: <input type=\"text\" name=\"nome\"></p>
        <p style=\"display:flex; justify-content:center\"><input type=\"submit\" class=\"selezione\" name=\"add\" value=\"INSERISCI NEL CATALOGO\"></p></form>
        </div>";
    ?>

		<?php
			if(isset($_POST['add'])){
				$nome=$_POST['nome'];
                $sql=array();
                $sql="INSERT INTO Film (titolo) VALUES (\"$nome\")";
                if(mysqli_query($connection,$sql)){
                    echo "<script>alert(\"inserimento ok\")</script>";
                }
                else {
                    echo "<script>alert(\"errore\")</script>";
                }
			}
		?>
</body>