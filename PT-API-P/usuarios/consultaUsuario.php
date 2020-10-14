<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();
    $id_facebook = mysqli_real_escape_string($conexion,$_GET['id']);

    $registros = mysqli_query($conexion, "SELECT tipo_usuario, correo, celular FROM usuario WHERE id_facebook = '$id_facebook'");
    
    $usuario = []; 
    while ($resultado = mysqli_fetch_array($registros)){
        $usuario[] = $resultado;
    }

    $json = json_encode($usuario);

    echo $json;

?>