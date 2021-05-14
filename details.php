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

        if(isset($_POST['submit'])){
            $prod = $_POST['idprod'];
            echo '<p class="text-white">Valor para el carrito '.$prod.' '.$id.' '.htmlspecialchars($_SERVER["PHP_SELF"]).'</p>';
            $conn = mysqli_connect("localhost","root","","pfinal");
            $addCart = "INSERT INTO carrito (id_usuario, id_prod) VALUES ($id, $prod);";
            $result = mysqli_query($conn, $addCart);
            header ("Location: comprar.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./lotus.css">
    <title>Details</title>
</head>
<?php
    $id_prod = $_GET['id'];
    // echo '<p class="text-white">Valor del ID'.$id.'</p>';
    $conn = mysqli_connect("localhost","root","","pfinal");
    $query = "SELECT * FROM productos WHERE id_prod = '$id_prod';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
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
    </nav>
    <div class="container">
        <br><br>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md text-center">
                <?php
                    echo '<img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($row['imagen']).'" width="400" class="img-thumbnail img-fluid" />';
                ?>
            </div>
            <div class="col-md ps-5">
                <br>
                <?php
                    echo '<h1 class="text-white">'.($row['nombre']).'</h1>';
                    echo '<h6 class="text-white">Fabricante: '.($row['fabricante']).'</h6>';
                    echo '<p class="text-white lead">'.($row['descripcion']).'</p>';
                    echo '<p class="text-white lead fw-bold">'.($row['precio']).' <img src="img/bitcoin.svg" width="23" alt="..."></span></p>';
                    echo '<span class="text-white lead fs-6">Stock: '.($row['cantidad']).'</span>';
                ?>
                <br><br>
                <div class="text-center">
                    <?php
                        if (isset($_SESSION["id"])) {
                            // echo '<a href="comprar.php?id='.$id_prod.'"><img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($row['imagen']).'" class="card-img-top" /></a>';
                            echo '<form action="" method="post">';
                                echo '<input type="hidden" name="idprod" value="'.$id_prod.'">';
                                echo '<button type="submit" name="submit" class="btn btn-light"><img src="img/cart.svg" width="23" alt=""> Add to Cart</button>';
                                // echo '<a href="comprar.php?id='.$id_prod.'" class="btn btn-light"><img src="img/cart.svg" width="23" alt="..."> Add to cart</a>';
                            echo '</form>';
                        }
                        else {
                            echo '<a href="login.php" class="btn btn-light"><img src="img/cart.svg" width="23" alt="..."> Add to cart</a>';
                        }
                    ?>
                    <!-- <a href="#" class="btn btn-light"><img src="img/cart.svg" width="23" alt="..."> Add to cart</a>'; -->
                </div>
            </div>
        </div>
        <br>
        <hr class="text-info">
        <br><br>
    </div>
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