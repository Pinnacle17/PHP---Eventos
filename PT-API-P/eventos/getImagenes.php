<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT id_imagen_eve, ruta_imagen_eve FROM imagen_eve WHERE fk_evento_img=$_GET[id_evento]");
    
    $imgs = [];
    while ($resultado = mysqli_fetch_array($registros)){
        $imgs[] = $resultado;
    }

    $json = json_encode($imgs);

    echo $json;
?>