<?php
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $member_id    = mysqli_real_escape_string($conn, $_POST['member_id']);
    $dividend_amount        = mysqli_real_escape_string($conn, $_POST['dividend_amount']);
    $receipt        = mysqli_real_escape_string($conn, $_POST['receipt']);

    // Insert query (quotes added around all values)
    $sql = "INSERT INTO admin_dividends 
            (member_id, dividend_amount, receipt) 
            VALUES 
            ('$member_id', '$dividend_amount', '$receipt')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Divident recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
exit;
?>
