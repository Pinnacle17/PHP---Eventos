<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $id_evento = $_GET['id_evento'];

    $consultaboleto = "SELECT id_boleto FROM boleto WHERE fk_evento_bol = '$id_evento'";
    $resultadoboleto = mysqli_query($conexion, $consultaboleto) or die(mysqli_error($conexion));

    if(mysqli_num_rows($resultadoboleto) >= 1){
        echo json_encode(0);
    }
    else{
        echo json_encode(1);
    }
?>