<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    
    $response = new Result();

    $codigo = mysqli_real_escape_string($conexion, $_GET['codigo']);

    $consulta = "SELECT codigo FROM promo_cod WHERE codigo = '$codigo'";
    $registros = mysqli_query($conexion, $consulta);
    if(mysqli_num_rows($registros) > 0) {
        $response->estado = 0;
        $response->mensaje = "El codigo ya está activo. Escriba uno diferente.";
    }
    else{
        $response->estado = 1;
    }

    $json = json_encode($response);
    echo $json;
?>