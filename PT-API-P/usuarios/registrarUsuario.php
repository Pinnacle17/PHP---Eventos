<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();
    //CACHA TODO TODOS LOS DATOS QUE FUERON ENVIADOS DESDE UNA PETICION HTTP
    $id_facebook = mysqli_real_escape_string($conexion,$_POST['id']);
    $foto = mysqli_real_escape_string($conexion,$_POST['photoUrl']);
    $nombre = mysqli_real_escape_string($conexion,$_POST['name']);

    $consulta = "SELECT id_facebook FROM usuario WHERE id_facebook = '$id_facebook'";
    $resultado = mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));

    if(mysqli_num_rows($resultado) <= 0){
        //SENTENCIA SQL
        $nombre_busqueda = strtolower($nombre);
        $consulta2 = "INSERT INTO usuario (id_facebook, foto, nombre, nombre_busqueda, tipo_usuario, activo) VALUES('$id_facebook','$foto','$nombre', '$nombre_busqueda', '0','1')";
        //EJECUTA LA SENTENCIA SQL
        mysqli_query($conexion,$consulta2) or die (mysqli_error($conexion));
    }

    $consultaid = "SELECT id_usuario FROM usuario WHERE id_facebook = '$id_facebook'";
    $res = mysqli_query($conexion,$consultaid) or die (mysqli_error($conexion));

    if(mysqli_num_rows($res) > 0){
        while ($resultado = mysqli_fetch_array($res)){
            $id_usuario = $resultado['id_usuario'];
        }
    }
    
    class Result {}
    
    $response = new Result();
    
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
        $response->id_usuario = $id_usuario;
    }
  
    echo json_encode($response);
?>