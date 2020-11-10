<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}

    $response = new Result();

    $boleto = mysqli_real_escape_string($conexion, $_GET['boleto']);
    $boleto_referencia = mysqli_real_escape_string($conexion, $_GET['boletoRef']);

    $consulta = "SELECT *FROM promo_eve WHERE fk_boleto_eve = '$boleto' AND fk_boleto_ref = '$boleto_referencia'";
    $registros = mysqli_query($conexion, $consulta);
    if(mysqli_num_rows($registros) > 0) {
        $response->estado = 0;
        $response->mensaje = "Esta promocion ya existe.";
    }
    else{
        $response->estado = 1;
    }

    $json = json_encode($response);
    echo $json;
?>