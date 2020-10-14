<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();
    
    $busqueda = mysqli_real_escape_string($conexion, $_GET['nombre_evento']);

    $consulta = "SELECT * FROM evento WHERE nombre_evento_busqueda LIKE '%$busqueda%'";
    $registros = mysqli_query($conexion, $consulta);
    
    $eventos = [];

    while ($registro=mysqli_fetch_array($registros)) {
        $eventos[]=$registro;
    }

    if($eventos == null){
        echo null; 
    }else{
        $json = json_encode($eventos);
        echo $json;
    }
    
?>