<?php
include "../../config/db.php";
header('Content-Type: application/json');

// Fetch sales with member info
$sql_share = "SELECT 
*
FROM admin_sales AS asales
LEFT JOIN user_members um ON um.member_id = asales.member_id
WHERE um.is_archived = 0 AND um.is_verified = 1 AND DATE(asales.purchase_date) = CURDATE()
";

$result_share = mysqli_query($conn, $sql_share);

$data = [];

if ($result_share) {
    while ($row = mysqli_fetch_assoc($result_share)) {
        $data[] = $row;
    }
}

// Calculate total sales amount
$total_query = "
    SELECT SUM(asales.amount) AS total_sales
    FROM admin_sales AS asales
    LEFT JOIN user_members um ON um.member_id = asales.member_id
    WHERE um.is_archived = 0 AND um.is_verified = 1
";

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_sales = $total_row['total_sales'] ?? 0;

echo json_encode([
        'sales' => $data,
        'total_sales' => $total_sales
]);

exit;
?>
