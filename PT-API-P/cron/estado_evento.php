<?php
    require("../headers.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseEvento.php");
    $dia = date("Y-m-d");
    $hora = date("h:i:s");
    $eventos_actuales = Evento::obtenerDatosEvento(2);
    while($while_eventos_actuales = mysqli_fetch_array($eventos_actuales)){
        $id_evento = $while_eventos_actuales["id_evento"];
        $fecha_termino = $while_eventos_actuales["dia_conclusion_evento"];
        $hora_de_termino = $while_eventos_actuales["hora_conclusion_evento"];
        if(($fecha_termino > $dia) || ($fecha_termino == $dia && $hora>$hora_de_termino)){
            Evento::UpdateEstadoEvento($id_evento, 3); 
        }
    }



    
    
    
?>