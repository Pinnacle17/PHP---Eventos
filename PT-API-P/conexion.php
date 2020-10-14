<?php

  function conexion() {

    $dbServername = "localhost";
    $dbUsuario = "u432981095_root";
    $dbContra = "9=OgaJoPsc";
    $dbName = "u432981095_viajes";
    
    $conexion = mysqli_connect($dbServername, $dbUsuario, $dbContra, $dbName);
    mysqli_set_charset($conexion,'utf8');
    
    return $conexion;
    
  }

?>