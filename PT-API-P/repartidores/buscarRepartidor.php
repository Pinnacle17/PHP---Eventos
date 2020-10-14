<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $busqueda = mysqli_real_escape_string($conexion, $_GET['nombre_rep']);

    $consulta = "SELECT * FROM usuario WHERE nombre_busqueda LIKE '%$busqueda%' AND tipo_usuario = 111";
    $registros = mysqli_query($conexion, $consulta);
    
    $repartidores = [];
    while ($registro=mysqli_fetch_array($registros)) {
        $repartidores[]=$registro;
    }

    if($repartidores == null){
        echo null; 
    }else{
        $json = json_encode($repartidores);
        echo $json;
    }
?>