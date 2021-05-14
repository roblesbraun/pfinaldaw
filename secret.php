<?php
    session_start();
    // echo '<p class="text-white">'.$_SESSION["id"].'</p>';
    if (isset($_SESSION["id"])) {
        $id = ($_SESSION["id"]);
        $conn = mysqli_connect("localhost","root","","pfinal");
        $query = "SELECT * FROM carrito WHERE id_usuario = '$id';";
        $result = mysqli_query($conn, $query);
        $numCart = mysqli_num_rows($result);
        $_SESSION["elim"] = 0;
        $_SESSION['update'] = 0;

        if(isset($_POST['submit'])){
            // $prod = $_POST['idprod'];
            // echo '<p class="text-white">Valor para el carrito '.$prod.' '.$id.' '.htmlspecialchars($_SERVER["PHP_SELF"]).'</p>';
            // $conn = mysqli_connect("localhost","root","","pfinal");
            // $addCart = "INSERT INTO carrito (id_usuario, id_prod) VALUES ($id, $prod);";
            // $result = mysqli_query($conn, $addCart);
            session_destroy();
            header("Location: secretlog.php");
        }
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
    <title>Secret Menu</title>
    <link rel="icon" href="img/lotus.svg">
</head>
<body class="bg-dark">
    <nav class="navbar navbar-expand-sm navbar-light bg-nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="secret.php"><img src="img/lotus.svg" width="40"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="about.php"><img src="img/about.svg" width="20"/> About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php"><img src="img/contact.svg" width="20"/> Contact</a>
                </li> -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (isset($_SESSION["id"])) {
                        echo '<form action="" method="post">';
                            echo '<button type="submit" name="submit" class="btn"><img src="img/logout.svg" width="20"></button>';
                        echo '</form>';
                        // echo '<a class="nav-link" href="cart.php"><img src="./img/logout.svg" width="20" alt=""></a></li>';
                    }
                    // else {
                    //     echo '<li><a class="nav-link" href="signup.php"><img src="./img/signup.svg" width="20" alt=""> Sign Up</a></li>';
                    //     echo '<li><a class="nav-link" href="login.php"><img src="./img/login.svg" width="20" alt=""> Log In</a></li>';
                    // }
                ?>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="display-2 fw-bold text-center text-light">Admin</h1>
        <div class="row">
            <div class="col d-flex justify-content-center p-4">
                <div class="card bg-dark border-dark text-light" style="width: 15rem;">
                    <div class="container-fluid text-center">
                        <img src="img/plus.svg" class="card-img-top" style="width: 12rem;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Agregar Productos</h5>
                        <p class="card-text">Añade nuevos productos a tu catálogo.</p>
                        <div class="container text-center">
                            <a href="newproduct.php" class="btn btn-light">Añadir</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-center p-4">
                <div class="card bg-dark border-dark text-light" style="width: 15rem;">
                    <div class="container-fluid text-center">
                        <img src="img/delete.svg" class="card-img-top" style="width: 12rem;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Eliminar producto</h5>
                        <p class="card-text">Quita algun producto que ya no se encuentre disponible.</p>
                        <div class="container text-center">
                            <a href="elimproduct.php" class="btn btn-light">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center p-4">
                <div class="card bg-dark border-dark text-light" style="width: 15rem;">
                    <div class="container-fluid text-center">
                        <img src="img/clicker.svg" class="card-img-top" style="width: 12rem;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Editar Productos</h5>
                        <p class="card-text">Modifica datos de los prodcutos ya existentes en el catálogo.</p>
                        <div class="container text-center">
                            <a href="edititem.php" class="btn btn-light">Modificar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-center p-4">
                <div class="card bg-dark border-dark text-light" style="width: 15rem;">
                    <div class="container-fluid text-center">
                        <img src="img/bino.svg" class="card-img-top" style="width: 12rem;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Historial de Compras</h5>
                        <p class="card-text">Revisa el historial de las compras de todos los usuarios.</p>
                        <div class="container text-center">
                            <a href="revhistory.php" class="btn btn-light">Revisar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>