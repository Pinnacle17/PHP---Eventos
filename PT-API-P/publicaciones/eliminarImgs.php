<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();
    
    $consulta_select = "SELECT ruta_imagen_pub FROM imagen_pub WHERE id_imagen_pub=$_GET[id_img]";
    $registros = mysqli_query($conexion, $consulta_select) or die (mysqli_error($conexion));

    while ($resultado = mysqli_fetch_array($registros)){
        $ruta_img_pub = $resultado["ruta_imagen_pub"];
    }

    $consulta = "DELETE FROM imagen_pub WHERE id_imagen_pub=$_GET[id_img]";
    $registros = mysqli_query($conexion, $consulta);

    $carpeta_pub = "../../admin/assets/img/publicaciones/";
    $ruta = $carpeta_pub.$ruta_img_pub; //poner ruta correcta para llegar a la imagen

    unlink($ruta);

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