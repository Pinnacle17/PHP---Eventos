<?php

    require('../headers.php');
    require('../conexion.php');
    require_once('C:/Users/dario/Desktop/Nachoproyecto/vendor/autoload.php');

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

    Openpay::setId('m1pu00vqwwcbxnrranoc');
    Openpay::setApiKey('sk_1152adfcc54c446ab713011e529ff1af');
    $openpay = Openpay::getInstance('m1pu00vqwwcbxnrranoc', 'sk_1152adfcc54c446ab713011e529ff1af', 'MX');

    $customerData = array(
        'external_id' => $id,
        'name' => $nombre_usuario,
        'last_name' => $apellido_usuario,
        'email' => $correo,
        'phone_number' => $celular);
    
    $customer = $openpay->customers->add($customerData);

    $cargoInfo = array(
        'method' => 'store',
        'amount' => $total,
        'description' => 'Cargo a tienda',
        'customer' => $customer->serializableData);
        
    $cargo = $openpay->charges->create($cargoInfo);

    $recibo = "https://sandbox-dashboard.openpay.mx/paynet-pdf/"."m1pu00vqwwcbxnrranoc"."/".$cargo->serializableData['payment_method']->reference;

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
        $response->recibo = $recibo;
    }
    echo json_encode($response); 
?>