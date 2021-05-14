<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./lotus.css">
    <link rel="icon" href="img/lotus.svg">
</head>
<!-- Definimos variables para formulario -->
<?php
    //Variables de todo bien y error
    $error = 0;
    $success = 0;
    $regex = 0;
    $nombre = $fnac = $direccion = $numtar = $email = $passwd = '';
    $nombreErr = $fnacErr = $direccionErr = $numtarErr = $emailErr = $passwdErr = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $fnac = $_POST['fnac'];
        $direccion = $_POST['direccion'];
        $numtar = $_POST['numtar'];
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $numberdigits = strlen($numtar);
        // echo '<p class="text-white">Esto es el num digitos'.$numberdigits.'</p>';
        if (empty($_POST["nombre"])) {
            $error = 1;
        } 
        else {
            if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
                $nombreErr = "Solo se permiten letras y espacios en blanco.";
                $regex = 1;
            }
        }
        if (empty($_POST["fnac"])) {
            $error = 1;
        }
        if (empty($_POST["direccion"])) {
            $error = 1;
        }
        if (empty($_POST["numtar"])) {
            $error = 1;
        } 
        else {
            if ($numberdigits != 16) {
                $numtarErr = "Numero de tarjeta invalido.";
                $regex = 1;
            }
        }
        if (empty($_POST["email"])) {
            $error = 1;
        } 
        else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Direccion de correo invalida.";
                $regex = 1;
            }
        }
        if (empty($_POST["passwd"])) {
            $error = 1;
        }
        // echo '<p class="text-white">Nombre error'.$nombreErr.'</p>';
        // echo '<p class="text-white">Fnac error'.$fnacErr.'</p>';
        // echo '<p class="text-white">Dir error'.$direccionErr.'</p>';
        // echo '<p class="text-white">Numtar error'.$numtarErr.'</p>';
        // echo '<p class="text-white">Email error'.$emailErr.'</p>';
        // echo '<p class="text-white">Passwd error'.$passwdErr.'</p>';
        if(($nombre and $fnac and $direccion and $numtar and $email and $passwd != '') and $regex ==0){
            $error = 0;
        }
        else {
            // echo '<div class="alert alert-danger" role="alert">';
            // echo 'Favor de llenar todos los campos.';
            // echo '</div>';
            $error = 1;
        }
        if ($error == 0) {
            // Crear una conexión
            $conn = mysqli_connect("localhost","root","","pfinal");
            session_start();
            // Check connection
            // if ($conn) {
            //     echo '<p class="text-white">Conectaste chido</p>';
            // }
            
            if(isset($_POST['submit'])){
                $nombre = $_POST['nombre'];
                $fnac = $_POST['fnac'];
                $direccion = $_POST['direccion'];
                $numtar = $_POST['numtar'];
                $email = $_POST['email'];
                $passwd = $_POST['passwd'];
                if($nombre != '' and $fnac != '' and $direccion != '' and $numtar != '' and $email != '' and $passwd != ''){
                    $sql = "INSERT INTO usuarios (nombre, email, passwd, fnac, numtar, direccion)
                    VALUES ('$nombre', '$email', '$passwd', '$fnac', '$numtar', '$direccion');";
    
                    if (!mysqli_query($conn, $sql)) {
                    die('Error: ' . mysqli_error($conn));
                    }
                    // echo '<div class="alert alert-success" role="alert">Te has registrado exitosamente.</div>';
                    $success = 1;
                    mysqli_close($conn);
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
        <h1 class="text-center text-white display-3">Regístrate!</h1>
        <p class="lead text-white text-center">Crea una cuenta en Lotus y empieza a comprar cuanto antes.</p><br><br>
        <div class="row">
            <div class="col-lg d-flex justify-content-center align-items-center flex-column">
                <img src="img/lotus.svg" style="width: 23rem;" alt="">
            </div>
            <div class="col-lg d-flex align-items-center flex-column">
                <?php
                    if($error == 1) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Favor de llenar todos los campos.';
                        echo '</div>';
                    }
                    if($success == 1){
                        // echo '<div class="alert alert-success" role="alert">Te has registrado exitosamente.</div>';
                        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                            echo '<strong>Te has registrado existosamente!</strong>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        $nombre = $fnac = $direccion = $numtar = $email = $passwd = '';
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!-- Nombre -->
                    <label class="form-label text-white" for="nombre">Nombre</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $nombreErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-dark box" type="text" name="nombre" value="<?php echo $nombre;?>"><br>
                    <!-- Fecha de nacimiento -->
                    <label class="form-label text-white" for="fnac">Fecha de nacimiento</label>
                    <input class="form-control form-control-sm text-white bg-dark box" type="date" name="fnac" value="<?php echo $fnac;?>"><br>
                    <!-- Direccion -->
                    <label class="form-label text-white" for="direccion">Direccion</label>
                    <input class="form-control form-control-sm text-white bg-dark box" type="text" name="direccion" value="<?php echo $direccion;?>"><br>
                    <!-- Tarjeta MC -->
                    <label class="form-label text-white" for="numero tarjeta">Numero de tarjeta</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $numtarErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-dark box" type="number" name="numtar" value="<?php echo $numtar;?>"><br>
                    <!-- Email -->
                    <label class="form-label text-white" for="email">Email</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $emailErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-dark box" type="text" name="email" value="<?php echo $email;?>"><br>
                    <!-- Password -->
                    <label class="form-label text-white" for="passwd">Contraseña</label>
                    <input class="form-control form-control-sm text-white bg-dark box" type="password" name="passwd" value=""><br>
                    <div class="container text-center">
                        <button type="submit" name="submit" class="btn btn-light"><img src="img/plus.svg" width="15" alt=""> Registrarme</button><br><br>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <br>
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