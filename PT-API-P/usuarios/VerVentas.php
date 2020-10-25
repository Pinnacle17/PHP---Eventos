<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");

    $id_usuario = $_GET['id_usuario'];

    $ventas = Venta::buscarventaUsuario($id_usuario);
    if($ventas != null){
        $numeroventas = count($ventas);
        for($x = 0; $x<$numeroventas; $x++){
            $resultado[$x]['id_venta'] = $ventas[$x]['id_venta'];
            $entrega = $ventas[$x]['estado_entrega'];
            $resultado[$x]['fec_ven'] = $ventas[$x]['fec_ven'];
            $resultado[$x]['sub_ven'] = $ventas[$x]['sub_ven'];
            $resultado[$x]['link_pago'] = $ventas[$x]['link_pago'];
            $pago = $ventas[$x]['pago'];
            
            if($entrega == 0){
                $resultado[$x]['entrega'] = "No ha sido tomado por ningun repartidor";
            }else if($entrega == 1){
                $resultado[$x]['entrega'] = "Tomado por repartidor, en proceso de entrega";
            }else{
                $resultado[$x]['entrega'] = "Entregado";
            }
        }
        echo json_encode($resultado);
    }else{
        echo json_encode(null);
    }

?>