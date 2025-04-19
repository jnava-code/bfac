<?php
    include "../../config/db.php";
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize inputs
        $orderNo       = mysqli_real_escape_string($conn, $_POST['orderNo']);
        $customerNId   = mysqli_real_escape_string($conn, $_POST['customerNId']);
        $productName   = mysqli_real_escape_string($conn, $_POST['productName']);
        $quantity      = (int)$_POST['quantity'];
        $price         = (float)$_POST['price'];
        $receiptNo     = mysqli_real_escape_string($conn, $_POST['receiptNo']);
        $purchaseDate  = mysqli_real_escape_string($conn, $_POST['purchaseDate']);

        // Insert query
        $sql = "INSERT INTO admin_sales 
                (sales_no, member_id, description, quantity, amount, receipt_no, purchase_date) 
                VALUES 
                ('$orderNo', '$customerNId', '$productName', $quantity, $price, '$receiptNo', '$purchaseDate')";

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
