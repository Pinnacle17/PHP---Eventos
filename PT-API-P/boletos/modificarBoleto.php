<?php
    require("../headers.php");
    require("../conexion.php"); 
    require("../BD.php");
    require("../modelo/ClaseBoleto.php"); 
    $conexion = conexion();
    $error = 0;
    $id_boleto = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['desc']);
    $inventario = mysqli_real_escape_string($conexion, $_POST['inventario']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    
    $consulta2 = "SELECT stock_boleto, stock_act_boleto, stock_repartidor FROM boleto WHERE id_boleto = '$id_boleto'";
    $registro2 = mysqli_query($conexion,$consulta2) or die(mysqli_error($conexion));  
    while ($resultado = mysqli_fetch_array($registro2)){
        $stock_boleto = $resultado['stock_boleto'];
        $stock_act_boleto = $resultado['stock_act_boleto'];
        $stock_repartidor = $resultado['stock_repartidor'];
    }
    $stock_repartidor = $stock_repartidor + $inventario;
    $stock_act_boleto = $stock_act_boleto + $inventario;
    $stock_boleto = $stock_boleto + $inventario;

    if($stock_repartidor < 0){
        $error = 1;
        $stock_repartidor = $stock_repartidor * (-1);
        $mensaje = "Se excede por ".$stock_repartidor." boletos del stock referente al repartidor";
    }
    if($stock_act_boleto < 0){
        $error = 1;
        $stock_act_boleto = $stock_act_boleto * (-1);
        $mensaje = "Se excede por ".$stock_act_boleto." boletos del stock referente a las ventas";
    }
    if($error == 0){
        $consulta = "UPDATE boleto SET nom_bol = '$nombre', descripcion_boleto = '$descripcion', stock_boleto = '$stock_boleto', stock_act_boleto = '$stock_act_boleto', stock_repartidor = '$stock_repartidor', precio_bol = '$precio', precio_actual_boleto= '$precio' WHERE id_boleto = '$id_boleto'";
        $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));   
        Boleto::EstadoBoleto($id_boleto);
    }
    class Result {}

    $response = new Result();
  
    if(){ 
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>