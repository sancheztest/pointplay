<?php

define("base_url", "/pointplay/api/");

function myRoutes($uri)
{
    switch ($uri) {
        case base_url . 'game':
            include 'routes/game.php';
            break;
        case base_url . 'coupons':
            include 'routes/coupons.php';
            break;

        default:
            echo '404 page not found';
            break;
    }
}

$uri = $_SERVER['REQUEST_URI'];
myRoutes($uri);
