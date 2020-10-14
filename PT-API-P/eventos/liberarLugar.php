<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $orden = mysqli_real_escape_string($conexion, $_GET['orden']);
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $ordenbucle = $orden;
    $condicion = 0;

    while($condicion == 0){
        $consulta = "SELECT nombre_evento FROM evento WHERE orden_anuncio = '$ordenbucle'";
        $registro = mysqli_query($conexion, $consulta);
        if(mysqli_num_rows($registro) > 0){
            $ordenbucle = $ordenbucle + 1;
        }else{
            $condicion = 1;
        }
    }
    while($ordenbucle >= $orden){
        $ordenbucleinsert = $ordenbucle + 1;
        $consulta = "UPDATE evento SET orden_anuncio = '$ordenbucleinsert' WHERE orden_anuncio = '$ordenbucle'";
        $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));
        $ordenbucle = $ordenbucle - 1;
    }

    if($id != null){
        $consulta = "UPDATE evento SET orden_anuncio = '$orden' WHERE id_evento = '$id'";
        $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));
    }

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