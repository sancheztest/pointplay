<?php

function GetInfo($conn)
{
    $sql = "SELECT * FROM points";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    echo json_encode($info);
}
