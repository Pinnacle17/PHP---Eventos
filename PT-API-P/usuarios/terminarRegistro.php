<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $id = mysqli_real_escape_string($conexion,$_POST['id']);
    $correo =  mysqli_real_escape_string($conexion,$_POST['correo']);
    $celular =  mysqli_real_escape_string($conexion,$_POST['celular']);
    $celularext =  mysqli_real_escape_string($conexion,$_POST['celularExt']);
    $nacimiento =  mysqli_real_escape_string($conexion,$_POST['nacimiento']);

    $consulta = "UPDATE usuario SET correo = '$correo', celular = '$celular', celular_ext = '$celularext', fec_nac = '$nacimiento', tipo_usuario = '1' WHERE id_facebook = '$id'";
    //EJECUTA LA SENTENCIA SQL
    mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));;

    class Result {}
    
    $response = new Result();
    
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
        $response->correo = $correo;
        $response->celular = $celular;
    }
  
    echo json_encode($response);

?>