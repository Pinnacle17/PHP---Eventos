<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseEvento.php");
    $conexion = conexion();

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $inventario = mysqli_real_escape_string($conexion, $_POST['inventario']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['desc']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $fk_evento = mysqli_real_escape_string($conexion, $_POST['id']);

    $consulta = "INSERT INTO boleto(
    nom_bol,
    descripcion_boleto,
    stock_boleto,
    stock_act_boleto,
    stock_repartidor,
    precio_bol,
    precio_actual_boleto,
    fk_evento_bol) VALUES(
    '$nombre',  
    '$descripcion',
    '$inventario', 
    '$inventario', 
    '$inventario', 
    '$precio',
    '$precio',
    '$fk_evento')";

    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    
    
    class Result {}
    
    $response = new Result();
    
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        Evento::UpdateEstadoEvento($fk_evento, 1);
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>