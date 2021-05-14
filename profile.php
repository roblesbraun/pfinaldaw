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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header("Location: comprar.php");
            session_destroy();
        }

        // if(isset($_POST['submit'])){
        //     $prod = $_POST['idprod'];
        //     echo '<p class="text-white">Valor para el carrito '.$prod.' '.$id.' '.htmlspecialchars($_SERVER["PHP_SELF"]).'</p>';
        //     $conn = mysqli_connect("localhost","root","","pfinal");
        //     $addCart = "INSERT INTO carrito (id_usuario, id_prod) VALUES ($id, $prod);";
        //     $result = mysqli_query($conn, $addCart);
        //     header ("Location: comprar.php");
        // }
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
    <title>Profile</title>
    <link rel="icon" href="img/lotus.svg">
</head>
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
    <div class="container">
        <h1 class="display-2 text-light text-center">Perfil</h1>
    </div>
    <br><br>
    <div class="container text-light">
        <div class="card-body">
            <div class="row">
                <div class="col text-center">
                    <img src="img/profile.svg" width="120">
                </div>
                <div class="col">
                    <h5 class="card-title">Ver Perfil</h5>
                    <p class="card-text">Edita los datos de tu perfil.</p>
                    <a href="editprofile.php" class="btn btn-secondary"><img src="img/edit.svg" width="20"> Editar Perfil</a>
                </div>
            </div>
        </div>
        <hr class="text-light">
    </div>
    <div class="container text-light">
        <div class="card-body">
            <div class="row">
                <div class="col text-center">
                    <img src="img/calendar.svg" width="120">
                </div>
                <div class="col">
                    <h5 class="card-title">Historial de compras</h5>
                    <p class="card-text">Consulta las comprar que has realizado anteriormente.</p>
                    <a href="history.php" class="btn btn-secondary"><img src="img/historial.svg" width="20"> Ver Historial</a>
                </div>
            </div>
        </div>
        <hr class="text-light">
    </div>
    <div class="container text-light">
        <div class="card-body">
            <div class="row">
                <div class="col text-center">
                    <img src="img/logout.svg" width="120">
                </div>
                <div class="col">
                    <h5 class="card-title">Cerrar Sesion</h5>
                    <p class="card-text">Termina la sesion.</p>
                    <form action="" method="post">
                        <button class="btn btn-secondary" type="submit" name="logout"><img src="img/logout.svg" width="20"> Cerrar Sesion</button>
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