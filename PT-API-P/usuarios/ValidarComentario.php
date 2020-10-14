<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");

    $id_usuario = $_GET['id_usuario'];
    $id_evento = $_GET['id_evento'];

    // $id_usuario = 40;
    // $id_evento = 167;

    class Result {}
    $response = new Result();

    $ventas = Venta::buscarventaUsuario($id_usuario);
    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    
    $numerodeboletos = 0;
    while ($while = mysqli_fetch_array($boletos)){
        $id_boletos[$numerodeboletos]["id_boleto"] = $while["id_boleto"];
        $numerodeboletos++;
    }
    $validado = 0;
    $numerodeventas = count($ventas);
    
    for($y = 0; $y<$numerodeventas; $y++){
        if($ventas[$y]['pago']==1){
            $elementosVenta = Venta::buscarelementosventa($ventas[$y]["id_venta"]);
            if($elementosVenta != null){           
                $numerodeelementosVenta = count($elementosVenta);
                for($z = 0; $z<$numerodeelementosVenta; $z++){
                    for($x = 0;$x<$numerodeboletos;$x++){   

                        if($elementosVenta[$z]['fk_boletoele'] == $id_boletos[$x]["id_boleto"]){
                            $validado = 1;
                            break;
                        }
                    }
                }
                if($validado == 1){
                    break;
                }
            }
        }
        if($validado == 1){
            break;
        }
    }
    if($validado == 1){
        $response->estado = 1;
    }else{
        $response->estado = 0;
    }

    echo json_encode($response);
?>