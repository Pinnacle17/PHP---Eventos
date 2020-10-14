<?php
    require("../headers.php");
    require("../conexion.php"); 
    require("../BD.php");
    require("../modelo/ClaseBoleto.php"); 
    $conexion = conexion();

    $id_boleto = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['desc']);
    $inventario = mysqli_real_escape_string($conexion, $_POST['inventario']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    
    $consulta = "UPDATE boleto SET nom_bol = '$nombre', descripcion_boleto = '$descripcion', stock_boleto = '$inventario', stock_act_boleto = '$inventario', stock_repartidor = '$inventario', precio_bol = '$precio', precio_actual_boleto= '$precio' WHERE id_boleto = '$id_boleto'";
    $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));   
    Boleto::EstadoBoleto($id_boleto);
    class Result {}

    $response = new Result();
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>