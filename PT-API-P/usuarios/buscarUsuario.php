<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $busqueda = mysqli_real_escape_string($conexion, $_GET['nombre_usuario']);

    $consulta = "SELECT * FROM usuario WHERE nombre_busqueda LIKE '%$busqueda%' AND tipo_usuario = 1";
    $registros = mysqli_query($conexion, $consulta);
    
    $usuarios = [];
    while ($registro=mysqli_fetch_array($registros)) {
        $usuarios[]=$registro;
    }

    if($usuarios == null){
        echo null; 
    }else{
        $json = json_encode($usuarios);
        echo $json;
    }
?>