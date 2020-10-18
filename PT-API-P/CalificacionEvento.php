<?php
    require_once("headers.php");
    require_once("BD.php");
    $fecha = date("d-m-Y");
    $fecha = date("d-m-Y",strtotime($fecha."- 1 month"));
    $fecha = date("d-m-Y",strtotime($fecha."- 1 year"));
    $consulta_eventos = "SELECT id_evento FROM evento WHERE dia_conclusion_evento > '$fecha' AND estado_evento = '3'";
    $resultado_eventos = BD::consultaSelect($consulta_eventos);
    if(mysqli_num_rows($resultado_eventos) >= 1){
        while ($eventos = mysqli_fetch_array($resultado_eventos)){
        $id_evento = $eventos["id_evento"];
        $consulta_datos_evento = "SELECT COUNT(*), SUM(num_calificacion) FROM calificacion WHERE fk_evento_cal = '$id_evento'";
        $eventos = BD::consultaSelect($consulta_datos_evento);
        $row = mysqli_fetch_row($eventos);
        if($row[0] > 0){
            $calificacion_promedio = $row[1] / $row[0];
            $consulta_update_evento = "UPDATE evento SET calificacion_evento = '$calificacion_promedio' WHERE id_evento = '$id_evento'";
            $eventos = BD::consultaSelect($consulta_update_evento);
        }
    }
    }
    
?>