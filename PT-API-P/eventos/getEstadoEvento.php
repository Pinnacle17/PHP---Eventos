<?php
    //este codigo lo que hace es devolver el estado del evento para saber en que condicion se muestra
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    include_once("../modelo/ClaseEvento.php");

    $conexion = conexion();

    class Result {}
    $response = new Result();
    $id_evento = $_GET['id_evento'];

    $evento = Evento::obtenerDatosEvento($id_evento);

    $response->estado = $evento["estado_evento"];

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    
    echo json_encode($response); 
?>