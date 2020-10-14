<?php 
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $id_evento = $_GET['id_evento'];

    $consulta = "UPDATE evento SET estado_evento = 2 WHERE id_evento = '$id_evento'";
    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
?>