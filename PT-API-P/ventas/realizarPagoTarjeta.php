<?php
    require('../headers.php');
    require('../conexion.php');
    require_once('../../vendor/autoload.php');

    $conexion = conexion();

    class Result {}
    $response = new Result();

    $id = mysqli_real_escape_string($conexion,$_GET['id_usuario']);
    $total = mysqli_real_escape_string($conexion,$_GET['total']);
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
        'method' => 'card',
        'amount' => $total,
        'description' => 'Cargo a terminal virtual',
        'confirm' => false,
        'redirect_url' => 'https://proyectotapatio.com/#/historial');
        
    $cargo = $customer->charges->create($cargoInfo);

    $url = $cargo->payment_method->url;

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
        $response->url = $url;
    }
    echo json_encode($response); 
?>