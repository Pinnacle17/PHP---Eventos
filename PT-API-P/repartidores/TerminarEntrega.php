<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $conexion = conexion();

    $id_venta = $_GET['id_venta'];
    $id_usuario = $_GET['id_repartidor'];

    class Result {}
    $response = new Result();

    Repartidor::UpdateRegistroEntrega($id_venta, $id_usuario, 2);
    Repartidor::UpdateEstadoEntregaVenta($id_venta, 2);

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response);

?>