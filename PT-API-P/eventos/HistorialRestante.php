<?php
    require("../headers.php");
    require("../modelo/ClaseVenta.php");
    $id_evento = $_GET['']; 
    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    $numerodeboletos = 0;
    while ($while = mysqli_fetch_array($boletos)){
        $id_boletos[$numerodeboletos]["id_boleto"] = $while["id_boleto"];
        $boleto = Boleto::obtenerDatosBoleto($id_boletos[$numerodeboletos]["id_boleto"]);
        $resultado[$numerodeboletos]['nombre'] = $boleto['nom_bol'];
        $resultado[$numerodeboletos]['stock_boleto'] = $boleto['stock_boleto'];
        $resultado[$numerodeboletos]['stock_act_boleto'] = $boleto['stock_act_boleto'];
        $resultado[$numerodeboletos]['preciopublico'] = $boleto['preciopublico'];
        ++$numerodeboletos;
    }
    return $resultado;
?>