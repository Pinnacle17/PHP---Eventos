<?php
    require_once("headers.php");
    require_once("BD.php");
    require_once("modelo/ClaseEvento.php");
    $dia = date("Y-m-d");
    $hora = date("h:i:s");
    $consulta_eventos_actuales = "SELECT *FROM evento WHERE estado_evento = '1'";
    $resultado_eventos_actuales = BD::consultaSelect($consulta_eventos_actuales);
    if(mysqli_num_rows($resultado_eventos_actuales) >= 1){
      while($eventos_actuales = mysqli_fetch_array($resultado_eventos_actuales)){
        $id_evento = $eventos_actuales["id_evento"];
        $fecha_termino = $eventos_actuales["dia_conclusion_evento"];
        $hora_de_termino = $eventos_actuales["hora_conclusion_evento"];
        if(($fecha_termino > $dia) || ($fecha_termino == $dia && $hora>$hora_de_termino)){
            Evento::UpdateEstadoEvento($id_evento, 3); 
        }
    }  
    }
?>