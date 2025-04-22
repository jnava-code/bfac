<?php
include "../../config/db.php";

// Get the highest sales_no
$sql = "SELECT sales_no FROM admin_sales ORDER BY sales_no DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $sales_no = $row['sales_no'] + 1; // Get next number
} else {
    $sales_no = 1000; // Start at 1000 if table is empty
}

// Return as JSON to JavaScript
echo json_encode(['sales_no' => $sales_no]);
exit;
?>
