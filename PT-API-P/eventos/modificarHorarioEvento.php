<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();

    $id_evento = mysqli_real_escape_string($conexion, $_POST['id']);
    $horainicio = mysqli_real_escape_string($conexion, $_POST['horaInicio']);
    $horafin = mysqli_real_escape_string($conexion, $_POST['horaFin']);
    $diainicio = mysqli_real_escape_string($conexion, $_POST['diaInicio']);
    $diafin = mysqli_real_escape_string($conexion, $_POST['diaFin']);
    $horainicio = date("H:i:s",strtotime($horainicio));
    $horafin = date("H:i:s",strtotime($horafin));
    
    $consulta = "UPDATE evento SET dia_inicio_evento = '$diainicio', dia_conclusion_evento = '$diafin', hora_inicio_evento = '$horainicio', hora_conclusion_evento = '$horafin' WHERE id_evento = '$id_evento'";
    $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));

    class Result {}

    $response = new Result();
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>