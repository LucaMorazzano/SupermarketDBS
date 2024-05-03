<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>
			logout
		</title>
	</head>
	<body>
        <?php
            session_start();
            unset($_SESSION);
            session_destroy($_SESSION);
            header('Location: login.php');
        ?>
    </body>
</html>