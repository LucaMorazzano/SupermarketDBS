<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>Logout</title>
	</head>
	
	<body>
		<?php
		/*Questa pagina effettua la chiusura della sessione corrente e rimanda l'utente alla pagina di login
		in modo che possa effettuare il login con un altro utente senza mantenere la sessione*/
		session_start();
		unset($_SESSION);
		session_destroy();
		header('Location: loginbdd.php');
		?>
	</body>

</html>