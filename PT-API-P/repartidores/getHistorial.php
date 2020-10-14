<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM historial_cargas WHERE fk_usuarioadm=$_GET[id_rep]");

    $historial = [];
    $id_boleto = null;
    while ($resultado = mysqli_fetch_array($registros)){
        $historial[] = $resultado;
    }
    
    for($x = 0; $x < count($historial); $x++){
        $id_boleto = $historial[$x]['fk_boleto'];
        $boleto = mysqli_query($conexion, "SELECT nom_bol FROM boleto WHERE id_boleto= '$id_boleto'");
        while ($resultado = mysqli_fetch_array($boleto)){
            $nombre_boleto = $resultado["nom_bol"];
        }
        $historial[$x]['nombre_boleto'] = $nombre_boleto;
    }
    
    $json = json_encode($historial);

    echo $json;
?>