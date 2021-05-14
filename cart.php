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
        $queryCart = "SELECT c.id_carrito, c.id_prod, nombre, imagen, precio FROM productos p, carrito c WHERE c.id_usuario = $id AND c.id_prod = p.id_prod;";
        $resultCart = mysqli_query($conn, $queryCart);

        if(isset($_POST['submit'])){
            $prod = $_POST['idprod'];
            echo '<p class="text-white">Valor para el carrito '.$prod.' '.$id.' '.htmlspecialchars($_SERVER["PHP_SELF"]).'</p>';
            $conn = mysqli_connect("localhost","root","","pfinal");
            $elimCart = "DELETE FROM carrito WHERE id_usuario = $id AND id_carrito = $prod;";
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
    <title>Cart</title>
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
        <h1 class="display-5 fw-bold text-white text-center">Carrito de Compras</h1><br>
        <?php
            $totalCart = 0;
            while($cart = mysqli_fetch_array($resultCart)){
                $totalCart = $totalCart + $cart['precio'];
                echo '<div class="container bg-dark text-white">';
                    echo '<div class="card-body">';
                        echo '<div class="row">';
                            echo '<div class="col text-center d-flex justify-content-center align-items-center">';
                                echo '<img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($cart['imagen']).'" class="img-thumbnail rounded img-fluid" width="200">';
                            echo '</div>';
                            echo '<div class="col">';
                                echo '<h5 class="card-title">'.$cart['nombre'].'</h5>';
                                echo '<span class="lead fw-bold">'.$cart['precio'].' <img src="img/bitcoin.svg" width="23"></span><br><br><br>';
                                echo '<form action="" method="post">';
                                        echo '<input type="hidden" name="idprod" value="'.$cart['id_carrito'].'">';
                                        echo '<button type="submit" name="submit" class="btn btn-light"><img src="img/trash.svg" width="23"> Eliminar</button>';
                                echo '</form>';
                                // echo '<a href="#" class="btn btn-light">Eliminar</a>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<hr class="text-white">';
            }
        ?>
        <div class="container bg-dark text-white">
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-center align-items-center">
                    <p class="text-white lead fw-bold fs-1">Total</p>
                </div>
                <div class="col d-flex justify-content-start align-items-center">
                    <p class="text-white lead fw-bold fs-3"><?php echo $totalCart; ?> <img src="img/bitcoin.svg" width="23"></p><br>
                </div>
            </div>
            <div class="row">
                <div class="col">

                </div>
                <div class="col d-flex justify-content-start align-items-center">
                    <a href="checkout.php" class="btn btn-light"><img src="img/checkout.svg" width="20"> Checkout</a>
                </div>
            </div>
        </div>
        </div>    
        <!-- <div class="container bg-dark text-white">
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-center align-items-center">
                    <img src="img/quadcastS.jpg" width="200" class="img-thumbnail rounded img-fluid">
                </div>
                <div class="col">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-light">Eliminar</a>
                </div>
            </div>
        </div>
        </div>     -->
    </div>
    <!-- Footer -->
    <!-- <footer>
        <div class="container-fluid d-flex fixed-bottom justify-content-center align-items-center footer" style="height: 118px;">
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
    </footer> -->
</body>
</html>