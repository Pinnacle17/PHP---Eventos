<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto INNER JOIN evento ON boleto.fk_evento_bol = evento.id_evento WHERE estado_evento = '1'");

    $boletos = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $boletos[] = $resultado;
    }

    $json = json_encode($boletos);

    echo $json;

?>