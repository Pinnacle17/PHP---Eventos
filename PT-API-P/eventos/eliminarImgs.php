<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $consulta_select = "SELECT ruta_imagen_eve FROM imagen_eve WHERE id_imagen_eve=$_GET[id_imagen]";
    $registros = mysqli_query($conexion, $consulta_select) or die (mysqli_error($conexion));

    while ($resultado = mysqli_fetch_array($registros)){
        $ruta = $resultado["ruta_imagen_eve"];
    }

    $consulta_delete = "DELETE FROM imagen_eve WHERE id_imagen_eve=$_GET[id_imagen]";
    mysqli_query($conexion, $consulta_delete) or die (mysqli_error($conexion));

    $carpeta_evento = "../../admin/assets/img/eventos/";
    $ruta = $carpeta_evento.$ruta; //poner ruta correcta para llegar a la imagen
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