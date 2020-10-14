<?php
    //mostrara los elementos de las entregas
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_venta = $_GET['id_venta'];

    $ventas = Venta::buscarelementosventa($id_venta);
    if($ventas != null){
        $numeroventas = count($ventas);
        for($x = 0; $x<$numeroventas; $x++){
            $resultado[$x]['id_boleto'] = $ventas[$x]['fk_boletoele'];
            $datos = Boleto::obtenerNombreDescripcionBoleto($resultado[$x]['id_boleto']);
            $resultado[$x]['nombre'] = $datos['nombre'];
            $resultado[$x]['cantidad_bol'] = $ventas[$x]['cantidad_bol'];
        }
        echo json_encode($resultado);
    }else{
        echo json_encode(null);
    }

?>