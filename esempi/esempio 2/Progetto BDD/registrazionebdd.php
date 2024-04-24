<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Registrazione</title>
		<style type="text/css">
			body{
				background-color:orange;
				color:white;
			}
			#finestraregistrazione{
				display:flex;
				flex-direction:column;
				margin-left:auto;
				margin-right:auto;
				margin-top:10%;
				width:50%;
				height:100%;
				background-color:white;
				border-radius: 20px 20px 20px 20px;
			}
			#finestraregistrazione form{
				margin-left:auto;
				margin-right:auto;
				padding-bottom:5%;
			}
			#finestraregistrazione form p{
				color:green;
				font-family:Courier;
				font-size:20px;
				padding-right:2%;
				text-align:center;
			}
			#finestraregistrazione input{
				background-color:white;
				text-align:center;
			}
			#finestraregistrazione .bottone{
				margin-left:30%;
				background-color:orange;
				color:green;
				font-size: 15px;
				font-family:Arial;
				padding: 5px 5px;
				border: none;
				border-radius: 5px;
				opacity:85%;
			}
			#finestraregistrazione .bottone:hover{
				opacity:100%;
			}
			#finestraregistrazione a{
				margin-left:auto;
				margin-right:auto;
				border-radius:20px 20px 20px 20px;
				padding:5% 5% 2% 5%;
			}
			h3{
				text-align:center;
			}
			.logbutt{
				width:180px;
				height: 40px;
				text-align:center;
				align-items: center;
				margin-left:46%;			}

		</style>

		<script type="text/javascript">
			function formvalidator(){
				var nome =document.forms['regform']['nome'].value;
				var cognome =document.forms['regform']['cognome'].value;
				var email =document.forms['regform']['email'].value;
				var username =document.forms['regform']['username'].value;
				var password =document.forms['regform']['password'].value;
				if(nome=="" || cognome=="" || email=="" || username=="" || password=="" || nome==null || cognome==null || email==null || username==null || password==null ){
					alert("Inserire tutti i parametri richiesti");
					return false;
				}
				if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){//controllo espressioni regolari indirizzo email
					return true;
				}
				else{
					alert("indirizzo e-mail non valido");
					document.forms['regform']['email'].style.borderColor="red"; //il bordo diventa rosso
					return false;
				}
			}

			function stringreplace(stringa){
				var newstring=stringa.replace('<?php','');
				newstring= newstring.replace('echo','');
				newstring= newstring.replace('?>','');
				newstring=newstring.trim(); //togliamo spazi bianchi
				return newstring;
			}
			function redborder(n,nome,cognome,email,username){
				var name= stringreplace(nome);
				var surname= stringreplace(cognome);
				var usr= stringreplace(username);
				var nemail= stringreplace(email);
				if(n==1){ //username e email rossi
					document.getElementById('username').style.borderColor="red";
					document.getElementById('email').style.borderColor="red";
					document.getElementById('nome').value=name;
					document.getElementById('cognome').value=surname;
					document.getElementById('username').value=usr;
					document.getElementById('email').value=nemail;
				}
				if(n==2){ //email rosso
					document.getElementById('email').style.borderColor="red";
					document.getElementById('nome').value=name;
					document.getElementById('cognome').value=surname;
					document.getElementById('username').value=usr;
					document.getElementById('email').value=nemail;
				}
				if(n==3){ //username rosso
					document.getElementById('username').style.borderColor="red";
					document.getElementById('nome').value=name;
					document.getElementById('email').value=nemail;
					document.getElementById('cognome').value=surname;
					document.getElementById('username').value=usr;
				}
				return;
			}
		</script>
	</head>
	<body>
	<div id="finestraregistrazione">
		<a href="loginbdd.php"><img class="logo" src="logo1.png" width="300px" height="80px" alt="logo" /></a>
		<form name="regform" action="registrazionebdd.php" method="POST" onsubmit="return formvalidator()">
			<p>Nome<br /><input type="text" id="nome" name="nome" ></p>
			<p>Cognome<br /><input type="text" id="cognome" name="cognome" ></p>
			<p>E-Mail<br /><input type="text" id="email" name="email"></p>
			<p>Username<br /><input type="text" id="username" name="username" ></p>
			<p>Password<br /><input type="password" name="password"></p>
			<hr>
			<input class="bottone" type="submit" name="bottone" value="registrati">
		</form>

	</div>
		<?php
			if(isset($_POST['bottone'])){
			require_once("connection.php");
			//controlliamo nel dbs se username o l'indirizzo email sono già nel dbs
				$nome=$_POST['nome'];
				$cognome=$_POST['cognome'];
				$email=$_POST['email'];
				$username=$_POST['username'];
				$password=$_POST['password'];
				//definiamo le query di controllo
				$query1= "SELECT * FROM Cliente WHERE username='$username'";
				$query2= "SELECT * FROM Cliente WHERE email='$email'";
				$result1=mysqli_query($connection,$query1); //restituisce un oggetto sql
				$result2=mysqli_query($connection,$query2);
				//estraiamo info dagli oggetti restituiti
				$resusrn=mysqli_fetch_array($result1);
				$resemail=mysqli_fetch_array($result2);
				//definiamo le varie casistiche
				if(!$resusrn && !$resemail){ //#CASE 1: username ed email inseriti non  presenti nel dbs si procede con registrazione
					$query="INSERT INTO Cliente (nome,cognome,username,email,password_1,stato) VALUES (\"$nome\",\"$cognome\",\"$username\",\"$email\",\"$password\",\"0\")";
					if(mysqli_query($connection, $query)){
						echo "<script> alert('Registrazione completata')</script>";
            echo "<a class=\"logbutt\" href=\"loginbdd.php\" style=\"color:white; background-color:green; padding:5px; text-decoration:none; border-radius:5px; \">VAI A LOGIN</a>";
					  }
					else{
						echo "<script> alert(\"Errore inaspettato\")</script>";
					}
				}
				if($resusrn && $resemail){ //#CASE 1: username ed email presenti entrambi nel dbs
					echo "<script>alert(\"Username ed e-mail gia' presenti nel sistema\") </script>";
					echo "<script> redborder(1,\"<?php echo $nome ?>\",\"<?php echo $cognome ?>\",\"<?php echo $email ?>\",\"<?php echo $username ?>\",);</script>";
				}
				if($resemail && !$resusrn){ //#CASE 2: email già presente nel dbs
					echo "<script>alert(\"E-mail gia' presente nel sistema\") </script>";
					echo "<script> redborder(2,\"<?php echo $nome ?>\",\"<?php echo $cognome ?>\",\"<?php echo $email ?>\",\"<?php echo $username ?>\",);</script>";
				}
				if(!$resemail && $resusrn){ //#CASE 3: username già presente nel dbs
					echo "<script>alert(\"Username gia' presente nel sistema\")</script>";
					echo "<script> redborder(3,\"<?php echo $nome ?>\",\"<?php echo $cognome ?>\",\"<?php echo $email ?>\",\"<?php echo $username ?>\",);</script>";
				}
			}
		?>
	</body>



</html>
