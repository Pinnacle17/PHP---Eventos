<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");

    $conexion = conexion();
    
    $id_usuario = $_GET['id_usuario'];
    $id_evento = $_GET['id_evento'];

    $comentario = mysqli_real_escape_string($conexion, $_GET['comentario']);
    $calificacion = mysqli_real_escape_string($conexion, $_GET['cal']);

    $consulta = "INSERT INTO calificacion(opinion, estado_cal, num_calificacion, fk_evento_cal, fk_usuario_cal) VALUES ('$comentario', '1','$calificacion','$id_evento', '$id_usuario')";
    BD::consultaSelect($consulta);
?>