<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE tipo_usuario = 111");
    
    $repartidores = []; 
    while ($resultado = mysqli_fetch_array($registros)){
        $repartidores[] = $resultado;
    }

    $json = json_encode($repartidores);

    echo $json;

?>