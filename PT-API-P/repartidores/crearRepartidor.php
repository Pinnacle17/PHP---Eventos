<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $nombre = mysqli_real_escape_string($conexion,$_POST['nombre']);
    $correo = mysqli_real_escape_string($conexion,$_POST['correo']);
    $tel = mysqli_real_escape_string($conexion,$_POST['telefono']);
    $telext = mysqli_real_escape_string($conexion,$_POST['telefonoExt']);
    $nacimiento = mysqli_real_escape_string($conexion,$_POST['fechaNacimiento']);

    $pass = mysqli_real_escape_string($conexion,$_POST['contra']);
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $nombre_busqueda = strtolower($nombre);
    $consulta = "INSERT INTO usuario (
        nombre, 
        nombre_busqueda, 
        correo, 
        celular, 
        celular_ext, 
        fec_nac, 
        contrasena, 
        tipo_usuario, 
        activo) 
    VALUES(
        '$nombre', 
        '$nombre_busqueda', 
        '$correo',
        '$tel',
        '$telext',
        '$nacimiento',
        '$pass',
        '111',
        '1')";

    mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));

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