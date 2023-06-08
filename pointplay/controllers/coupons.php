<?php


function getCoupons($conn)
{
    $sql = "SELECT * FROM coupons";
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

    $sql = "SELECT * FROM coupons where id =" . $coupon_id;
    $result = $conn->query($sql);
    $coupon = $result->fetch_assoc();

    $price = $coupon['price'];
    $amount = $coupon['amount'];

    $sql = "SELECT * FROM points";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    $info_id = $info["id"];
    $points = $info["points"];
    $coupons = $info["coupons"];

    if ($points >= $price) {
        $points -= $price;
        $coupons += $amount;

        $sql = "UPDATE points set points=" . $points . ", coupons=" . $coupons . " where id =" . $info_id;
        $result = $conn->query($sql);
        $conn->close();

        if ($result == TRUE) {
            echo "Coupons buy successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $conn->close();
        echo "Insufficent Balanca";
    }
}

function spendCoupon($conn)
{
    
}
