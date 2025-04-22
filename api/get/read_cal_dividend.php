<?php
include "../../config/db.php";
header('Content-Type: application/json');

// 1. Get historical dividend totals grouped by year
$sql = "
    SELECT 
        YEAR(calculation_date) AS year, 
        SUM(dividend_amount) AS total_amount 
    FROM admin_dividends 
    GROUP BY YEAR(calculation_date)
    ORDER BY year ASC
";

$result = mysqli_query($conn, $sql);

$dateArray = [];
$amountArray = [];

if ($result && mysqli_num_rows($result) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $dateArray[] = $i++; 
        $amountArray[] = (float)$row['total_amount'];
    }
} else {
    echo json_encode([
        "error" => "Failed to fetch dividend data",
        "sql_error" => mysqli_error($conn)
    ]);
    exit;
}

// 2. Get total share capital from admin_sales excluding current year
$share_capital_query = "
    SELECT SUM(paid_up_share_capital) AS total_share_capital
    FROM admin_shares_list
    WHERE YEAR(created_at) < YEAR(CURDATE())
";

$share_capital_result = mysqli_query($conn, $share_capital_query);

if (!$share_capital_result) {
    echo json_encode([
        "error" => "Failed to fetch share capital",
        "sql_error" => mysqli_error($conn)
    ]);
    exit;
}

$share_capital_row = mysqli_fetch_assoc($share_capital_result);
$total_share_capital = $share_capital_row['total_share_capital'] ?? 0;

// 3. Final response
$response = [
    "dateArray" => $dateArray,
    "amountArray" => $amountArray,
    "total_share_capital" => $total_share_capital
];

echo json_encode($response);
exit;
?>
