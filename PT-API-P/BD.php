<?php
    class BD{
        public static function DB(){
            $dbServername = "localhost";
            $dbUsuario = "u432981095_root";
            $dbContra = "9=OgaJoPsc";
            $dbName = "u432981095_viajes";

            $conexion = new mysqli($dbServername, $dbUsuario, $dbContra, $dbName);
            return $conexion;
        }
        public static function consultaSelect($consulta){
            $dbServername = "localhost";
            $dbUsuario = "u432981095_root";
            $dbContra = "9=OgaJoPsc";
            $dbName = "u432981095_viajes";
            
            $conexion = new mysqli($dbServername, $dbUsuario, $dbContra, $dbName);
            $resultado = mysqli_query($conexion, $consulta);
            return $resultado;
        }


    }
?>