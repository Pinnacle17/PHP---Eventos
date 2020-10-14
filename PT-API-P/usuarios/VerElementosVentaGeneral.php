<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_venta = $_GET['id_venta'];

    $ventas = Venta::buscarventa($id_venta);
    $resultado['id_venta'] = $ventas['id_venta'];
    $entrega = $ventas['estado_entrega'];
    $resultado['fec_ven'] = $ventas['fec_ven'];
    $resultado['sub_ven'] = $ventas['sub_ven'];
    $pago = $ventas['pago'];
    if($pago == 1){
        $resultado['pago'] = "Pagado";
    }else{
        $resultado['pago'] = "Entregado";
    }
    if($entrega == 0){
        $resultado['entrega'] = "No ha sido tomado por ningun repartidor";
    }else if($entrega == 1){
        $resultado['entrega'] = "Tomado por repartidor, en proceso de entrega";
    }else{
        $resultado['entrega'] = "Entregado";
    }
    echo json_encode($resultado);
    
?>