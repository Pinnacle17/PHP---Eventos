<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $consulta = "DELETE FROM promo_cod WHERE id_pro_cod = $_GET[id_promo]";
    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    
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