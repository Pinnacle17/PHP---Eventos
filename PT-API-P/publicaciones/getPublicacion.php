<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT id_publicacion, titulo_pub, articulo_pub, creacion_pub, publi_img FROM publicacion WHERE id_publicacion=$_GET[id_publicacion]");

    while ($resultado = mysqli_fetch_array($registros)){
        $pub[] = $resultado;
    }

    $json = json_encode($pub);

    echo $json;
?>