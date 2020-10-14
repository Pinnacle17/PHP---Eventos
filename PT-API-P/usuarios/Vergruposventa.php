<?php
    require("../headers.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseEvento.php");
    $id_venta = "";
    $ventas = Venta::buscarelementosventa($id_venta);
    if($ventas == null){
        $numeroventas = count($ventas);
        $numerodeeventos = 0;
        $evento = null;
        for($x = 0; $x<$numeroventas; $x++){
            $boleto = Boleto::obtenerInfoBoleto($ventas[$x]['fk_boletoele']);
            while ($while = mysqli_fetch_array($boleto)){
                $evento_actual = $while["fk_evento_bol"];
            }
            if(isset($evento)){
                $encontrado = 0;
                for($x = 0; $x<$numerodeeventos; $x++){
                    $y = $evento[$x]['id'] - $evento_actual;
                    if($y==0){
                        $encontrado = 1;
                        break;
                    }
                }
                if($encontrado == 0){
                    $evento[$numerodeeventos]['id'] = $evento_actual;
                    $numerodeeventos++;   
                }
            }else{
                $evento[$numerodeeventos]['id'] = $evento_actual;
                $numerodeeventos++;  
            }
        }
        for($z = 0; $z<$numerodeeventos; $z++){
            $datoseve = Evento::obtenerDatosEvento($evento[$z]['id']);
            $evento[$z]['nombre_evento']=$datoseve['nombre_evento'];
            $evento[$z]['enlace']=$datoseve['enlace_evento'];
        }
        return $evento;//retorna datos del evento para los enlaces
    }else{
        $mensaje = "No hay elementos registrados";
        return $mensaje;
    }
?>