<?php

    class Evento extends BD{

        public static function UpdatePrecioEvento($precio_bol, $id_evento){
            $consulta = "UPDATE evento SET precio_eve = '$precio_bol' WHERE id_evento = '$id_evento'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function obtenerFechaEvento($estado){
            $consulta = "SELECT *FROM evento WHERE estado_evento = '$estado'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }
        public static function UpdateEstadoEvento($id_evento, $estado){
            $consulta = "UPDATE evento SET estado_evento = '$estado' WHERE id_evento = '$id_evento'";
            $resultado = self::consultaSelect($consulta);
            return $resultado;
        }

        public static function obtenerDatosEvento($id_evento){
            $consulta = "SELECT *FROM evento WHERE id_evento= '$id_evento'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado)==1){
                while ($while = mysqli_fetch_array($resultado)){
                    $evento["id_evento"] = $while["id_evento"];
                    $evento["nombre_evento"] = $while["nombre_evento"];
                    $evento["nombre_evento_busqueda"] = $while["nombre_evento_busqueda"];
                    $evento["calificacion_evento"] = $while["calificacion_evento"];
                    $evento["enlace_evento"] = $while["enlace_evento"];
                    $evento["estado_evento"] = $while["estado_evento"];
                }
            }else{
                $evento = null; 
            }
            return $evento;
        }
        public static function DiaSemanaEvento($fecha){
            $array_dias['Sunday'] = "Domingo";
            $array_dias['Monday'] = "Lunes";
            $array_dias['Tuesday'] = "Martes";
            $array_dias['Wednesday'] = "Miercoles";
            $array_dias['Thursday'] = "Jueves";
            $array_dias['Friday'] = "Viernes";
            $array_dias['Saturday'] = "Sabado";
            return $array_dias[date('l', strtotime($fecha))];
        }
        public static function VerComentarios($id_evento){
            $consulta = "SELECT * FROM calificacion WHERE fk_evento_cal= '$id_evento' AND estado_cal = '1'";
            $resultado = BD::consultaSelect($consulta);
            if(mysqli_num_rows($resultado) >=1){
                $elementos = 0;
                while ($while = mysqli_fetch_array($resultado)){
                    $comentario[$elementos]["id_calificacion"] = $while["id_calificacion"];
                    $comentario[$elementos]["opinion"] = $while["opinion"];
                    $comentario[$elementos]["num_calificacion"] = $while["num_calificacion"];
                    $comentario[$elementos]["estado_cal"] = $while["estado_cal"];
                    $comentario[$elementos]["fk_evento_cal"] = $while["fk_evento_cal"];
                    $comentario[$elementos]["fk_usuario_cal"] = $while["fk_usuario_cal"]; 
                    ++$elementos;
                }
            }else{
                $comentario = null; 
            }
            return $comentario;
        }
        public static function UpdateEstadoComentarios($id_comentario, $estado){
            $consulta = "UPDATE calificacion SET estado_cal = '$estado' WHERE id_calificacion= '$id_comentario'";
            $resultado = BD::consultaSelect($consulta);
            return $resultado;
        }


    }
?>