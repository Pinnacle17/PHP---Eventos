<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto WHERE id_boleto = $_GET[id_boleto]");

    while ($resultado = mysqli_fetch_array($registros)){
        $boleto[] = $resultado;
    }

    $json = json_encode($boleto);

    echo $json;

?>