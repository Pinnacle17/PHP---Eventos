<?php
    //este codigo lo que hace es revisar que el stock y precio de la promocion no sean mayores a el precio y stock de el boleto al que se le quiere hacer la promocion

    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");

    $conexion = conexion();

    class Result {}
    $response = new Result();

    $stock = mysqli_real_escape_string($conexion, $_GET['inventario']);
    $precio = mysqli_real_escape_string($conexion, $_GET['precio']);
    $id_boleto = mysqli_real_escape_string($conexion, $_GET['id']);

    $consulta = Boleto::obtenerInfoBoleto($id_boleto);
    while ($while = mysqli_fetch_array($consulta)){
        $stock_act_boleto = $while["stock_act_boleto"];
        $precio_bol = $while["precio_bol"];
    }
    $stock = $stock_act_boleto - $stock;
    if($stock < 0){
        $stock = $stock * (-1);
        $response->mensaje = "Hay un excedente de ".$stock." boletos en la promocion";
        $response->estado = 0;
    }else if($precio > $precio_bol){
        $response->mensaje = "El precio que hay en la promocion es mayor a la del boleto";
        $response->estado = 0;
    }
    else{
        $response->estado = 1;
    }
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>