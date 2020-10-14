<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    
    $response = new Result();

    $correo = mysqli_real_escape_string($conexion, $_GET['correo']);
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $consulta = "SELECT id_usuario FROM usuario WHERE correo = '$correo' AND id_usuario != '$id'";

    $registros = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($registros) > 0) {
        $response->estado = 0;
        $response->mensaje = "El correo ya está siendo utilizado.";
    }
    else{
        $response->estado = 1;
    }

    $json = json_encode($response);
    echo $json;
?>