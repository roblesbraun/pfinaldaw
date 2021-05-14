<?php
    session_start();
    // echo '<p class="text-white">'.$_SESSION["id"].'</p>';
    if (isset($_SESSION["id"])) {
        $id = ($_SESSION["id"]);
        $conn = mysqli_connect("localhost","root","","pfinal");
        $query = "SELECT nombre, imagen, id_prod FROM productos;";
        $result = mysqli_query($conn, $query);
        $prod = '';

        if(isset($_POST['submit'])){
            session_destroy();
            header("Location: secretlog.php");
        }
        
        if(isset($_POST['editar'])){
            $_SESSION["idprod"] = $_POST['idprod'];
            header("Location: itemdetails.php");
        }

        if(isset($_POST['buscar'])){
            $prod = $_POST['producto'];
            if($prod == '') {
                $query = "SELECT nombre, imagen, id_prod FROM productos;";
                $result = mysqli_query($conn, $query);
            }
            else {
                $query = "SELECT nombre, imagen, id_prod FROM productos WHERE nombre = '$prod';";
                $result = mysqli_query($conn, $query);
            }
            // echo '<p class="text-white">HOLA TA ENTRE AL NUEVO CASO'.$prod.'</p>';
            // session_destroy();
            // header("Location: secretlog.php");
        }

        if(isset($_POST['limpiar'])){
            $prod = '';
            header("Location: edititem.php");
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
    <title>Editar Productos</title>
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
    <div class="container text-white">
        <h1 class="display-3 fw-bold text-center">Editar Productos</h1>
        <form action="" method="post">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <fieldset>
                        <label class="form-label text-white" for="producto">Nombre del producto</label>
                        <input class="form-control form-control-sm text-white bg-dark" list="product-list" type="text" name="producto" value="<?php echo $prod;?>"><br>
                        <div class="container text-center">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" name="buscar" class="btn btn-light btn-sm"><img src="img/bino.svg" width="15" alt=""> Buscar</button>
                                </div>
                                <div class="col">
                                <button type="submit" name="limpiar" class="btn btn-light btn-sm"><img src="img/wind.svg" width="15" alt=""> Limpiar</button>
                                </div>
                            </div>
                        </div>
                        <datalist id="product-list">
                            <?php
                                $queryProds = "SELECT nombre FROM productos;";
                                $resultProds = mysqli_query($conn, $queryProds);
                                while($productName = mysqli_fetch_array($resultProds)){
                                    echo '<option value="'.$productName['nombre'].'"></option>';
                                }
                            ?>
                        </datalist>
                    </fieldset>
                </div>
                <div class="col-2"></div>
            </div>
        </form>
        <div class="container">
            <table class="table table-striped table-dark text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = mysqli_connect("localhost","root","","pfinal");
                        while($products = mysqli_fetch_array($result)){
                            // $idprod = $historial['id_prod'];
                            // $queryImg = "SELECT imagen FROM productos WHERE id_prod = $idprod;";
                            // $resultImg = mysqli_query($conn, $queryImg);
                            // $img = mysqli_fetch_array($resultImg);
                            echo '<tr>';
                            echo '<th>'.$products['id_prod'].'</th>';
                            echo '<td><img src="data:image/jpeg;charset=utf8;base64,'.base64_encode($products['imagen']).'" class="img-thumbnail rounded img-fluid" width="80"></td>';
                            echo '<td>'.$products['nombre'].'</td>';
                            echo '<td>';
                                // echo '<a href="itemdetails.php?id='.$products['id_prod'].'" class="btn btn"><img src="img/edit.svg" width="15"></a>';
                                echo '<form action="" method="post">';
                                    echo '<input type="hidden" name="idprod" value="'.$products['id_prod'].'">';
                                    echo '<button type="submit" name="editar" class="btn btn"><img src="img/edit.svg" width="15"></button>';
                                echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>