<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();
    
    $id_evento = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $orden = mysqli_real_escape_string($conexion, $_POST['orden']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['desc']);
    $enlace = mysqli_real_escape_string($conexion, $_POST['enlace']);

    $nombrebusqueda = strtolower($nombre);

    $consulta = "UPDATE evento SET nombre_evento = '$nombre', orden_anuncio = '$orden', nombre_evento_busqueda = '$nombrebusqueda', enlace_evento = '$enlace', tipo_evento = '$tipo', descripcion_evento = '$descripcion' WHERE id_evento = '$id_evento'";
    $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));   

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