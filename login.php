<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./lotus.css">
    <title>Log In</title>
    <link rel="icon" href="img/lotus.svg">
</head>
<?php
    $email = '';
    $passwd = '';
    $error = 0;
    $success = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // echo '<p class="text-white">Entre al primer if</p>';
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        if (empty($_POST["email"])) {
            $error = 1;
        }
        if (empty($_POST["passwd"])) {
            $error = 1;
        }
        if ($error == 0) {
            // Crear una conexión
            $conn = mysqli_connect("localhost","root","","pfinal");
            // Check connection
            // if ($conn) {
            //     echo '<p class="text-white">Conectaste chido</p>';
            // }
            if(isset($_POST['submit'])){
                $email = $_POST['email'];
                $passwd = $_POST['passwd'];
                if($email != '' and $passwd != '') {
                    $query = "SELECT * FROM usuarios WHERE email = '$email';";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($result);
                    if (($row['passwd']) == $passwd and ($row['email']) == $email) {
                        $success = 1;
                        $_SESSION["id"] = ($row['id_usuario']);
                        $_SESSION["login"] = 1;
                        header("Location: comprar.php");
                    }
                    else {
                        $error = 1;
                    }
                    // if (!mysqli_query($conn, $sql)) {
                    // die('Error: ' . mysqli_error($conn));
                    // }
                }
            }
        }
    }
?>
<body class="bg-dark">
<nav class="navbar navbar-expand-sm navbar-light bg-nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="comprar.php"><img src="img/lotus.svg" width="40"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="about.php"><img src="img/about.svg" width="20"/> About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php"><img src="img/contact.svg" width="20"/> Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (isset($_SESSION["id"])) {
                        echo '<a class="nav-link" href="profile.php"><img src="./img/profile.svg" width="20" alt=""> Perfil</a></li>';
                        echo '<a class="nav-link" href="cart.php"><img src="./img/cart.svg" width="20" alt=""> <span class="badge rounded-pill bg-info text-dark">'.$numCart.'</span></a></li>';
                    }
                    else {
                        echo '<li><a class="nav-link" href="signup.php"><img src="./img/signup.svg" width="20" alt=""> Sign Up</a></li>';
                        echo '<li><a class="nav-link" href="login.php"><img src="./img/login.svg" width="20" alt=""> Log In</a></li>';
                    }
                ?>
            </ul>
            </div>
        </div>
    </nav><br>
    <div class="container bg-dark">
        <h1 class="text-center text-white display-3">Iniciar sesión</h1><br><br>
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col">
                    <a href="secretlog.php"><img width="150" src="img/key.svg" alt=""></a><br><br>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center flex-column">
                <div class="col-md-5">
                    <?php
                        if($error == 1) {
                            echo '<div class="alert alert-danger text-center" role="alert">';
                            echo 'El email y/o contraseña son incorrectos.';
                            echo '</div>';
                        }
                        if($success == 1){
                            // echo '<div class="alert alert-success" role="alert">Te has registrado exitosamente.</div>';
                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                echo '<strong>Te has registrado existosamente!</strong>';
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            $email = $passwd = '';
                        }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <!-- Email -->
                        <label class="form-label text-white" for="email">Email</label>
                        <input class="form-control form-control-sm text-white bg-dark" type="email" name="email" value="<?php echo $email;?>"><br>
                        <!-- Password -->
                        <label class="form-label text-white" for="passwd">Contraseña</label>
                        <input class="form-control form-control-sm text-white bg-dark" type="password" name="passwd" value=""><br>
                        <!-- <input class="btn btn-light" type="submit" name="submit" value="Registrarme"> -->
                        <div class="container text-center">
                            <button type="submit" name="submit" class="btn btn-light"><img src="img/check.svg" width="15" alt=""> Iniciar sesion</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <!-- Footer -->
    <footer>
        <div class="container-fluid d-flex justify-content-center align-items-center footer" style="height: 118px;">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col d-flex align-items-center justify-content-center">
                        <a href="comprar.php"><img src="img/lotus.svg" width="80"></a>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center flex-column">
                        <a href="about.php" class="lead link-light text-decoration-none">About</a>
                        <a href="contact.php" class="lead link-light text-decoration-none">Contact</a>
                    </div>
                    <div class="col text-center">
                        <img src="img/twitter.svg" width="20"><span class="text-light"> Lotus</span><br>
                        <img src="img/instagram.svg" width="20"><span class="text-light"> Lotus</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>