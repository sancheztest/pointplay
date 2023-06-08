<?php

require 'helpers/database.php';
require 'config/config.php';


$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);

$config = getConfig();
$conn = getConnection($config);



switch ($method) {
    case 'POST':
        include 'controllers/coupons.php';
        BuyCoupons($conn, $body);
        break;
    case 'GET':
        include 'controllers/coupons.php';
        getCoupons($conn);
        break;

    default:
        echo 'Method Not Allowed';
        break;
}
