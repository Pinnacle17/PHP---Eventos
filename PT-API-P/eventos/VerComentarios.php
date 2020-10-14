<?php
    require("../headers.php");
    require("../BD.php");
    include_once("../modelo/ClaseEvento.php");
    include_once("../modelo/ClaseUsuario.php");

    $id_evento = $_GET['id_evento'];

    $comentarios = Evento::VerComentarios($id_evento);
    if($comentarios == null){
        echo json_encode(null);
    }else{
        $cantidadcomentarios = count($comentarios);
        for($x=0;$x<$cantidadcomentarios;$x++){
            $final[$x]["id_calificacion"] = $comentarios[$x]["id_calificacion"];
            $final[$x]["opinion"] = $comentarios[$x]["opinion"];
            $final[$x]['num_calificacion'] = $comentarios[$x]['num_calificacion'];
            $final[$x]['id_usuario'] = $comentarios[$x]['fk_usuario_cal'];
            $final[$x]['nombre_usuario'] = Usuario::NombreUsuario($comentarios[$x]['fk_usuario_cal']);
        }
        echo json_encode($final);
    }
?>