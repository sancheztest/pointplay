<?php

function executeRequest($url, $method = 'GET', $headers = [], $data = [])
{
    return [
        'url' => $url
    ];
    // Inicializar el objeto cURL
    // $curl = curl_init();

    // // Establecer la URL y otras opciones
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // // Agregar datos en caso de que el método sea POST o PUT
    // if ($method === 'POST' || $method === 'PUT') {
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    // }

    // echo 'cojone';
    // return '';
    // Ejecutar la petición y obtener la respuesta

    // $response = curl_exec($curl);

    // Verificar si ocurrió algún error durante la petición
    // if ($response === false) {
    //     $error = curl_error($curl);
    //     curl_close($curl);
    //     throw new Exception("Error al consumir la API: " . $error);
    // }

    // Obtener el código de respuesta HTTP
    // $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    // echo json_encode([
    //     'response'=> $response,
    //     'status'=> $statusCode
    // ]);

    // Cerrar la conexión cURL
    // curl_close($curl);

    // Retornar la respuesta como un arreglo asociativo
    // $responseData = json_decode($response, true);

    // Verificar si la respuesta es válida
    // if ($statusCode >= 200 && $statusCode < 300) {
    //     return $responseData;
    // } else {
    //     throw new Exception("La API respondió con un código de error: " . $statusCode);
    // }
}


function GetUserBalance($conn)
{
    $sql = "SELECT * FROM user_balance";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    echo json_encode($info);
}
function getPurchasePlans($conn)
{
    $sql = "SELECT * FROM purchase_plans";
    $result = $conn->query($sql);
    $conn->close();

    $coupons = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coupons[] = $row;
        }
    } else {
        echo "0 results";
    }

    echo json_encode($coupons);
}
function BuyCoupons($conn, $body)
{
    $coupon_id = $body['id'];
    $token = $body['token'];

    $token_id = $token["id"];
    $email = $token["email"];


    $sql = "SELECT * FROM purchase_plans where id =" . $coupon_id;
    $result = $conn->query($sql);
    $coupon = $result->fetch_assoc();

    $price = $coupon['price'];
    $amount = $coupon['amount'];

    $sql = "SELECT * FROM user_balance";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    $info_id = $info["id"];
    $points = $info["points"];
    $coupons = $info["coupons"];

    if ($points >= $price) {

        //Pay
        // include 'helpers/request.php';

        // try {
        $url = 'https://api.stripe.com/v1/customers';
        $method = 'POST';
        $apiKey = "pk_test_51NGVeZADGAueO9snDyMmSoCN5hjhpJnsKosLd1IVJ6MU6H4WlnoAHDiSjUA1W2cbCF8Y8KzduY5qqIGAT0z0PTFX00PV7JcuCC";

        $data = [
            'source' => $token_id,
            'email' => $email
        ];


        $curl = curl_init();

        // // Establecer la URL y otras opciones
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/jspn',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // // Agregar datos en caso de que el método sea POST o PUT
        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);
        echo json_encode($response);




        // $response = executeRequest($url, $method, $headers, $data);
        // echo json_encode($response);

        // $url = 'https://api.stripe.com/v1/charges';
        // $method = 'POST';
        // $headers = [
        //     'Authorization: Basic c2tfdGVzdF81MU5HVmV6QURHQXVlTzlzbnlDeDducXdMcHVobjZHYkVXTnhDU3ZDeFZ2ZGx1R0hwanhJanduTkVDY0RNSGkzZkp4akdGd1k2OU1GNnNjMVZCeG8wMHRXR21ESm1EOg=='
        // ];
        // $data = [
        //     'customer' => $response['id'],
        //     'amount' => $price,
        //     'currency' => 'usd',
        //     'description' => 'Buy Package ' . $coupon_id,
        // ];

        // $response = request($url, $method, $headers, $data);
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }



        //     // $points -= $price;
        //     // $coupons += $amount;

        //     // $sql = "UPDATE user_balance set points=" . $points . ", coupons=" . $coupons . " where id =" . $info_id;
        //     // $result = $conn->query($sql);
        //     // $conn->close();

        //     // if ($result == TRUE) {
        //     //     echo json_encode(['msg' => "Coupons buy successfully"]);
        //     // } else {
        //     //     echo json_encode(['msg' => "Error updating record: " . $conn->error]);
        //     // }
        // } else {
        //     $conn->close();
        //     echo json_encode(['msg' => "Insufficent Balance"]);
    }
}
function spendCoupon($conn)
{
    /*
    op: + -
    am: number
    type: coupons points
    */

    $sql = "SELECT * FROM spend_options";
    $result = $conn->query($sql);

    $options = [];

    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }

    $len = count($options);
    $rand = rand(0, $len - 1);

    $option = $options[$rand];

    $operation = $option['operation'];
    $amount = $option['amount'];
    $type = $option['type'];

    $sql = "SELECT * FROM user_balance";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    $info_id = $info["id"];
    $points = $info["points"];
    $coupons = $info["coupons"];

    $operations = [
        '+' => function ($type, $amount) {
            return $type + $amount;
        },
        '-' => function ($type, $amount) {
            return max(0, $type - $amount);
        },
    ];

    $value = $operations[$operation]($$type, $amount);
    $$type = $value;

    $sql = "UPDATE user_balance set coupons=coupons-1, " . $type . " = " . $$type . " WHERE id = " . $info_id;
    $result = $conn->query($sql);

    if ($result == TRUE) {
        $response = [
            'msg' => "Updated Successfully (" . $type . ")",
            'option' => $option
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['msg' => "Error updating record: " . $conn->error]);
    }

    $conn->close();
}
