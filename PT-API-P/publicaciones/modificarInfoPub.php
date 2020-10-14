<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();

    $id_publicacion = mysqli_real_escape_string($conexion, $_POST['id']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $articulo = mysqli_real_escape_string($conexion, $_POST['articulo']);
    $tituloBusqueda = strtolower($titulo);

    $consulta = "UPDATE publicacion SET titulo_pub = '$titulo', titulo_pub_busqueda = '$tituloBusqueda', articulo_pub = '$articulo' WHERE id_publicacion = '$id_publicacion'";
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