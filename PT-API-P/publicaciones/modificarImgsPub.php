<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();

    $id_publicacion = mysqli_real_escape_string($conexion, $_POST['id']);
    
    if(!empty($_FILES['imgsPublicacion'])){
        $numimg = count($_FILES['imgsPublicacion']["name"]);
        $imgs = $_FILES['imgsPublicacion'];

        $carpeta_imgs = "../../admin/assets/img/publicaciones/".$id_publicacion."/"."imgs/";

        for($x=0; $x<$numimg; $x++){
            $nombre_img = $imgs["name"][$x];
            $ruta_img = $imgs["tmp_name"][$x];

            $dir_imgs = $carpeta_imgs.$nombre_img; //ver ruta
            move_uploaded_file($ruta_img, $dir_imgs);  

            $dir_imgs = $id_publicacion."/imgs"."/".$nombre_img;

            $consulta_insert_imgs = "INSERT INTO imagen_pub (ruta_imagen_pub, fk_publicacion) VALUES('$dir_imgs','$id_publicacion')";
            mysqli_query($conexion, $consulta_insert_imgs) or die(mysqli_error($conexion));
            
        }

    }
    if(!empty( $_FILES['imgPrincipal'])){
        $ipublicacion = $_FILES['imgPrincipal']['name'];
        $ruta_ipublicacion = $_FILES['imgPrincipal']['tmp_name'];
        
        $consulta = "SELECT publi_img FROM publicacion WHERE id_publicacion = '$id_publicacion'";
        $registro = mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
        
        while ($resultado = mysqli_fetch_array($registro)){
            $publicacion_img = $resultado["publi_img"];
        }
        
        $carpeta_publicacion = "../../admin/assets/img/publicaciones/";
        $dirpublicacion = $id_publicacion."/principal"."/".$ipublicacion; //Checar ruta

        $ruta_img = $carpeta_publicacion.$publicacion_img; //poner la ruta para llegar a la imagen
        unlink($ruta_img);

        move_uploaded_file($ruta_ipublicacion, $carpeta_publicacion.$dirpublicacion);
        $consulta = "UPDATE publicacion SET publi_img = '$dirpublicacion' WHERE id_publicacion = '$id_publicacion'";
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