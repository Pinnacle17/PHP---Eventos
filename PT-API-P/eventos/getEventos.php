<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();
    
    $tipo =  $_GET['tipo'];

    if($tipo == -1){
        $registros = mysqli_query($conexion, "SELECT * FROM evento");
    }
    else if($tipo == 0){
        $registros = mysqli_query($conexion, "SELECT * FROM evento WHERE tipo_evento = '0'");
    }
    else if($tipo == 1){
        $registros = mysqli_query($conexion, "SELECT * FROM evento WHERE tipo_evento = '1'");
    }
    else if($tipo == 2){
        $registros = mysqli_query($conexion, "SELECT * FROM evento WHERE estado_evento = '1'");
    }

    $eventos = [];

    while ($resultado = mysqli_fetch_array($registros)){
        $eventos[] = $resultado;
    }

    $json = json_encode($eventos);

    echo $json;

?>