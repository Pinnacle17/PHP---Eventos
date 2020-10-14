<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    
    $response = new Result();

    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $nombre = strtolower($nombre);

    $consulta = "SELECT nom_bol FROM boleto WHERE nom_bol = '$nombre' AND id_boleto != '$id'";
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