<?php
    session_start();
    // echo '<p class="text-white">Valor sesions'.session_status().'</p>';
    // echo '<p class="text-white">Valor sesions'.$_SESSION["id"].'</p>';
    if (isset($_SESSION["id"])) {
        $id = ($_SESSION["id"]);
        $conn = mysqli_connect("localhost","root","","pfinal");
        $query = "SELECT * FROM carrito WHERE id_usuario = $id;";
        $result = mysqli_query($conn, $query);
        $numCart = mysqli_num_rows($result);
        $queryCart = "SELECT c.id_prod, nombre, imagen, precio FROM productos p, carrito c WHERE c.id_usuario = $id AND c.id_prod = p.id_prod;";
        $resultCart = mysqli_query($conn, $queryCart);
        $queryData = "SELECT nombre, direccion FROM usuarios WHERE id_usuario = $id;";
        $resultData = mysqli_query($conn, $queryData);
        $data = mysqli_fetch_array($resultData);
        $queryCard = "SELECT numtar, RIGHT(numtar, 4) AS card FROM usuarios WHERE id_usuario = $id;";
        $resultCard = mysqli_query($conn, $queryCard);
        $card = mysqli_fetch_array($resultCard);

        // PROCESO DE COMPRA!
        if(isset($_POST['submit'])){
            echo '<p class="text-white">El Submite funciona</p>';
            $conn = mysqli_connect("localhost","root","","pfinal");
            // $elimStock = "DELETE FROM carrito WHERE id_usuario = $id AND id_prod = $prod;";
            $result = mysqli_query($conn, $query);
            echo '<p class="text-white">Id de prods en carrito</p>';
            while ($row = mysqli_fetch_array($result)) {
                $idprod = $row['id_prod'];
                $queryStock = "UPDATE productos SET cantidad = cantidad - 1 WHERE id_prod = $idprod;";
                $queryCompra = "INSERT INTO compras (id_usuario, id_prod) VALUES ($id, $idprod);";
                $elimCart = "DELETE FROM carrito WHERE id_usuario = $id AND id_prod = $idprod;";
                $resultStock = mysqli_query($conn, $queryStock);
                $resultCompra = mysqli_query($conn, $queryCompra);
                $resultCart = mysqli_query($conn, $elimCart);
                echo '<p class="text-white">'.$row['id_prod'].'</p>';
            }
            $_SESSION["compra"] = 1;
            header ("Location: history.php");
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
    <title>Checkout</title>
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
        <h1 class="display-5 fw-bold text-white text-center">Checkout</h1><br>
        <div class="row">
            <div class="col-md-9">
            <div class="card bg-dark text-white">
                    <h5 class="card-header bg-light text-dark">Datos de la compra</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="display-6 fw-bold fs-6">Direccion</h3>
                                <p class="text-white">
                                    <?php 
                                        echo ''.$data['nombre'].'<br>';
                                        echo $data['direccion'];
                                    ?>
                                </p>
                            </div>
                            <div class="col">
                                <h3 class="display-6 fw-bold fs-6">Metodo de Pago</h3>
                                <p class="text-white">
                                    <?php 
                                        echo '**** **** **** '.$card['card'].' <img src="img/card.svg" width="23">';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card bg-dark text-white">
                    <h5 class="card-header bg-light text-dark">Productos</h5>
                    <div class="card-body">
                        <?php
                            $totalCart = 0;
                            while($cart = mysqli_fetch_array($resultCart)){
                                $totalCart = $totalCart + $cart['precio'];
                                echo '<div class="container bg-dark text-white">';
                                    echo '<div class="card-body">';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-3 text-center d-flex justify-content-center align-items-center">';
                                                echo '<img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($cart['imagen']).'" class="img-thumbnail rounded img-fluid" width="100">';
                                            echo '</div>';
                                            echo '<div class="col-md-9 text-center">';
                                                echo '<br>';
                                                echo '<h5 class="card-title">'.$cart['nombre'].'</h5>';
                                                echo '<span class="lead fw-bold">'.$cart['precio'].' <img src="img/bitcoin.svg" width="23"></span>';
                                                // echo '<form action="" method="post">';
                                                //         echo '<input type="hidden" name="idprod" value="'.$cart['id_prod'].'">';
                                                //         echo '<button type="submit" name="submit" class="btn btn-light"><img src="img/trash.svg" width="23"> Eliminar</button>';
                                                // echo '</form>';
                                                // echo '<a href="#" class="btn btn-light">Eliminar</a>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<hr class="text-white">';
                            }
                        ?>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3 text-center">
                <div class="card bg-dark text-white">
                    <h5 class="card-header bg-light text-dark">Total</h5>
                    <div class="card-body">
                        <p class="text-white lead fw-bold fs-3"><?php echo $totalCart; ?> <img src="img/bitcoin.svg" width="23"></p>
                        <form action="" method="post">
                            <input type="hidden" name="comprar">
                            <button type="submit" name="submit" class="btn btn-light"><img src="img/thunder.svg" width="20"> Comprar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="container bg-dark text-white">
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-center align-items-center">
                    <p class="text-white lead fw-bold fs-1">Total</p>
                </div>
                <div class="col d-flex justify-content-start align-items-center">
                    <p class="text-white lead fw-bold fs-3"> <img src="img/bitcoin.svg" width="23"></p><br>
                </div>
            </div>
            <div class="row">
                <div class="col">

                </div>
                <div class="col d-flex justify-content-start align-items-center">
                    <a href="checkout.php" class="btn btn-light"><img src="img/thunder.svg" width="20"> Comprar</a>
                </div>
            </div>
        </div>
        </div>     -->
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
</body>
</html>