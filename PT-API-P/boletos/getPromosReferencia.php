<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    include_once("../modelo/ClaseBoleto.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM promo_eve WHERE fk_boleto_eve = $_GET[id_boleto]");

    $promos = [];
    $x = 0;
    while ($resultado = mysqli_fetch_array($registros)){
        $promos[] = $resultado;
        $id_boleto = $promos[$x]['fk_boleto_ref'];
        $promos[$x]['fk_boleto_ref'] = Boleto::obtenerNombreBoleto($id_boleto);
        $x++;
    }
    
    
    $json = json_encode($promos);

    echo $json;

?>