<?php
    require("../headers.php");
    require("../modelo/ClaseEvento.php");
    $fecha = date("d-m-Y");
    $fecha = date("d-m-Y",strtotime($fecha."- 1 month"));
    $fecha = date("d-m-Y",strtotime($fecha."- 1 year"));
    $consulta = "SELECT id_evento FROM evento WHERE dia_conclusion_evento > '$fecha' AND estado_evento = '3'";
    $eventos = BD::consultaSelect($consulta);
    while ($while = mysqli_fetch_array($eventos)){
        $id_evento = $while["id_evento"];
        $consulta2 = "SELECT COUNT(*), SUM(num_calificacion) FROM calificacion WHERE fk_evento_cal = '$id_evento'";
        $eventos = BD::consultaSelect($consulta2);
        $row = mysqli_fetch_row($eventos);
        if($row[0] > 0){
            $calificacion_promedio = $row[1] / $row[0];
            $consulta3 = "UPDATE evento SET calificacion_evento = '$calificacion_promedio' WHERE id_evento = '$id_evento'";
            $eventos = BD::consultaSelect($consulta3);
        }
    }
?>