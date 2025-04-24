<?php
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $member_id    = mysqli_real_escape_string($conn, $_POST['member_id']);
    $shares = mysqli_real_escape_string($conn, $_POST['shares']);
    $dividend_amount        = mysqli_real_escape_string($conn, $_POST['dividend_amount']);
    $receipt        = mysqli_real_escape_string($conn, $_POST['receipt']);

    // Insert query (quotes added around all values)
    $sql_dividend = "INSERT INTO admin_dividends 
            (member_id, dividend_amount, receipt) 
            VALUES 
            ('$member_id', '$dividend_amount', '$receipt')";

    $result_dividend = mysqli_query($conn, $sql_dividend);

    $sql_shares = "INSERT INTO admin_shares_list
    (member_id, paid_up_share_capital, share_capital, receipt_number) 
    VALUES 
    ('$member_id', '$dividend_amount', '$shares', '$receipt')";
    $result_shares = mysqli_query($conn, $sql_shares); 
       
    if ($result_dividend && $result_shares) {
        echo json_encode(['status' => 'success', 'message' => 'Dividend recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
exit;
?>
