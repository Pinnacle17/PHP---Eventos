<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE id_usuario=$_GET[id] AND tipo_usuario = 111");

    $repartidor = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $repartidor[] = $resultado;
    }

    $json = json_encode($repartidor);

    echo $json;

?>