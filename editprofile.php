<?php
    session_start();
    // echo '<p class="text-white">Valor sesions'.session_status().'</p>';
    // echo '<p class="text-white">Valor sesions'.$_SESSION["id"].'</p>';
    if (isset($_SESSION["id"])) {
        $id = ($_SESSION["id"]);
        $conn = mysqli_connect("localhost","root","","pfinal");
        $query = "SELECT * FROM carrito WHERE id_usuario = '$id';";
        $result = mysqli_query($conn, $query);
        $numCart = mysqli_num_rows($result);
        //Query obtener datos del usuario
        $queryUser = "SELECT * FROM usuarios WHERE id_usuario = '$id';";
        $resUser = mysqli_query($conn, $queryUser);
        $rowUser = mysqli_fetch_array($resUser);
    }
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
    <title>Edit Profile</title>
    <link rel="icon" href="img/lotus.svg">
    <!-- JS para los popup -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</head>
<!-- Validacion del formulario -->
<?php
    //Variables de todo bien y error
    $error = 0;
    $success = 0;
    $regex = 0;
    $nombre = $rowUser['nombre'];
    $fnac = $rowUser['fnac'];
    $direccion = $rowUser['direccion'];
    $numtar = $rowUser['numtar'];
    $email = $rowUser['email'];
    $passwd = $rowUser['passwd'];;
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
                    $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', passwd = '$passwd', fnac = '$fnac', numtar = '$numtar', direccion = '$direccion' WHERE id_usuario = $id;";
    
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
    </nav><br><br>
    <div class="container d-flex justify-content-center align-items-center flex-column">
        <h1 class="text-light">Edit Profile</h1><br>
        <div class="card bg-dark text-light d-flex justify-content-center" style="max-width: 25rem;">
            <img src="img/g915.jpg" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Tus datos.</h5>
                <p class="card-text">Edita los campos necesarios y guarda tus cambios.</p>
                <?php
                    if($error == 1) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Favor de llenar todos los campos.';
                        echo '</div>';
                    }
                    if($success == 1){
                        // echo '<div class="alert alert-success" role="alert">Te has registrado exitosamente.</div>';
                        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                            echo '<strong>Tus cambios se han guardado.</strong>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        // $nombre = $fnac = $direccion = $numtar = $email = $passwd = '';
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!-- Nombre -->
                    <label class="form-label text-white" for="nombre">Nombre</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $nombreErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-secondary" type="text" name="nombre" value="<?php echo $nombre;?>"><br>
                    <!-- Fecha de nacimiento -->
                    <label class="form-label text-white" for="fnac">Fecha de nacimiento</label>
                    <input class="form-control form-control-sm text-white bg-secondary" type="date" name="fnac" value="<?php echo $fnac;?>"><br>
                    <!-- Direccion -->
                    <label class="form-label text-white" for="direccion">Direccion</label>
                    <input class="form-control form-control-sm text-white bg-secondary" type="text" name="direccion" value="<?php echo $direccion;?>"><br>
                    <!-- Tarjeta MC -->
                    <label class="form-label text-white" for="numero tarjeta">Numero de tarjeta</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $numtarErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-secondary" type="number" name="numtar" value="<?php echo $numtar;?>"><br>
                    <!-- Email -->
                    <label class="form-label text-white" for="email">Email</label>
                    <span class="badge rounded-pill bg-info text-dark"><?php echo $emailErr;?></span><br>
                    <input class="form-control form-control-sm text-white bg-secondary" type="text" name="email" value="<?php echo $email;?>"><br>
                    <!-- Password -->
                    <label class="form-label text-white" for="passwd">Contraseña</label>
                    <input class="form-control form-control-sm text-white bg-secondary" type="password" name="passwd" value="<?php echo $passwd;?>"><br>
                    <!-- <input class="btn btn-secondary" type="submit" name="submit" onclick="Toasty( )" value="Guardar"><br> -->
                    <div class="container d-flex justify-content-evenly"">
                        <a href="profile.php" class="btn btn-light"><img src="img/back.svg" width="15"> Volver</a>
                        <button type="submit" name="submit" class="btn btn-light"><img src="img/save.svg" width="15"> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br><br>
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