<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();
    $id_evento = mysqli_real_escape_string($conexion, $_POST['id']);
    
    if(!empty($_FILES['imgs'])){
        $numimg = count($_FILES['imgs']["name"]);
        $imgs = $_FILES['imgs'];

        $carpeta_imgs = "../../admin/assets/img/eventos/".$id_evento."/"."imgs/";//ver ruta

        for($x=0; $x<$numimg; $x++){
            $nombre_img = $imgs["name"][$x];
            $ruta_img = $imgs["tmp_name"][$x];

            $dir_imgs = $carpeta_imgs.$nombre_img; //ver ruta
            move_uploaded_file($ruta_img, $dir_imgs);
            $dir_imgs = $id_evento."/"."imgs/".$nombre_img;

            $consulta_insert_imgs = "INSERT INTO imagen_eve (ruta_imagen_eve, fk_evento_img) VALUES('$dir_imgs', '$id_evento')";
            mysqli_query($conexion, $consulta_insert_imgs) or die(mysqli_error($conexion));
        }
    }

    if(!empty($_FILES['imgCarousel'])){
        $icarousel = $_FILES['imgCarousel']['name'];
        $ruta_icarousel = $_FILES['imgCarousel']['tmp_name'];

        $consulta = "SELECT carousel_img FROM evento WHERE id_evento = '$id_evento'";
        $registro = mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
        while ($resultado = mysqli_fetch_array($registro)){
            $carousel_img = $resultado["carousel_img"];
        }

        $carpeta_evento = "../../admin/assets/img/eventos/";
        $dircarousel = $id_evento."/carousel"."/".$icarousel; //ver si ruta es correcta
        $ruta_img = $carpeta_evento.$carousel_img; //poner la ruta para llegar a la imagen

        unlink($ruta_img);
        move_uploaded_file($ruta_icarousel, $carpeta_evento.$dircarousel);

        $consulta = "UPDATE evento SET carousel_img = '$dircarousel' WHERE id_evento = '$id_evento'";
        mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
    }
    
    if(!empty( $_FILES['imgPrincipal'])){
        $ievento = $_FILES['imgPrincipal']['name'];
        $ruta_ievento = $_FILES['imgPrincipal']['tmp_name'];

        $consulta = "SELECT evento_img FROM evento WHERE id_evento = '$id_evento'";
        $registro = mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
        while ($resultado = mysqli_fetch_array($registro)){
            $evento_img = $resultado["evento_img"];
        }

        $carpeta_evento = "../../admin/assets/img/eventos/";
        $direvento = $id_evento."/principal"."/".$ievento;
        $ruta_img_vieja = $carpeta_evento.$evento_img;

        unlink($ruta_img_vieja);
        move_uploaded_file($ruta_ievento, $carpeta_evento.$direvento);

        $consulta = "UPDATE evento SET evento_img = '$direvento' WHERE id_evento = '$id_evento'";
        mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
    }
    
    class Result {}

    $response = new Result();
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>