<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        
        <title>Navbar</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <style type="text/css">
        .navbar-nav li{
                margin-left:30px;
            }
        </style>
    </head>

    <body>
        <?php
            if(isset($_SESSION['login'])){
        ?>
        <nav class="navbar navbar-expand-lg bg-light" style="font-size:30px;">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav" >
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="account.php">Account</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>

        <?php
            }
        ?>


    </body>

</html>