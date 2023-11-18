<?php

header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

require('api.php');

$api = new Api();
$act = $_GET['act'];

if ($act === 'createUser') { 
    $phone = $_GET['phone'];
    $name = $_GET['name'];
    $password = $_GET['password'];
    echo json_encode( $api->createUser($phone, $name, $password) );
} elseif ($act === 'getUser') { 
    $phone = $_GET['phone'];
    echo json_encode( $api->getUser($phone) );
} 
elseif ($act === 'validateUser') { 
    $phone = $_GET['phone'];
    $password = $_GET['password'];
    echo json_encode( $api->validateUser($phone, $password) );
} 
elseif ($act === 'money') { 
    $phone = $_GET['phone'];
    echo json_encode( $api->money($phone) );
} 
elseif ($act === 'deposit') { 
    $phone = $_GET['phone'];
    $money = $_GET['money'];
    echo json_encode( $api->deposit($phone, $money) );
} 
elseif ($act === 'withdraw') { 
    $phone = $_GET['phone'];
    $money = $_GET['money'];
    echo json_encode( $api->withdraw($phone, $money) );
} 
elseif ($act === 'transfer') { 
    $sender = $_GET['sender'];
    $reciever = $_GET['reciever'];
    $money = $_GET['money'];
    echo json_encode( $api->transfer($sender, $reciever, $money) );
} 
elseif ($act === 'getTransferences') { 
    $phone = $_GET['phone'];
    echo json_encode( $api->getTransferences($phone) );
} 
else {
    $respuesta = "Acción no válida";
}


