<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();

    $id_usuario = mysqli_real_escape_string($conexion, $_POST['id_usuario']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $celular = mysqli_real_escape_string($conexion, $_POST['celular']);
    $celular_ext = mysqli_real_escape_string($conexion, $_POST['celularExt']);
    
    $consulta = "UPDATE usuario SET correo = '$correo', celular = '$celular', celular_ext = '$celular_ext' WHERE id_usuario = '$id_usuario'";
    $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));

    class Result {}

    $response = new Result();
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>