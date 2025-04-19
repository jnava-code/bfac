<?php
    include "../../config/db.php";
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize inputs
        $orderNo       = mysqli_real_escape_string($conn, $_POST['orderNo']);
        $customerId   = mysqli_real_escape_string($conn, $_POST['customerId']);
        $productName   = mysqli_real_escape_string($conn, $_POST['productName']);
        $quantity      = (int)$_POST['quantity'];
        $price         = (float)$_POST['price'];
        $receiptNo     = mysqli_real_escape_string($conn, $_POST['receiptNo']);
        $purchaseDate  = mysqli_real_escape_string($conn, $_POST['purchaseDate']);

        // Insert query
        $sql = "INSERT INTO admin_sales 
                (member_id, sales_no, description, quantity, amount, receipt_no, purchase_date) 
                VALUES 
                ('$customerId','$orderNo', '$productName', $quantity, $price, '$receiptNo', '$purchaseDate')";

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
