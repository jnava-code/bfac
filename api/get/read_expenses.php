<?php
include "../../config/db.php";
header('Content-Type: application/json');

// Fetch all expenses
$expensesQuery = "SELECT id, category, amount, expense_date, description, year 
                    FROM admin_expenses 
                    WHERE DATE(expense_date) = DATE(CURDATE())
                    ORDER BY expense_date DESC";
$expensesResult = mysqli_query($conn, $expensesQuery);

$expenses = [];

if ($expensesResult) {
    while ($row = mysqli_fetch_assoc($expensesResult)) {
        $expenses[] = $row;
    }
}

// Calculate total amount
$totalQuery = "SELECT SUM(amount) AS total_amount FROM admin_expenses WHERE DATE(expense_date) = DATE(CURDATE())";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);

$totalAmount = $totalRow['total_amount'] ?? 0;

echo json_encode([
        'expenses' => $expenses,
        'total' => $totalAmount
]);
exit;
?>
