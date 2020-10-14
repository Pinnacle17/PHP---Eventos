<?php

class Usuario extends BD{
        
    public static function Iniciodesesion($correo, $contraseña, $tipo){
        $consulta = "SELECT id_usuario, tipo_usuario, contrasena, activo FROM usuario WHERE correo = '$correo' AND tipo_usuario = '$tipo'";
        $resultado = self::consultaSelect($consulta);
        if(mysqli_num_rows($resultado) > 0){
            while ($while = mysqli_fetch_array($resultado)){
                $id_usuario = $while['id_usuario'];
                $tipo_usuario = $while['tipo_usuario'];
                $contra = $while['contrasena'];
                $activo = $while['activo'];
            }
            if(password_verify($contraseña, $contra)){
                $response = array();
                $response['id_usuario'] = $id_usuario;
                $response['tipo_usuario'] = $tipo_usuario;
                $response['activo'] = $activo;
                $response['estado'] = 1;

                return $response;
            }
            else{
                $response = array();
                $response['estado'] = 0;

                return $response;                
            }
        }else{
            $response = array();
            $response['estado'] = -1;

            return $response;                
        }
    }

    public static function Edad($id_usuario){
        $resultado = self::InfoUsuario($id_usuario);
        while ($while = mysqli_fetch_array($resultado)){
            $nacimiento = $while["fec_nac"];
        }
        $cumpleanos = new DateTime($nacimiento);
        $hoy = new DateTime();
        $annos = $hoy->diff($cumpleanos);
        return $annos->y;

    }
    public static function InfoUsuario($id_usuario){
        $consulta = "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'";
        $resultado = BD::consultaSelect($consulta);
        return $resultado;
    }

    public static function DatosUsuario($id_usuario){
        $resultado = Usuario::InfoUsuario($id_usuario);
        if(mysqli_num_rows($resultado) == 1){
            while ($while = mysqli_fetch_array($resultado)){
                $usuario['id_usuario'] = $while['id_usuario'];
                $usuario['nombre'] = $while['nombre'];
                $usuario['nombre_busqueda'] = $while['nombre_busqueda'];
                $usuario['foto'] = $while['foto'];
                $usuario['celular'] = $while['celular'];
                $usuario['celular_ext'] = $while['celular_ext'];
                $usuario['fec_nac'] = $while['fec_nac'];
                $usuario['fec_cre_usu'] = $while['fec_cre_usu'];
            }
        }else{
            $usuario = null;
        }
        return $usuario;
    }
    public static function NombreUsuario($id_usuario){
        $consulta = "SELECT nombre FROM usuario WHERE id_usuario = '$id_usuario'";
        $resultado = BD::consultaSelect($consulta);
        if(mysqli_num_rows($resultado) == 1){
            while ($while = mysqli_fetch_array($resultado)){
                $usuario= $while['nombre'];
            }
        }else{
            $usuario = null;
        }
        return $usuario;
    }
    public static function ComprobarComentario($id_usuario, $id_evento){
        $consulta = "SELECT *FROM calificacion WHERE fk_usuario_cal = '$id_usuario' AND fk_evento_cal = '$id_evento'";
        $resultado = BD::consultaSelect($consulta);
        if(mysqli_num_rows($resultado) == 1){
            while ($while = mysqli_fetch_array($resultado)){
                $comentario['id_calificacion'] = $while['id_calificacion'];
                $comentario['opinion'] = $while['opinion'];
                $comentario['num_calificacion'] = $while['num_calificacion'];
                $comentario['estado_cal'] = $while['estado_cal'];
            }
        }else{
            $comentario = null;
        }
        return $comentario;
    }
    public static function EliminarComentario($id_comentario){
        $consulta = "DELETE *FROM calificacion WHERE id_calificacion = '$id_comentario'";
        $resultado = BD::consultaSelect($consulta);
        return $resultado;
    }
    
}
?>