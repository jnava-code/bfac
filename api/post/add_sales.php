<?php
    include "../../config/db.php";
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the highest sales_no
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
        $receiptNo     = mysqli_real_escape_string($conn, $_POST['receiptNo']);
        $purchaseDate  = mysqli_real_escape_string($conn, $_POST['purchaseDate']);

        // Insert query
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
