<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE tipo_usuario = 1 OR tipo_usuario = 0");
    $usuarios = []; 
    while ($resultado = mysqli_fetch_array($registros)){
        $usuarios[] = $resultado;
    }

    $json = json_encode($usuarios);

    echo $json;

?>