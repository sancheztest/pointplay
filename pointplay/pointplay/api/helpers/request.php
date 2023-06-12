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
