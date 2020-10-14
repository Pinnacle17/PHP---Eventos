<?php

    class Boleto extends BD{

        public static function obtenerNombreBoleto($id_boleto){
            $consulta = "SELECT nom_bol FROM boleto WHERE id_boleto = '$id_boleto'";
            $resultado = self::consultaSelect($consulta);
            while ($while = mysqli_fetch_array($resultado)){
                $nombre = $while["nom_bol"];
            }
            return $nombre;
        }

        public static function obtenerIdBoleto($nom_bol){
            $consulta = "SELECT id_boleto FROM boleto WHERE nom_bol = '$nom_bol'";
            $resultado = self::consultaSelect($consulta);
            while ($while = mysqli_fetch_array($resultado)){
                $id_boleto = $while["id_boleto"];
            }
            return $id_boleto;
        }
        public static function obtenerIdBoletoEvento($id_evento){
            $consulta = "SELECT * FROM boleto WHERE fk_evento_bol= '$id_evento'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }
        public static function obtenerPromo_fecBoleto($id_boleto){
            $fecha = date("Y-m-d");
            $consulta = "SELECT * FROM promo_fec WHERE fk_boleto_fec= '$id_boleto AND fec_ini_pro>= '$fecha' AND fec_fin_pro<= '$fecha' AND estado_promo = '1'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function UpdatePrecioBoleto($precio_bol, $id_boleto){
            $consulta = "UPDATE boleto SET precio_actual_boleto = '$precio_bol' WHERE id_boleto = '$id_boleto'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function ConsultaPromoRelacionado($id_promo_eve, $precio_promo, $cantidad_boletos){
            $consulta = "SELECT * FROM promo_eve WHERE  id_promo_eve = '$id_promo_eve' AND precio_eve = '$precio_promo' AND cantidad_act_eve >= '$cantidad_boletos' AND estado_promo = '1'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function ComprobarHistorial($id_usuario,$id_venta){
            $consulta = "SELECT * FROM venta WHERE fk_usuario_ven = '$id_usuario' AND id_venta = '$id_venta'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function ConsultaPromoCodigo($id_codigo, $cantidad, $precio){
            $consulta = "SELECT * FROM promo_cod WHERE id_pro_cod = '$id_codigo' AND estado_promo = 1";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function EstadoBoleto($id_boleto){
            $consulta = "SELECT * FROM boleto WHERE id_boleto = '$id_boleto' AND stock_boleto <= '0'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) == 1){
                $resultado = self::UpdateEstadoBoleto($id_boleto, 0);
            }
            $consulta2 = "SELECT * FROM boleto WHERE id_boleto = '$id_boleto' AND stock_boleto > '0' AND estado_boleto = '0'";
            $resultado2 = BD::consultaSelect($consulta2);
            if(mysqli_num_rows($resultado) == 1){
                $resultado2 = self::UpdateEstadoBoleto($id_boleto, 1);
            }
        }
        public static function UpdateEstadoBoleto($id_boleto, $estado){
            $consulta = "UPDATE boleto SET estado_boleto = '$estado' WHERE id_boleto = '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }
        public static function obtenerInfoBoleto($id_boleto){
            $consulta = "SELECT * FROM boleto WHERE id_boleto= '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }

        public static function UpdateStockBoleto($id_boleto, $cantidad_boletos){
            $consulta = Boleto::obtenerInfoBoleto($id_boleto);
            while ($while = mysqli_fetch_array($consulta)){
                $stock_act_boleto = $while["stock_act_boleto"];
            }
            $stock_act_boleto = $stock_act_boleto - $cantidad_boletos;
            $update_stock = "UPDATE boleto SET stock_act_boleto = '$stock_act_boleto' WHERE id_boleto = '$id_boleto'";
            BD::consultaSelect($update_stock);
        }
        public static function ObtenerElementoVenta($id_boleto, $id_venta){
            $consulta = "SELECT * FROM ele_ven WHERE fk_boletoele = '$id_boleto' AND fk_ventaele='$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }

        public static function obtenerDatosBoleto($id_boleto){
            $consulta = "SELECT *FROM boleto WHERE id_boleto= '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado)==1){
                while ($while = mysqli_fetch_array($resultado)){
                    $boleto["id_boleto"] = $while["id_boleto"];
                    $boleto["nom_bol"] = $while["nom_bol"];
                    $boleto["fk_evento_bol"] = $while["fk_evento_bol"];  
                    $boleto["precio_actual_boleto"] = $while["precio_actual_boleto"];
                    $boleto["stock_act_boleto"] = $while["stock_act_boleto"]; 
                }
            }else{
                $boleto = null; 
            }
            return $boleto;
        }
        public static function obtenerNombreDescripcionBoleto($id_boleto){
            $consulta = "SELECT nom_bol, descripcion_boleto FROM boleto WHERE id_boleto = '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
            while ($while = mysqli_fetch_array($resultado)){
                $final['nombre'] = $while["nom_bol"];
                $final['descripcion_boleto'] = $while["descripcion_boleto"];
            }
            return $final;
        }
        
    }
?>