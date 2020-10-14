<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $conexion = conexion();

    $id_venta = $_GET['id_venta'];
    $id_usuario = $_GET['id_repartidor'];

    class Result {}
    $response = new Result();

    $venta2 = Venta::buscarelementosventa($id_venta);
    $stockrepartidor = Repartidor::StockUsuario($id_usuario);
    $elementosventa = count($venta2);
    $t = 0;
    $i = 0;
        $numstockrepartidor = count($stockrepartidor);
        $venta3[$t]["cantidad_bol"] = $venta2[0]["cantidad_bol"];
        for($x = 0; $x < $elementosventa; $x++){
            if(empty($venta2[$x]["revisado"])){
             for($y = $x+1; $y < $elementosventa; $y++){
                if($i == 0){
                      $i = 1;
                      $venta2[$t]["cantidad_bol"] = $venta2[$x]["cantidad_bol"];
                      $venta2[$t]["fk_boletoele"] = $venta2[$x]["fk_boletoele"];
                      $venta2[$x]["revisado"] = true;
                      $venta2[$x]["revisado"] = 1;
                }
              if(($venta2[$x]["fk_boletoele"] == $venta2[$y]["fk_boletoele"]) && (empty($venta2[$y]["revisado"]))){
                  $venta2[$y]["revisado"] = 1;
                  $venta2[$t]["cantidad_bol"] = $venta2[$t]["cantidad_bol"] + $venta2[$y]["cantidad_bol"];
              }  
            }
            $i = 0;
            for($z = 0; $z < $numstockrepartidor; $z++){
                if($stockrepartidor[$z]['fk_boleto'] == $venta2[$t]["fk_boletoele"]){
                    $venta2[$t]["cantidad_bol"] = $stockrepartidor[$z]["stock_adm_act"] + $venta2[$t]["cantidad_bol"];
                }
            }
            Repartidor::UpdateStockUsuario($venta2[$t]["cantidad_bol"], $venta2[$t]['fk_boletoele'], $id_usuario);
            $t++;
            }
        }

    Repartidor::EliminarRegistroEntrega($id_venta, $id_usuario);
    Repartidor::UpdateEstadoEntregaVenta($id_venta, 0);

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response);

?>