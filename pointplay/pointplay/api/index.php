<?php

define("base_url", "/pointplay/api/");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

function myRoutes($uri)
{
    switch ($uri) {
        case base_url . 'user_balance':
            include 'routes.php';
            break;
        case base_url . 'purchase_plans':
            include 'routes.php';
            break;
        case base_url . 'buy':
            include 'routes.php';
            break;
        case base_url . 'spend':
            include 'routes.php';
            break;

        default:
            echo '404 page not found';
            break;
    }
}

$uri = $_SERVER['REQUEST_URI'];
myRoutes($uri);
