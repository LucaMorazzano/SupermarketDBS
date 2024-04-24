<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<style type="text/css">
		body{
			background-color:orange;
		}
		#finestralogin{
			display:flex;
			flex-direction:column;
			margin-left:auto;
			margin-right:auto;
			margin-top:10%;
			background-color:white;
			border-radius: 20px 20px 20px 20px;
			border:solid green;
			width:50%;
			height:100%;
		}
		#finestralogin a{
			margin-left:auto;
			margin-right:auto;
			border-bottom:solid green 5px;
			border-radius:20px 20px 20px 20px;
			padding:5% 5% 2% 5%;
		}
		#finestralogin form{
			margin-left:auto;
			margin-right:auto;
			padding-bottom:2%;
		}
		#finestralogin form p{
			color:green;
			font-family:Courier;
			font-size:20px;
			padding-right:2%;
			text-align:center;
		}
		#finestralogin input{
			background-color:white;
			text-align:center;
		}
		#finestralogin .bottone{
			display:inline;
			background-color: orange;
			color: green;
			font-size: 15px;
			font-family:Arial;
			padding: 5px 5px;
			border: none;
			border-radius: 5px;
			opacity:85%;
		}
		#finestralogin .bottone:hover{
			opacity:100%;
		}
		#finestralogin .bottone2{
			display:inline;
			background-color: #009900;
			color: white;
			font-size: 15px;
			font-family:Arial;
			padding: 5px 5px;
			border: none;
			border-radius: 5px;
			opacity:95%;
		}
		#finestralogin .bottone2:hover{
			opacity:100%;
		}
		#finestralogin .adminref{
			color:white;
			text-decoration:none;
			margin-bottom:25px;
			padding:5px;
			border:none;
			background-color:#00008B;
		}
		
		</style>
		<title>Login Special</title>
			<script type="text/javascript">
			function formvalidator(){
				var usr = document.forms['userform']['username'].value; //assegnamo ad usr il valore di username
				var pwd= document.forms['userform']['password'].value;
				if(usr == null || pwd == null || usr == "" || pwd == ""){
					alert ("Dati mancanti");
					return false;
				}
				return true;
			}
			function stringreplace(stringa){
				var newstring=stringa.replace('<?php','');
				newstring= newstring.replace('echo','');
				newstring= newstring.replace('?>','');
				newstring=newstring.trim(); //togliamo spazi bianchi
				return newstring;
			}
			function reusername(username){
				var newusername= stringreplace(username);
				document.getElementById('username').value=newusername;
			}
		</script>
	</head>
	
	<body>
			<div id="finestralogin">
		<a href="homepage.php"><img class="logo" src="logo1.png" width="300px" height="80px" alt="logo" /></a>
			<form name="userform" action="loginspecial.php" method="POST" onsubmit="return formvalidator()">
				<p>Username<input id="username" type="text" name="username"></p>
				<p>Password<input type="password" name="password"></p>
				<p><input class="bottone" type="submit" name="adlogin" value="Accedi come admin"></p>
			</form>
		</div>
	<?php 
	
		require_once("connection.php"); //connessione al dbs per controllo esistenza utente
		if(isset($_POST['adlogin'])){
				$username=$_POST['username'];
				$password=$_POST['password'];
				//Effettuiamo controllo esistenza utente nel dbs (caso utente registrato)
				$sql1="SELECT * FROM Cliente WHERE username='$username' AND password_1='$password' AND stato='1'";
				$sql2="SELECT* FROM Cliente WHERE username='$username' ";
				if($res=mysqli_query($connection,$sql2)){
					$arraydbs= mysqli_fetch_array($res);
					if($arraydbs)
						$queryusername=$arraydbs['username'];
				}
				if($result=mysqli_query($connection,$sql1)){
					$manInfo= mysqli_fetch_array($result);
				} 
					if($manInfo){ //salviamo le informazioni nella sessione correntes
						$_SESSION['username']=$username;
						$_SESSION['password']=$password;
						$_SESSION['adlogin']=true; //aggiorniamo stato login
						//a questo punto inizializziamo una variabile di sessione dedicata allo sconto sui prodotti
						header('Location: specialhome.php');
					}
					else if(!$manInfo && (!$arraydbs || $username!=$queryusername)){
						echo"<script> alert(\"Dati errati\") </script>";
					}
					else if(!$manInfo && $arraydbs && $username == $queryusername){
						echo"<script> alert(\"Password errata\"); 
								reusername('<?php echo $username ?> ');</script>";
					}
				$connection->close();
			}
	?>
	</body>
</html>