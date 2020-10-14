<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    
    $response = new Result();

    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);
    $nombre = strtolower($nombre);

    $consulta = "SELECT titulo_pub_busqueda FROM publicacion WHERE titulo_pub = '$nombre'";
    $registros = mysqli_query($conexion, $consulta);
    if(mysqli_num_rows($registros) > 0) {
        $response->estado = 0;
        $response->mensaje = "El nombre ya está siendo utilizado.";
    }
    else{
        $response->estado = 1;
    }

    $json = json_encode($response);
    echo $json;
?>