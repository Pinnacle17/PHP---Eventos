<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_evento = $_GET['id_evento'];

    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    $numerodeboletos = 0;
    while ($while = mysqli_fetch_array($boletos)){
        $id_boletos[$numerodeboletos]["id_boleto"] = $while["id_boleto"];
        $numerodeboletos++;
    }
    for($x=0;$x<$numerodeboletos;$x++){
        $elementoventa = Venta::buscarelementosventaboleto($id_boletos[$x]["id_boleto"]);
        $cantidadelementoventa = count($elementoventa);
        for($y = 0; $y<$cantidadelementoventa; $y++){
            $edad = Venta::Edadventa($elementoventa[$y]["fk_ventaele"]);
            if($edad != null){
                $edad = $edad["edad_ven"];
                if(!isset($resultado[$edad]['cantidad'])){
                    $resultado[$edad]['cantidad'] = intval($elementoventa[$y]["cantidad_bol"]);
                }else{
                    $resultado[$edad]['cantidad'] = $resultado[$edad]['cantidad'] + $elementoventa[$y]["cantidad_bol"];
                }
            }
        }
    }
    echo json_encode($resultado);
    
?>