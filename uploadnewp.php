<?php
    if(isset($_POST['submit']) and isset($_FILES['imagen'])){
        echo "<pre>";
        print_r($_FILES['imagen']);
        echo "</pre>";
        $img_name = $_FILES['imagen']['name'];
        $img_size = $_FILES['imagen']['size'];
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $error = $_FILES['imagen']['error'];
        
        if ($error === 0){
            if ($img_size > 2000000) {
                $errmsg = "Imagen es muy pesada.";
                header("Location: newproduct.php?error=$errmsg");
            }
            else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                echo($img_ex);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                }else {
                    $errmsg = "No se permite este tipo de archivo.";
                    header("Location: newproduct.php?error=$errmsg");
                }
            }
        }
        else {
            $errmsg = "Se ha producido un error desconocido.";
            header("Location: newproduct.php?error=$errmsg");
        }
    }
    else{
        header("Location: newproduct.php");
    }
?>