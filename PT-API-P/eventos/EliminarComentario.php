<?php
    require("../headers.php");
    require("../BD.php");
    
    $id_calificacion = $_GET['id_cal'];

    $consulta = "UPDATE calificacion SET estado_cal = '0' WHERE id_calificacion = '$id_calificacion'";
    BD::consultaSelect($consulta);
?>