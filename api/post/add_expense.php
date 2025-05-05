<?php
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $amount      = mysqli_real_escape_string($conn, $_POST['amount']);
    $date        = mysqli_real_escape_string($conn, $_POST['date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Insert query (quotes added around all values)
    $sql = "INSERT INTO admin_expenses 
            (category, amount, expense_date, description) 
            VALUES 
            ('$category', '$amount', '$date', '$description')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Expense recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
exit;
?>
