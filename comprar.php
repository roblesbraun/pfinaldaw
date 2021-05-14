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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./lotus.css">
    <title>Lotus</title>
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
    </nav>
    <div id="carouselExampleCaptions" class="carousel slide d-flex align-items-center flex-column" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="img/huntsmanMini.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
            <h5>Razer Huntsman Mini</h5>
            <p>Lo ultimo en teclados mecanicos por Razer.</p>
        </div>
        </div>
        <div class="carousel-item">
        <img src="img/astro50.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
            <h5>ASTRO A50</h5>
            <p>El increible headset inalambrico ha llegado a Lotus.</p>
        </div>
        </div>
        <div class="carousel-item">
        <img src="img/gProX.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-md-block">
            <h5>Logitech G Pro X Superlight</h5>
            <p>!El mejor mouse de Logitech ya esta aqui!</p>
        </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
    <div class="container">
        <br>
        <h1 class="text-white text-center display-5">Catálogo de Productos</h1><br>
            <?php 
                if (isset($_SESSION["login"])) {
                    if ($_SESSION["login"] == 1) {
                        echo '<div class="alert alert-info alert-dismissible fade show text-center" role="alert">';
                            echo '<strong>Bienvenido de nuevo!</strong>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        $_SESSION["login"] = 0;
                    }
                }
                // Include the database configuration file  
                $conn = mysqli_connect("localhost","root","","pfinal");
                // Get image data from database 
                $query = "SELECT * FROM productos WHERE flag = 1;"; 
                $result = mysqli_query($conn, $query);
                $counter = 0;
                while($row = mysqli_fetch_array($result)){
                    // echo '<img class="img-thumbnail" width="300" src="data:image/jpeg;charset=utf8;base64,'.base64_encode($row['imagen']).'" />';
                    // echo '<p class="text-white">'.$row['nombre'].'</p>';
                    $id_prod = $row['id_prod'];
                    if ($counter == 0) {
                        echo '<div class="row">';
                    }
                    echo '<div class="col-md d-flex align-items-center flex-column">';
                        echo '<div class="card bg-dark text-white" style="width: 20rem;">';
                            echo '<a href="details.php?id='.$id_prod.'"><img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($row['imagen']).'" class="card-img-top" /></a>';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title">'.$row['nombre'].'</h5>';
                                // echo '<p class="card-text">'.$row['descripcion'].'</p>';
                                echo '<span class="lead fw-bold">'.$row['precio'].' <img src="img/bitcoin.svg" width="23" alt="..."></span><br><br>';
                                echo '<div class="text-center">';
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
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<br>';
                        echo '</div>';
                    // echo $row['nombre']."<br>";
                    // echo $row['descripcion']."<br>";
                    // echo $row['precio']."</td>";
                    $counter = $counter + 1;
                    if ($counter == 3) {
                        echo "</div>";
                        $counter = 0;
                    }
                }
            ?>
    </div>
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