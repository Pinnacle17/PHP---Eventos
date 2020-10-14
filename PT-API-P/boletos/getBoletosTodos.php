<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto");

    $boletos = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $boletos[] = $resultado;
    }

    $json = json_encode($boletos);

    echo $json;

?>