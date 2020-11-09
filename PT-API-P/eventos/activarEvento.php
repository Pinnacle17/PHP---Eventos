<?php 
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseEvento.php");
    $conexion = conexion();

    $id_evento = $_GET['id_evento'];

    Evento::UpdateEstadoEvento($id_evento, 1);
?>