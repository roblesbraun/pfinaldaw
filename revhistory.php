<?php
    session_start();
    // echo '<p class="text-white">'.$_SESSION["id"].'</p>';
    if (isset($_SESSION["id"])) {
        $id = ($_SESSION["id"]);
        $conn = mysqli_connect("localhost","root","","pfinal");
        $query = "SELECT * FROM compras;";
        $result = mysqli_query($conn, $query);

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
    <title>Historial de Compras</title>
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
    </nav><br>
    <div class="container">
        <h1 class="display-4 fw-bold text-white text-center">Historial de Compras de Usuarios</h1>
        <br>
        <table class="table table-striped table-dark text-center">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>ID Usuario</th>
                    <th>Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $conn = mysqli_connect("localhost","root","","pfinal");
                    while($historial = mysqli_fetch_array($result)){
                        $idprod = $historial['id_prod'];
                        $queryImg = "SELECT imagen FROM productos WHERE id_prod = $idprod;";
                        $resultImg = mysqli_query($conn, $queryImg);
                        $img = mysqli_fetch_array($resultImg);
                        echo '<tr>';
                        echo '<th>'.$historial['id_compra'].'</th>';
                        echo '<td>'.$historial['id_prod'].'</td>';
                        echo '<td><img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($img['imagen']).'" class="img-thumbnail rounded img-fluid" width="80"></td>';
                        // echo '<td>';
                        //     echo '<form action="" method="post">';
                        //         echo '<input type="hidden" name="idprod" value="'.$historial['id_prod'].'">';
                        //         echo '<button type="submit" name="eliminar" class="btn btn"><img src="img/delete.svg" width="15"></button>';
                        //     echo '</form>';
                        // echo '</td>';
                    echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>