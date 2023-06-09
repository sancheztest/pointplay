<?php

define("base_url", "/pointplay/api/");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

function myRoutes($uri)
{
    switch ($uri) {
        case base_url . 'game':
            include 'routes/game.php';
            break;


        case base_url . 'coupons/get':
            include 'routes/coupons.php';
            break;
        case base_url . 'coupons/buy':
            include 'routes/coupons.php';
            break;
        case base_url . 'coupons/spend':
            include 'routes/coupons.php';
            break;

        default:
            echo '404 page not found';
            break;
    }
}

$uri = $_SERVER['REQUEST_URI'];
myRoutes($uri);
