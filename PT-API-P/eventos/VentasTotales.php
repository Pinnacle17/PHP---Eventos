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
        $boleto = Boleto::obtenerDatosBoleto($id_boletos[$x]["id_boleto"]);
        $temporal[$x]['nombre'] = $boleto['nom_bol'];
        $temporal[$x]['cantidad'] = 0;
        $temporal[$x]['subtotal'] = 0;
        $elementos = Venta::buscarelementosventaboleto($id_boletos[$x]["id_boleto"]);
        $numeroelementos = count($elementos);
        for($y=0;$y<$numeroelementos;$y++){
                $temporal[$x]['cantidad'] = $temporal[$x]['cantidad'] + $elementos[$y]["cantidad_bol"];
                $temporal[$x]['subtotal'] = $temporal[$x]['subtotal'] + $elementos[$y]["sub_bol"];
        }
    }
    echo json_encode($temporal)
    

?>