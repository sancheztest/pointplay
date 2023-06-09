<?php

require 'helpers/database.php';
require 'config/config.php';


$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);

$config = getConfig();
$conn = getConnection($config);

$uri = $_SERVER['REQUEST_URI'];
$paths = explode('/', $uri);
$action = "";
array_shift($paths);

if (count($paths) >= 4) {
    $action = $paths[3];
}


switch ($method) {
    case 'POST':
        include 'controllers/coupons.php';

        switch ($action) {
            case 'buy':
                echo 'jjj';
                BuyCoupons($conn, $body);
                break;
            case 'spend':
                spendCoupon($conn);
                break;
            case 'get':
                getCoupons($conn);
                break;

            default:
                echo 'Method Not Allowed';
                break;
        }

        break;

    default:
        echo 'Method Not Allowed';
        break;
}
