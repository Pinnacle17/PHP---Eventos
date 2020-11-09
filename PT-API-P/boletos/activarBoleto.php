<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    $conexion = conexion();
    
    Boleto::UpdateEstadoBoleto($id_boleto, 1);

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