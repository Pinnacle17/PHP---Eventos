<?php
    require("../headers.php");
    require("../BD.php");

    $id_calificacion = $_GET['id_cal'];

    $consulta = "DELETE FROM calificacion WHERE id_calificacion = '$id_calificacion'";
    BD::consultaSelect($consulta);
?>