<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Login</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <script>
            function formvalidator(){
                var username= document.getElementById('typeEmailX').value;
                var password= document.getElementById('typePasswordX').value;
                if (username == "" || password == "") {
                    alert("Username e password non possono essere vuoti!");
                    return false;
                }
                if (isNaN(parseInt(password))) {
                    alert("Errore inserimento password");
                    return false;
                }
                return true;
            }
        </script>

        <?php
            session_start();
            require_once("install/connection.php");
            require_once("install/getData.php");
        ?>

    </head>

    <body>

        <?php
//LOGIN
            if(isset($_POST['login'])){
                $username=$_POST['username'];
                $password=$_POST['password'];

                if($loginResponsabile= LoginResponsabile($password, $username, $connection))
                {
                    $responsabile=sql_to_array($loginResponsabile);
                    echo "RESPONSABILE";
                }
                
                else if($loginDipendente = LoginDipendente($password, $username, $connection)){
                    $dipendente=sql_to_array($loginDipendente);
                    $nome=$dipendente['nome'];
                    echo "DIPENDENTE $nome";
                }
                else if(!$loginResponsabile && !$loginDipendente)
                    echo "<script>alert(\"Dati errati\")</script>";
            }

        ?>

        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <form method="POST" action="login.php" onsubmit="return formvalidator()">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Inserire username e password !</p>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="text" id="typeEmailX" name="username" class="form-control form-control-lg" style="text-align:center"/>
                                    <label class="form-label" for="typeEmailX">Username</label>
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" style="text-align:center"/>
                                    <label class="form-label" for="typePasswordX">Password</label>
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" name= "login" type="submit">Login</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

    </body>

</html>