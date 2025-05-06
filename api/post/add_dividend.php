<?php
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id        = mysqli_real_escape_string($conn, $_POST['member_id']);
    $dividend_amount  = mysqli_real_escape_string($conn, $_POST['dividend_amount']);
    $receipt          = mysqli_real_escape_string($conn, trim($_POST['receipt']));

    $check_receipt = "SELECT receipt FROM admin_dividends WHERE receipt = '$receipt' LIMIT 1";
    $receipt_result = mysqli_query($conn, $check_receipt);

    if (!$receipt_result) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to check receipt number.']);
        exit;
    }

    if (mysqli_num_rows($receipt_result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Receipt number already exists.']);
        exit;
    }

    $sql = "INSERT INTO admin_dividends 
            (member_id, dividend_amount, receipt) 
            VALUES 
            ('$member_id', '$dividend_amount', '$receipt')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Dividend recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
exit;
?>
