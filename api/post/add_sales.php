<?php
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT sales_no FROM admin_sales ORDER BY sales_no DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sales_no = $row['sales_no'] + 1; 
    } else {
        $sales_no = 1000;
    }

    $orderNo       = $sales_no;
    $productName   = mysqli_real_escape_string($conn, $_POST['productName']);
    $quantity      = (int)$_POST['quantity'];
    $unitprice     = (float)$_POST['unitprice'];
    $price         = (float)$_POST['price'];
    $receiptNo     = mysqli_real_escape_string($conn, trim($_POST['receiptNo']));
    $purchaseDate  = mysqli_real_escape_string($conn, $_POST['purchaseDate']);

    $check_receipt = "SELECT receipt_no FROM admin_sales WHERE receipt_no = '$receiptNo' LIMIT 1";
    $receipt_result = mysqli_query($conn, $check_receipt);

    if (!$receipt_result) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to check receipt number.']);
        exit;
    }

    if (mysqli_num_rows($receipt_result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Receipt number already exists.']);
        exit;
    }

    $sql = "INSERT INTO admin_sales 
            (sales_no, description, quantity, unitprice, amount, receipt_no, purchase_date) 
            VALUES 
            ('$orderNo', '$productName', '$quantity', '$unitprice', '$price', '$receiptNo', '$purchaseDate')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Sale recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
exit;
?>
