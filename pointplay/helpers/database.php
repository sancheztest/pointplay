<?php

function getConnection($config)
{
    $host = $config['db']['host'];
    $user = $config['db']['user'];
    $pass = $config['db']['pass'];
    $name = $config['db']['name'];

    return mysqli_connect($host, $user, $pass, $name);
    // return new PDO("mysql:host=" . $host . ";dbname=" . $name . ";charaset=utf8mb4", $user, $pass);
}

function closeConnection($conn)
{
    mysqli_close($conn);
}
