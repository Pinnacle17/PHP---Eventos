<?php
    class Venta extends Boleto{
        
        public static function elementosVenta($fk_ventaele, $id_usuario){
            $consulta_select_venta = "SELECT * FROM venta WHERE fk_usuario_ven = '$id_usuario' AND id_venta = '$fk_ventaele'";
            $resultadoventa = self::consultaSelect($consulta_select_venta);
            if(mysqli_num_rows($resultadoventa) > 0) {
                $consulta_select_eleven = "SELECT cantidad_bol, cantidad_bol_promo, promo_ven, fk_boletoele, fk_ventaele 
                FROM ele_ven WHERE fk_ventaele = '$fk_ventaele'";
                $resultadoeleven = self::consultaSelect($consulta_select_eleven);
                $x = 0;
                while ($while = mysqli_fetch_array($resultadoeleven)){
                    $elementos[$x]["cantidad_bol"] = $while["cantidad_bol"];
                    $elementos[$x]["promo_ven"] = $while["promo_ven"]; 
                    $elementos[$x]["id_boleto"] = $while["fk_boletoele"];
                    $elementos[$x]["cantidad_bol_promo"] = $while["cantidad_bol_promo"]; 
                    $x++;
                }
                return $elementos;
            }else{
                $x = 2;//retorna que no existe la compra
                return $x;
            }
        }

        public static function InsertarVenta($id_usuario, $tipo,$estado,$edad, $subtotal,$cantidad, $pago){
            $fecha = date("Y-m-d");
            $consulta_insert_venta = "INSERT INTO venta(tipo_ven, estado_entrega, edad_ven, fec_ven, sub_ven, cantidad_ven, pago, fk_usuario_ven)
            VALUES ('$tipo', '$estado', '$edad', '$fecha','$subtotal', '$cantidad', '$pago', '$id_usuario')";
            BD::consultaSelect($consulta_insert_venta);
            $consulta_select_venta = "SELECT id_venta FROM venta WHERE fec_ven = '$fecha'";
            $resultadoventa = BD::consultaSelect($consulta_select_venta);
            while ($while = mysqli_fetch_array($resultadoventa)){
                $id_venta = $while["id_venta"];    
            }
            return $id_venta;
        }
        public static function InsertarElementoVenta($cantidad_bol, $precio_bol_ven, $sub_bol, $promo_ven, $tipo_promo, $id_promobol, $id_promoven, $fk_boletoele, $fk_ventaele, $id_promobolref){
            $consulta_insert_elemento_venta = "INSERT INTO ele_ven(cantidad_bol, cantidad_bol_promo, precio_bol_ven, sub_bol, promo_ven, tipo_promo, id_promobol, id_promovenref, id_promobolref, fk_boletoele, fk_ventaele)
            VALUES ('$cantidad_bol', '$cantidad_bol' ,'$precio_bol_ven', '$sub_bol', '$promo_ven', '$tipo_promo', '$id_promobol', '$id_promoven', '$id_promobolref', '$fk_boletoele', '$fk_ventaele')";
            BD::consultaSelect($consulta_insert_elemento_venta);
        }
        public static function UpdateVenta($id_venta, $subtotal, $cantidad_bol){
            $consulta_update_venta = "UPDATE venta SET sub_ven = '$subtotal', cantidad_ven = '$cantidad_bol' WHERE id_venta = '$id_venta'";
            BD::consultaSelect($consulta_update_venta);
        }
        
        public static function UpdateStockpromoeleven($id_boleto, $cantidad_boletos, $id_venta){
            $boleto = Boleto::ObtenerElementoVenta($id_boleto, $id_venta);
            while ($while_boleto = mysqli_fetch_array($boleto)){
                $cantidad_bol_promo = $while_boleto["cantidad_bol_promo"];    
            }
            $cantidad_bol_promo = $cantidad_bol_promo - $cantidad_boletos;
            $consulta = "UPDATE ele_ven SET cantidad_bol_promo = '$cantidad_bol_promo' WHERE fk_boletoele = '$id_boleto' AND fk_ventaele = '$id_venta' AND promo_ven = '0'";
            BD::consultaSelect($consulta);
        }

        public static function buscarventa($id_venta){
            $consulta = "SELECT *FROM venta WHERE id_venta = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                while ($while = mysqli_fetch_array($resultado)){
                    $venta["id_venta"] = $while["id_venta"];
                    $venta["tipo_ven"] = $while["tipo_ven"];
                    $venta["estado_entrega"] = $while["estado_entrega"];
                    $venta["edad_ven"] = $while["edad_ven"];
                    $venta["fec_ven"] = $while["fec_ven"];
                    $venta["sub_ven"] = $while["sub_ven"];
                    $venta["cantidad_ven"] = $while["cantidad_ven"];
                    $venta["pago"] = $while["pago"];
                    $venta["fk_usuario_ven"] = $while["fk_usuario_ven"];
    
                }
                
            }else{
                $venta = null;
            }
            return $venta;
        }
        public static function buscarelementosventa($id_venta){
            $consulta = "SELECT * FROM ele_ven WHERE fk_ventaele = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elemento = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $elementoventa[$elemento]["id_ele"] = $while["id_ele"];
                    $elementoventa[$elemento]["cantidad_bol"] = $while["cantidad_bol"];
                    $elementoventa[$elemento]["cantidad_bol_promo"] = $while["cantidad_bol_promo"];
                    $elementoventa[$elemento]["precio_bol_ven"] = $while["precio_bol_ven"];
                    $elementoventa[$elemento]["sub_bol"] = $while["sub_bol"];
                    $elementoventa[$elemento]["promo_ven"] = $while["promo_ven"];
                    $elementoventa[$elemento]["id_promovenref"] = $while["id_promovenref"];
                    $elementoventa[$elemento]["id_promobolref"] = $while["id_promobolref"];
                    $elementoventa[$elemento]["tipo_promo"] = $while["tipo_promo"];
                    $elementoventa[$elemento]["id_promobol"] = $while["id_promobol"];
                    $elementoventa[$elemento]["fk_boletoele"] = $while["fk_boletoele"];
                    $elementoventa[$elemento]["fk_ventaele"] = $while["fk_ventaele"];
                    $elemento++;
                }
                
            }else{
                $elementoventa = null; 
            }
            return $elementoventa;
        }

        public static function buscarventaUsuario($id_usuario){
            $consulta = "SELECT *FROM venta WHERE fk_usuario_ven = '$id_usuario' ORDER BY fec_ven DESC";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $venta[$elementos]["id_venta"] = $while["id_venta"];
                    $venta[$elementos]["link_pago"] = $while["link_pago"];
                    $venta[$elementos]["tipo_ven"] = $while["tipo_ven"];
                    $venta[$elementos]["estado_entrega"] = $while["estado_entrega"];
                    $venta[$elementos]["edad_ven"] = $while["edad_ven"];
                    $venta[$elementos]["fec_ven"] = $while["fec_ven"];
                    $venta[$elementos]["sub_ven"] = $while["sub_ven"];
                    $venta[$elementos]["cantidad_ven"] = $while["cantidad_ven"];
                    $venta[$elementos]["pago"] = $while["pago"];
                    $venta[$elementos]["fk_usuario_ven"] = $while["fk_usuario_ven"];
                    $elementos++;
                }
            }else{
                $venta = null;
            }
            return $venta;
        }
        public static function buscarelementosventaboleto($id_boleto){
            $consulta = "SELECT * FROM ele_ven WHERE fk_boletoele = '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elemento = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $elementoventa[$elemento]["cantidad_bol"] = $while["cantidad_bol"];
                    $elementoventa[$elemento]["precio_bol_ven"] = $while["precio_bol_ven"];
                    $elementoventa[$elemento]["sub_bol"] = $while["sub_bol"];
                    $elementoventa[$elemento]["fk_ventaele"] = $while["fk_ventaele"];
                    $elemento++;
                }
                
            }else{
                $elementoventa = null; 
            }
            return $elementoventa;
        }
        public static function Edadventa($id_venta){
            $consulta = "SELECT *FROM venta WHERE id_venta = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                while ($while = mysqli_fetch_array($resultado)){
                    $venta["edad_ven"] = $while["edad_ven"];
                }
            }else{
                $venta = null;
            }
            return $venta;
        }
        public static function buscarelementosventaboletofecha($id_boleto, $id_venta){
            $consulta = "SELECT * FROM ele_ven WHERE fk_boletoele = '$id_boleto' AND fk_ventaele = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elemento = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $elementoventa[$elemento]["cantidad_bol"] = $while["cantidad_bol"];
                    $elementoventa[$elemento]["precio_bol_ven"] = $while["precio_bol_ven"];
                    $elementoventa[$elemento]["sub_bol"] = $while["sub_bol"];
                    $elementoventa[$elemento]["fk_ventaele"] = $while["fk_ventaele"];
                    $elemento++;
                }
            }else{
                $elementoventa = null; 
            }
            return $elementoventa;
        }

        public static function Fechaventa($fecha){
            $consulta = "SELECT *FROM venta WHERE fec_ven = '$fecha'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $venta[$elementos]["id_venta"] = $while["id_venta"];
                    $venta[$elementos]["pago"] = $while["pago"];
                    $elementos++;
                }
            }else{
                $venta = null;
            }
            return $venta;
        }
        
        public static function FechaventaRango($fechainicio, $fechafin){
            $consulta = "SELECT * FROM venta WHERE fec_ven >= '$fechainicio' AND fec_ven <= '$fechafin'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $venta[$elementos]["id_venta"] = $while["id_venta"];
                    $venta[$elementos]["pago"] = $while["pago"];
                    $elementos++;
                }
            }else{
                $venta = null;
            }
            return $venta;
        }
    }
?>