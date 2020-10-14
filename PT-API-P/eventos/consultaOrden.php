<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    
    $response = new Result();

    $orden = mysqli_real_escape_string($conexion, $_GET['orden']);
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $consulta = "SELECT nombre_evento, orden_anuncio FROM evento WHERE orden_anuncio = '$orden' AND id_evento != '$id'";
    $registros = mysqli_query($conexion, $consulta);
    if(mysqli_num_rows($registros) > 0) {
        while ($registro=mysqli_fetch_array($registros)) {
            $nombre=$registro["nombre_evento"];//existe y envia el nombre del evento que ocupa la casilla
        }
        $response->estado = 0;
        $response->mensaje = "El lugar está ocupado por el evento: ".$nombre;
    }
    else{
        $response->estado = 1;
    }

    $json = json_encode($response);
    echo $json;
?>