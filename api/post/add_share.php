<?php
    include "../../config/db.php";

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $member_id = mysqli_real_escape_string($conn, $_POST['memberSelect']);
        $shares = mysqli_real_escape_string($conn, $_POST['sharesInput']);
        $purchasePrice = mysqli_real_escape_string($conn, $_POST['purchasePrice']);
        $receiptNumber = mysqli_real_escape_string($conn, $_POST['receiptNumber']);

        $check_query = "SELECT member_id FROM admin_shares WHERE member_id = '$member_id' LIMIT 1";
        $check_result = mysqli_query($conn, $check_query);

        if (!$check_result) {
            echo json_encode(["status" => "error", "message" => "Failed to check member existence."]);
            exit;
        }

        if (mysqli_num_rows($check_result) === 0) {
            $insert_shares = "INSERT INTO `admin_shares` (`member_id`) VALUES ('$member_id')";
            $insert_result = mysqli_query($conn, $insert_shares);

            if (!$insert_result) {
                echo json_encode(["status" => "error", "message" => "Failed to insert into admin_shares."]);
                exit;
            }
        }

        $insert_share_list = "
            INSERT INTO `admin_shares_list` 
            (`member_id`, `paid_up_share_capital`, `share_capital`, `receipt_number`) 
            VALUES ('$member_id', '$purchasePrice', '$shares', '$receiptNumber')
        ";
        $list_result = mysqli_query($conn, $insert_share_list);

        if ($list_result) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to insert into admin_shares_list."]);
        }

        exit;
    }
?>
