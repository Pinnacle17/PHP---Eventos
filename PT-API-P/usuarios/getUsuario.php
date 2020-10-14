<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $id_fb = mysqli_real_escape_string($conexion,$_GET['id_fb']);
    $id_usuario = mysqli_real_escape_string($conexion,$_GET['id_usuario']);

    if($id_fb == "null"){
        $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE tipo_usuario = 1 AND id_usuario = '$id_usuario'");
    }
    else{
        $registros = mysqli_query($conexion, "SELECT * FROM usuario WHERE tipo_usuario = 1 AND id_facebook = '$id_fb'");
    }
    $usuario = []; 
    while ($resultado = mysqli_fetch_array($registros)){
        $usuario['id_usuario'] = $resultado['id_usuario'];
        $usuario['nombre'] = $resultado['nombre'];
        $usuario['foto'] = $resultado['foto'];
        $usuario['correo'] = $resultado['correo'];
        $usuario['celular'] = $resultado['celular'];
        $usuario['celular_ext'] = $resultado['celular_ext'];
        $usuario['celular'] = $resultado['celular'];
        $usuario['fec_nac'] = $resultado['fec_nac'];
    }

    $json = json_encode($usuario);

    echo $json;

?>