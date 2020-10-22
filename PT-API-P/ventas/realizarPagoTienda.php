<?php
    require('../headers.php');
    require('../conexion.php');
    require_once('../../vendor/autoload.php');

    $conexion = conexion();

    class Result {}
    $response = new Result();

    $nombre_usuario = mysqli_real_escape_string($conexion,$_POST['firstName']);
    $apellido_usuario = mysqli_real_escape_string($conexion,$_POST['lastName']);
    $correo = mysqli_real_escape_string($conexion,$_POST['correo']);
    $celular = mysqli_real_escape_string($conexion,$_POST['celular']);
    $id = mysqli_real_escape_string($conexion,$_POST['id_usuario']);
    
    $total = mysqli_real_escape_string($conexion,$_GET['total']);
    $fecha_limite = mysqli_real_escape_string($conexion,$_GET['fecha']);
    $order_id = mysqli_real_escape_string($conexion,$_GET['id_venta']);

    Openpay::setId('m1pu00vqwwcbxnrranoc');
    Openpay::setApiKey('sk_1152adfcc54c446ab713011e529ff1af');
    $openpay = Openpay::getInstance('m1pu00vqwwcbxnrranoc', 'sk_1152adfcc54c446ab713011e529ff1af', 'MX');

    $findDataRequest = array(
        'external_id' => strval($id)
    );
    $customerList = $openpay->customers->getList($findDataRequest);

    $customer = $customerList[0];
    $cargoInfo = array(
        'order_id' => $order_id,
        'method' => 'store',
        'amount' => $total,
        'description' => 'Cargo a tienda');
        
    $cargo = $customer->charges->create($cargoInfo);

    $recibo = "https://sandbox-dashboard.openpay.mx/paynet-pdf/"."m1pu00vqwwcbxnrranoc"."/".$cargo->serializableData['payment_method']->reference;

    $consulta = "UPDATE venta SET link_pago = '$recibo' WHERE id_venta = '$order_id'";
    mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));
    

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response); 
?>