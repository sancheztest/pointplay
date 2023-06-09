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
    echo $coupon_id;

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


    // if ($points >= $price) {

    //     //Pay
        


    //     $points -= $price;
    //     $coupons += $amount;

    //     $sql = "UPDATE points set points=" . $points . ", coupons=" . $coupons . " where id =" . $info_id;
    //     $result = $conn->query($sql);
    //     $conn->close();

    //     if ($result == TRUE) {
    //         echo "Coupons buy successfully";
    //     } else {
    //         echo "Error updating record: " . $conn->error;
    //     }
    // } else {
    //     $conn->close();
    //     echo "Insufficent Balance";
    // }
}

function spendCoupon($conn)
{
    /*
    op: + -
    am: number
    type: coupons points
    */

    $sql = "SELECT * FROM options";
    $result = $conn->query($sql);

    $options = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row;
        }
    } else {
        echo "0 results";
    }

    $len = count($options);
    $rand = rand(0, $len - 1);

    $option = $options[$rand];

    $operation = $option['opetation'];
    $amount = $option['amount'];
    $type = $option['type'];

    $sql = "SELECT * FROM points";
    $result = $conn->query($sql);
    $info = $result->fetch_assoc();

    $info_id = $info["id"];
    $points = $info["points"];
    $coupons = $info["coupons"];

    $operations = [
        '+' => function ($type, $amount) {
            return $type + $amount;
        },
        '-' => function ($type, $amount) {
            return max(0, $type - $amount);
        },
    ];

    $value = $operations[$operation]($$type, $amount);
    $$type = $value;


    $sql = "UPDATE points set " . $type . " = " . $$type . " WHERE id = " . $info_id;
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
        $response = [
            'msg' => "Updated Successfully (" .$type. ")",
            'option' => $option
        ];
        echo json_encode($response);
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
