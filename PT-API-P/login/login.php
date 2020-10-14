<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseUsuario.php");
    $conexion = conexion();

    $correo = mysqli_real_escape_string($conexion,$_POST['correo']);
    $contra = mysqli_real_escape_string($conexion,$_POST['contra']);
    $tipo = mysqli_real_escape_string($conexion,$_POST['tipo']);

    class Result {}
    $response = new Result();

    $instancia = new Usuario();

    $usuario = $instancia->Iniciodesesion($correo, $contra, $tipo);

    if($usuario['estado'] == 1){
        $response->id_usuario = $usuario['id_usuario'];
        $response->tipo_usuario = $usuario['tipo_usuario'];
        $response->activo = $usuario['activo'];
        $response->estado = 1;
    }
    else{
        if($usuario['estado'] == -1){     
            $response->mensaje = "El correo que trata de ingresar no está registrado.";
            $response->estado = 0;
        }
        else{
            $response->mensaje = "La contraseña que trata de ingresar no es correcta.";
            $response->estado = 0;
        }
    }
    echo json_encode($response);

?>