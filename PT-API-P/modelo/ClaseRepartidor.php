<?php

    class Repartidor extends Venta{

        public static function StockUsuario($id_usuario){
            $consulta = "SELECT * FROM stock_adm WHERE fk_usuarioadm = '$id_usuario'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $stock[$elementos]["id_stock"] = $while["id_stock"];
                    $stock[$elementos]["stock_adm"] = $while["stockadm"];
                    $stock[$elementos]["stock_adm_act"] = $while["stock_adm_act"];
                    $stock[$elementos]["fk_boleto"] = $while["fk_boleto"];
                    $stock[$elementos]["fk_usuarioadm"] = $while["fk_usuarioadm"];
                    ++$elementos;
                }
            }else{
                $stock = null;
            }
            return $stock;
        }

        public static function UpdateStockUsuario($stock, $id_boleto, $id_usuario){
            $consulta = "UPDATE stock_adm SET stock_adm_act = '$stock' WHERE fk_usuarioadm = '$id_usuario' AND fk_boleto = '$id_boleto'";
            $resultado = BD::consultaSelect($consulta);
        }
        public static function CrearRegistroEntrega($id_venta, $id_usuario, $estado){
            $consulta = "INSERT INTO entrega(estado_ent, fk_usuario_ent, fk_venta_ent) VALUES ('$estado','$id_usuario','$id_venta')";
            $resultado = BD::consultaSelect($consulta);
        }
        public static function UpdateEstadoEntregaVenta($id_venta, $estado){
            $consulta = "UPDATE venta SET estado_entrega = '$estado' WHERE id_venta = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
            
        }
        public static function EliminarRegistroEntrega($id_venta, $id_usuario){
            $consulta = "DELETE FROM entrega WHERE fk_venta_ent = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
        }
        public static function UpdateRegistroEntrega($id_venta, $id_usuario, $estado){
            $consulta = "UPDATE entrega SET estado_ent = '$estado' WHERE fk_usuario_ent = '$id_usuario' AND fk_venta_ent = '$id_venta'";
            $resultado = BD::consultaSelect($consulta);
        }
        public static function VerEntregas($id_usuario, $estado){
            $consulta = "SELECT *FROM entrega WHERE fk_usuario_ent = '$id_usuario' AND estado_ent = '$estado' ORDER BY id_entrega DESC";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $entregas[$elementos]["id_entrega"] = $while["id_entrega"];
                    $entregas[$elementos]["estado_ent"] = $while["estado_ent"];
                    $entregas[$elementos]["fk_usuario_ent"] = $while["fk_usuario_ent"];
                    $entregas[$elementos]["fk_venta_ent"] = $while["fk_venta_ent"];
                    ++$elementos;
                }
            }else{
                $entregas = null;
            }
            return $entregas;
        }
        public static function HistorialStockUsuario($id_usuario){
            $consulta = "SELECT *FROM historial_cargas WHERE fk_usuarioadm = '$id_usuario'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >= 1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $stock[$elementos]["id_stock"] = $while["id_stock"];
                    $stock[$elementos]["stock_adm"] = $while["stock_adm"];
                    $stock[$elementos]["fecha_historial"] = $while["fecha_historial"];
                    $stock[$elementos]["fk_boleto"] = $while["fk_boleto"];
                    $stock[$elementos]["fk_usuarioadm"] = $while["fk_usuarioadm"];
                    ++$elementos;
                }
            }else{
                $stock = null;
            }
            return $stock;
        }
        public static function ConsultaEntrega($id_venta){
            $consulta = "SELECT *FROM entrega WHERE fk_venta_ent = '$id_venta'";
            $entregas = BD::consultaSelect($consulta);
            return $entregas;
        }
    }
?>