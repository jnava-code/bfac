<?php
include "../../config/db.php";

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

if (mysqli_num_rows($result) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $dateArray[] = $i++; 
        $amountArray[] = (float)$row['total_amount'];
    }
}

// Return as JSON
$response = [
    "dateArray" => $dateArray, 
    "amountArray" => $amountArray  
];

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
