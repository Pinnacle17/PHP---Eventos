<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseEvento.php");
    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto WHERE fk_evento_bol = $_GET[id_evento] WHERE estado_boleto = '1'");

    $boletos = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $boletos[] = $resultado;
    }

    if($boletos == null){
        Evento::UpdateEstadoEvento($id_evento, 0);
        echo null;
    }
    else{
        $json = json_encode($boletos);
        echo $json;
    }


?>