<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_evento = $_GET['id_evento'];
    $fecha = $_GET['fecha']; 

    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    $numerodeboletos = 0;
    while ($while = mysqli_fetch_array($boletos)){
        $id_boletos[$numerodeboletos]["id_boleto"] = $while["id_boleto"];
        $numerodeboletos++;
    }
    $venta = Venta::Fechaventa($fecha);

    if($venta == null){
        echo json_encode(null);
    }else{
        $numerodeventas = count($venta);
        for($x=0;$x<$numerodeboletos;$x++){
            $boleto = Boleto::obtenerDatosBoleto($id_boletos[$x]["id_boleto"]);
            $temporal[$x]['nombre'] = $boleto['nom_bol'];
            $temporal[$x]['cantidad'] = 0;
            $temporal[$x]['subtotal'] = 0;
            for($y=0;$y<$numerodeventas;$y++){
                if($venta[$y]['pago']==1){
                    $elementoventa = Venta::buscarelementosventaboletofecha($id_boletos[$x]["id_boleto"], $venta[$y]["id_venta"]);
                    if($elementoventa != null){
                        $cantidadelementoventa = count($elementoventa);
                        for($z=0;$z<$cantidadelementoventa;$z++){
                            $temporal[$x]['cantidad'] = $temporal[$x]['cantidad'] + $elementoventa[$z]["cantidad_bol"];
                            $temporal[$x]['subtotal'] = $temporal[$x]['subtotal'] + $elementoventa[$z]["sub_bol"];
                        }
                    }
                }
            }
        }
        echo json_encode($temporal);
    }

?>