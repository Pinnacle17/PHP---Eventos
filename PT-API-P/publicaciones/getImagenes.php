<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM imagen_pub WHERE fk_publicacion=$_GET[id_pub]");

    $imgs = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $imgs[] = $resultado;
    }

    $json = json_encode($imgs);

    echo $json;
?>