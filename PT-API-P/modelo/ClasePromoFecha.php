<?php

    class PromoFecha extends Boleto{

        public static function buscarpromocion($id_boleto){
            $dia = date("Y-m-d");
          $consulta = "SELECT * FROM promo_fec WHERE fec_ini_pro >= '$dia' AND fec_fin_pro <= '$dia' AND fk_boleto_fec = '$id_boleto' AND estado_promo = '1'"; 
          $resultado = BD::consultaSelect($consulta); 
          return $resultado;
        }
        public static function UpdateStockPromoFec($id_promo, $stock){
            $cosulta = "UPDATE promo_fec SET cantidad_act_fec = '$stock' WHERE id_promo_fec = '$id_promo'"; 
            $resultado = BD::consultaSelect($consulta);
            self::CronPromoFec(); 
            return $resultado;
        }
        public static function CronPromoFec(){
            $cosulta = "UPDATE promo_fec SET estado_promo = '1' WHERE cantidad_act_fec > '0'"; 
            $resultado = BD::consultaSelect($consulta); 
            $cosulta = "UPDATE promo_fec SET estado_promo = '0' WHERE cantidad_act_fec <= '0'"; 
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }
    }
?>