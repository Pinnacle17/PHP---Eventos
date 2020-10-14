<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $consulta = "DELETE FROM boleto WHERE id_boleto = $_GET[id_boleto]";
    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    if (mysqli_error($conexion)) {
        $consulta = "UPDATE boleto SET estado_boleto = 0 WHERE id_boleto =  $_GET[id_boleto]";
        mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
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