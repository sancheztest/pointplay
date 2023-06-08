<?php

require 'helpers/database.php';
require 'config/config.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);

$config = getConfig();
$conn = getConnection($config);



switch ($method) {
    case 'GET':
        include 'controllers/game.php';
        GetInfo($conn);
        
        break;

    default:
        echo 'Method Not Allowed';
        break;
}
