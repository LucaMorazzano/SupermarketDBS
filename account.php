<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Account</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <?php
            session_start();
            require_once("install/connection.php");
            require_once("install/getData.php");
            require_once("navbar.php");
        ?>

    </head>

    <body>
        <?php
        if(isset($_SESSION['login'])){
        ?>

        <section style="background-color: #eee;">
        <div class="container py-2">
            <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="homepage.php">Homepage</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Account</li>
                </ol>
                </nav>
            </div>
            </div>

            <div class="row">
            <div class="col-lg-4" style="margin-left:auto; margin-right:auto; font-size:20px;">
                <div class="card mb-4">
                <div class="card-body text-center" >
                    <img src="img/avatar.png" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3"><?php echo $_SESSION['nome']. " " .$_SESSION['cognome'] ?></h5>
                    <p class="text-muted mb-4"><b>id: <?php echo $_SESSION['id']?></b></p>
                    <p class="text-muted mb-4">Ruolo: <b><?php echo $_SESSION['ruolo'] ?></b></p>

                    <?php
                        if($_SESSION['ruolo']=="addetto vendite" || $_SESSION['ruolo']== "gestore"){
                    ?>
                    <p class="text-muted mb-1">Data assunzione: <?php echo $_SESSION['data_assunzione'] ?></p>
                    <p class="text-muted mb-1">Data scadenza: <?php echo $_SESSION['data_scadenza'] ?></p>
                    <p class="text-muted mb-4">Retribuzione: <?php echo $_SESSION['retribuzione'] ?>&euro;</p>
                    <p class="text-muted mb-1"><b>id punto vendita: <?php echo $_SESSION['id_punto_vendita'] ?></b></p>
                    <?php
                        }
                    ?>
                </div>
                </div>
        </section>

        <?php
        }
        else
            echo "<h1>FORBIDDEN</h1>";
        ?>
    </body>
</html>