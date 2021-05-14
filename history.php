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
        $queryHist = "SELECT c.id_prod, nombre, imagen, precio FROM productos p, compras c WHERE c.id_usuario = $id AND c.id_prod = p.id_prod ORDER BY c.id_compra DESC;";
        $resultHist = mysqli_query($conn, $queryHist);
        // $queryHist = "SELECT * FROM compras WHERE id_usuario = '$id';";
        // $resHist = mysqli_query($conn, $queryHist);

        if(isset($_POST['submit'])){
            $prod = $_POST['idprod'];
            echo '<p class="text-white">Valor para el carrito '.$prod.' '.$id.' '.htmlspecialchars($_SERVER["PHP_SELF"]).'</p>';
            $conn = mysqli_connect("localhost","root","","pfinal");
            $elimCart = "DELETE FROM carrito WHERE id_usuario = $id AND id_prod = $prod;";
            $result = mysqli_query($conn, $elimCart);
            header ("Location: cart.php");
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
    <title>Historial de Compras</title>
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
        <h1 class="display-2 fwbold text-white text-center">Historial de compras</h1><br>
        <?php
            if (isset($_SESSION["compra"])) {
                if ($_SESSION["compra"] == 1) {
                    echo '<div class="alert alert-info alert-dismissible fade show text-center" role="alert">';
                        echo '<strong>Tu compra se ha realizado con exito.</strong>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    $_SESSION["compra"] = 0;
                }
            }
        ?>
        <div class="card bg-dark text-white">
            <h5 class="card-header bg-secondary text-dark text-center">
                <div class="container d-flex justify-content-evenly"">
                    <a href="profile.php" class="btn btn-light"><img src="img/back.svg" width="15"> Volver</a>
                </div>
            </h5>
            <div class="card-body">
                <?php
                    while($historial = mysqli_fetch_array($resultHist)){
                        echo '<div class="container bg-dark text-white">';
                            echo '<div class="card-body">';
                                echo '<div class="row">';
                                    echo '<div class="col-md-4 text-center d-flex justify-content-center align-items-center">';
                                        echo '<img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($historial['imagen']).'" class="img-thumbnail rounded img-fluid" width="150">';
                                    echo '</div>';
                                    echo '<div class="col-md-8 text-center">';
                                        echo '<br>';
                                        echo '<h5 class="card-title">'.$historial['nombre'].'</h5>';
                                        echo '<span class="lead fw-bold">'.$historial['precio'].' <img src="img/bitcoin.svg" width="23"></span>';
                                        // echo '<form action="" method="post">';
                                        //         echo '<input type="hidden" name="idprod" value="'.$cart['id_prod'].'">';
                                        //         echo '<button type="submit" name="submit" class="btn btn-light"><img src="img/trash.svg" width="23"> Eliminar</button>';
                                        // echo '</form>';
                                        // echo '<a href="#" class="btn btn-light">Eliminar</a>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<hr class="text-info">';
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>