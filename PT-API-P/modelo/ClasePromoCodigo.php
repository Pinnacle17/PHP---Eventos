<?php

    class PromoCodigo extends Boleto{

        public static function UpdateStockpromoCodigo($id_promobol, $cantidad_bol){
            $promocod = self::idpromoCodigo($id_promobol);
            while($while_promocod  = mysqli_fetch_array($promocod)){
                $cantidad_act_cod = $while_promocod ["cantidad_act_cod"];
            }
            $cantidad_act_cod = $cantidad_act_cod - $cantidad_bol;

            $consulta = "UPDATE promo_cod SET cantidad_act_cod = '$cantidad_act_cod' WHERE id_pro_cod = '$id_promobol'";
            BD::consultaSelect($consulta);
        }
        public static function idpromoCodigo($id_promo){
            $consulta = "SELECT *FROM promo_cod WHERE id_pro_cod = '$id_promo'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }

    }
?>