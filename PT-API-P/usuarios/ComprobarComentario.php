<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseUsuario.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");    

    $id_usuario = $_GET['id_usuario'];
    $id_evento = $_GET['id_evento'];

    $comentario = Usuario::ComprobarComentario($id_usuario, $id_evento);
    if($comentario != null){
        echo json_encode($comentario);
    }else{
        echo json_encode(1);
    }
?>