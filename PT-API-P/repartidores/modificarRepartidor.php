<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();
    
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidoP = mysqli_real_escape_string($conexion, $_POST['apellidoP']);
    $apellidoM = mysqli_real_escape_string($conexion, $_POST['apellidoM']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $telefonoExt = mysqli_real_escape_string($conexion, $_POST['telefonoExt']);
    $contra = mysqli_real_escape_string($conexion, $_POST['contra']);

    $nombre = $nombre." ".$apellidoP." ".$apellidoM;
    $nombrebusqueda = strtolower($nombre);

    if($contra == null){
        $consulta = "UPDATE usuario SET nombre = '$nombre', nombre_busqueda = '$nombrebusqueda', correo = '$correo', celular = '$telefono', celular_ext = '$telefonoExt' WHERE id_usuario = '$id' AND tipo_usuario = 111";
    }
    else{
        $contraH = password_hash($contra, PASSWORD_DEFAULT);
        $consulta = "UPDATE usuario SET nombre = '$nombre', nombre_busqueda = '$nombrebusqueda', correo = '$correo', celular = '$telefono', celular_ext = '$telefonoExt', contrasena = '$contraH' WHERE id_usuario = '$id' AND tipo_usuario = 111";
    }

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