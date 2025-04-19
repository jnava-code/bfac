<?php
    include "../../config/db.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
        $shares = mysqli_real_escape_string($conn, $_POST['shares']);
        $purchasePrice = mysqli_real_escape_string($conn, $_POST['purchasePrice']);
        $receiptNumber = mysqli_real_escape_string($conn, $_POST['receiptNumber']);
        
        $share_insert = "INSERT INTO `admin_shares` (`member_id`, `paid_up_share_capital`, `share_capital`, `receipt_number`) 
        VALUES ('$member_id', '$shares', '$purchasePrice', '$receiptNumber')";
        $share_result = mysqli_query($conn, $share_insert);

        if($share_result) {
            echo json_encode(["status" => "success"]);
            exit;
        } else {
            echo json_encode(["status" => "error"]);
            exit;
        }
    }
?>