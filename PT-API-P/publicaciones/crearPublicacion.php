<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();
    
    $fecha = date('Y-m-d H:i:s');
    $titulo = $_POST["titulo"];
    $articulo = $_POST["articulo"];

    $numimg = count($_FILES['imgsPublicacion']["name"]);
    $imgs = $_FILES['imgsPublicacion'];
    $ipublicacion = $_FILES['imgPrincipal']['name'];
    $ruta_ipublicacion = $_FILES['imgPrincipal']['tmp_name'];

    $consulta_insert_publicacion = "INSERT INTO publicacion(
    titulo_pub,
    articulo_pub,
    creacion_pub,
    visitas_publicacion) VALUES(
    '$titulo',  
    '$articulo', 
    '$fecha',
    '0')";

    mysqli_query($conexion, $consulta_insert_publicacion) or die (mysqli_error($conexion));

    $consulta_select_id = "SELECT id_publicacion FROM publicacion WHERE titulo_pub = '$titulo'";
    $registros = mysqli_query($conexion, $consulta_select_id) or die (mysqli_error($conexion));

    while ($resultado = mysqli_fetch_array($registros)){
        $id_pub = $resultado["id_publicacion"];
    }

    $carpeta_publicacion = "../../admin/assets/img/publicaciones/".$id_pub;
    mkdir($carpeta_publicacion, 0777, true);

    $carpeta_ipublicacion = "../../admin/assets/img/publicaciones/".$id_pub."/"."principal";
    mkdir($carpeta_ipublicacion, 0777, true);

    $carpeta_imgs = "../../admin/assets/img/publicaciones/".$id_pub."/"."imgs";
    mkdir($carpeta_imgs, 0777, true);

    $dirpub = $carpeta_ipublicacion."/".$ipublicacion;

    move_uploaded_file($ruta_ipublicacion, $dirpub);

    $dirpub = $id_pub."/principal"."/".$ipublicacion;

    $consulta_update_pub = "UPDATE publicacion SET publi_img = '$dirpub' WHERE id_publicacion = '$id_pub'";
    mysqli_query($conexion, $consulta_update_pub) or die (mysqli_error($conexion));

    for($x=0; $x<$numimg; $x++){

        $nombre_img = $imgs["name"][$x];
        $ruta_img = $imgs["tmp_name"][$x];

        $dir_imgs = $carpeta_imgs."/".$nombre_img;
        move_uploaded_file($ruta_img, $dir_imgs);  

        $dir_imgs = $id_pub."/imgs"."/".$nombre_img;

        $consulta_insert_imgs = "INSERT INTO imagen_pub (ruta_imagen_pub, fk_publicacion) VALUES('$dir_imgs','$id_pub')";
        mysqli_query($conexion, $consulta_insert_imgs) or die(mysqli_error($conexion));
        
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