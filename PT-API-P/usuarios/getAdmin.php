<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $id = mysqli_real_escape_string($conexion,$_GET['id']);

    $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE tipo_usuario = 55 AND id_usuario = '$id'");
    $usuario = []; 
    while ($resultado = mysqli_fetch_array($registros)){
        $usuario[] = $resultado;
    }

    $json = json_encode($usuario);

    echo $json;

?>