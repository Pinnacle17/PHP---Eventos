<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $busqueda = mysqli_real_escape_string($conexion, $_GET['nombre_pub']);

    $consulta = "SELECT * FROM publicacion WHERE titulo_pub_busqueda LIKE '%$busqueda%'";
    $registros = mysqli_query($conexion, $consulta);

    $publicaciones = [];

    while ($registro=mysqli_fetch_array($registros)) {
        $publicaciones[]=$registro;
    }

    if($publicaciones == null){
        echo null; 
    }else{
        $json = json_encode($publicaciones);
        echo $json;
    }
?>