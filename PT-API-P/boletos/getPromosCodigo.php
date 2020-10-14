<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM promo_cod WHERE fk_boleto_cod = $_GET[id_boleto]");

    $promos = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $promos[] = $resultado;
    }

    $json = json_encode($promos);

    echo $json;

?>