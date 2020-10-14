<?php

    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM publicacion");
    
    $pubs = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $pubs[] = $resultado;
    }

    $json = json_encode($pubs);

    echo $json;
?>