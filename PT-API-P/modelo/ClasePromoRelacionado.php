<?php
    class PromoRelacionado extends Boleto{

        public static function buscarpromocion($fk_boleto_eve, $fk_boleto_ref){
            $consulta = "SELECT estado_promo FROM promo_eve WHERE fk_boleto_eve = '$fk_boleto_eve' AND fk_boleto_ref = '$fk_boleto_ref'";
            $resultadoestado = self::consultaSelect($consulta);

            if(mysqli_num_rows($resultadoestado) >= 1){
                while ($while = mysqli_fetch_array($resultadoestado)){
                    $promocion["estado"] = $while["estado_promo"];
                }
                if($promocion["estado"] == 0){
                    return 2;
                }else{
                    $consulta = "SELECT id_promo_eve, precio_eve, estado_promo, cantidad_act_eve, fk_boleto_eve, fk_boleto_ref FROM promo_eve 
                    WHERE fk_boleto_eve = '$fk_boleto_eve' AND fk_boleto_ref = '$fk_boleto_ref'";
                    $resultado = self::consultaSelect($consulta);

                    while($while2 = mysqli_fetch_array($resultado)){
                        $promocion['precio_eve'] = $while2["precio_eve"];
                        $promocion['cantidad_act_eve'] = $while2["cantidad_act_eve"];
                        $promocion['fk_boleto_eve'] = $while2["fk_boleto_eve"];
                        $promocion['fk_boleto_ref'] = $while2["fk_boleto_ref"];
                        $promocion['id_promo_eve'] = $while2["id_promo_eve"];
                    }
                    return $promocion;
                }
            }else{
                return 3;
            }
        }
        
        public static function UpdateStockpromoRelacionado($id_promobol, $cantidad_bol){
            $promocion = PromoRelacionado::buscarpromocionid($id_promobol);
            while($while_promocion = mysqli_fetch_array($promocion)){
                $cantidad_act_fec = $while_promocion["cantidad_act_eve"];
            }
            $cantidad_act_fec = $cantidad_act_fec - $cantidad_bol;
            $consulta = "UPDATE promo_eve SET cantidad_act_eve = '$cantidad_act_fec' WHERE id_promo_eve = '$id_promobol'";
            BD::consultaSelect($consulta);
        }
        
        public static function buscarpromocionid($id_promo_eve){
            $consulta = "SELECT *FROM promo_eve WHERE id_promo_eve = '$id_promo_eve'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }
    }
?>