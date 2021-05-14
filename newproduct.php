<?php
    session_start();
    // echo '<p class="text-white">'.$_SESSION["id"].'</p>';
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
    <title>Agregar Producto</title>
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
                        echo '<a class="nav-link" href="cart.php"><img src="./img/logout.svg" width="20" alt=""></a></li>';
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
    <div class="container bg-dark">
        <?php 
            // Include the database configuration file  
            $conn = mysqli_connect("localhost","root","","pfinal");
            // Check connection
            // if ($conn) {
            //     echo "Conectaste chido";
            // }
            session_start();
            
            // If file upload form is submitted
            $nombre = $descripcion = $precio = $cantidad = $fabricante = $origen = $error = '';
            $status = $statusMsg = $msgerror = '';
            if(isset($_POST["submit"])){
                //Validacion de todos los campos
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $cantidad = $_POST['cantidad'];
                $fabricante = $_POST['fabricante'];
                $origen = $_POST['origen'];
                $error = 0;
                //Validacion de la imagen que se subira
                if ($nombre != '' and $descripcion != '' and $precio != '' and $cantidad != '' and $fabricante != '' and $origen != '') {
                    if(!empty($_FILES["imagen"]["name"])) { 
                        // Get file info 
                        $fileName = basename($_FILES["imagen"]["name"]); 
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                        
                        // Allow certain file formats 
                        $allowTypes = array('jpg','png','jpeg','gif'); 
                        if(in_array($fileType, $allowTypes)){ 
                            $imagen = $_FILES['imagen']['tmp_name']; 
                            $imgContent = addslashes(file_get_contents($imagen)); 
                        
                            // Insert image content into database 
                            $insert = "INSERT productos (nombre, descripcion, imagen, precio, cantidad, fabricante, origen) VALUES ('$nombre', '$descripcion', '$imgContent', '$precio', '$cantidad', '$fabricante', '$origen')";
                            if (!mysqli_query($conn, $insert)) {
                                die('Error: ' . mysqli_error($conn));
                            }
                            
                            if($insert){ 
                                $status = 'success'; 
                                $statusMsg = "Se ha añadido el producto correctamente."; 
                            }else{ 
                                $statusMsg = "File upload failed, please try again."; 
                            }  
                        }
                        else { 
                            $statusMsg = 'Lo sentimos, solo archivos JPG, JPEG, y PNG estan permitidos.'; 
                        } 
                    }
                    else { 
                        $statusMsg = 'Por favor elije una imagen para subir.'; 
                    } 
                }
                else {
                    $error = 1;
                }
            }
            // Display status message 
            // echo '<p class="text-white">';
            // echo $statusMsg;
            // echo "</p>";
        ?>
        <h1 class="text-white text-center">Agregar un producto</h1><br>
        <div class="row">
            <div class="col-lg d-flex justify-content-center align-items-start order-lg-last">
                <img src="img/cloudup.svg" style="max-width: 20rem;">
            </div>
            <div class="col-lg d-flex justify-content-center flex-column">
                <?php
                    if($error == 1 or $statusMsg == 'Por favor elije una imagen para subir.') {
                        echo '<div class="alert alert-danger text-center" role="alert">';
                            echo 'Favor de llenar todos los campos.';
                        echo '</div>';
                    }
                    if($status == 'success'){
                        // echo '<div class="alert alert-success" role="alert">Te has registrado exitosamente.</div>';
                        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                            echo '<strong>'.$statusMsg.'</strong>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        $nombre = $descripcion = $precio = $cantidad = $fabricante = $origen = '';
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                    <!-- Nombre -->
                    <label class="form-label text-white" for="nombre">Nombre</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="text" name="nombre" value="<?php echo $nombre;?>"><br>
                    <!-- Descripcion -->
                    <label class="form-label text-white" for="descripcion">Descripcion</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="text" name="descripcion" value="<?php echo $descripcion;?>"><br>
                    <!-- <textarea class="form-control text-white bg-dark" rows="2" name="descripcion1" value="<?php echo $descripcion;?>"></textarea><br> -->
                    <!-- Precio -->
                    <label class="form-label text-white" for="precio">Precio</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="number" name="precio" value="<?php echo $precio;?>"><br>
                    <!-- Cantidad -->
                    <label class="form-label text-white" for="cantidad">Cantidad</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="number" name="cantidad" value="<?php echo $cantidad;?>"><br>
                    <!-- Fabricante -->
                    <label class="form-label text-white" for="fabricante">Fabricante</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="text" name="fabricante" value="<?php echo $fabricante;?>"><br>
                    <!-- Origen -->
                    <label class="form-label text-white" for="origen">Origen</label>
                    <input class="form-control form-control-sm text-white bg-dark" type="text" name="origen" value="<?php echo $origen;?>"><br>
                    <!-- Imagen -->
                    <label class="form-label text-white" for="img">Imagen</label>
                    <input class="form-control form-control-sm text-white bg-dark box" type="file" name="imagen"><br><br>
                    <div class="container text-center">
                        <!-- <input class="btn btn-light" type="submit" name="submit" value="Upload"> -->
                        <button type="submit" name="submit" class="btn btn-light"><img src="img/check.svg" width="15"> Upload</button>
                    </div>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>