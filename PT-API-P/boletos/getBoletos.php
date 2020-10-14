<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto WHERE fk_evento_bol = $_GET[id_evento]");

    $boletos = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $boletos[] = $resultado;
    }

    if($boletos == null){
        $consulta = "UPDATE evento SET estado_evento = '0' WHERE id_evento = '$_GET[id_evento]'";
        mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
        echo null;
    }
    else{
        $json = json_encode($boletos);
        echo $json;
    }


?>