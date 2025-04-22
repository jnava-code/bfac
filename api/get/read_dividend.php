<?php
include "../../config/db.php";
header('Content-Type: application/json');

$sql_user = "
    SELECT 
        um.member_id,
        um.first_name,
        um.middle_name,
        um.last_name,
        COALESCE(sales_totals.total_sales, 0) AS total_sales,
        COALESCE(expense_totals.total_expenses, 0) AS total_expenses,
        COALESCE(share_totals.total_paid_up_share_capital, 0) AS total_paid_up_share_capital,
        COALESCE(share_totals.total_share_capital, 0) AS total_share_capital,
        COALESCE(global_paid_totals.all_total_paid_up_share_capital, 0) AS all_total_paid_up_share_capital,
        COALESCE(global_totals.all_total_share_capital, 0) AS all_total_share_capital,
        COALESCE(dividend_totals.total_dividend, 0) AS total_dividend
    FROM user_members um
    LEFT JOIN (
        SELECT SUM(amount) AS total_sales
        FROM admin_sales
    ) AS sales_totals ON 1=1
    LEFT JOIN (
        SELECT 
            SUM(amount) AS total_expenses 
        FROM admin_expenses
    ) AS expense_totals ON 1=1
    LEFT JOIN (
        SELECT 
            member_id,
            SUM(paid_up_share_capital) AS total_paid_up_share_capital,
            SUM(share_capital) AS total_share_capital
        FROM admin_shares_list
        GROUP BY member_id
    ) AS share_totals ON share_totals.member_id = um.member_id
    LEFT JOIN (
        SELECT 
            SUM(paid_up_share_capital) AS all_total_paid_up_share_capital
        FROM admin_shares_list
    ) AS global_paid_totals ON 1=1
    LEFT JOIN (
        SELECT 
            SUM(share_capital) AS all_total_share_capital
        FROM admin_shares_list
    ) AS global_totals ON 1=1
    LEFT JOIN (
        SELECT 
            member_id,
            SUM(dividend_amount) AS total_dividend
        FROM admin_dividends
        GROUP BY member_id
    ) AS dividend_totals ON dividend_totals.member_id = um.member_id
    WHERE um.is_archived = 0
";



$result_user = mysqli_query($conn, $sql_user);
$data = [];

if ($result_user) {
    while ($row = mysqli_fetch_assoc($result_user)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => mysqli_error($conn)]);
}

exit;
?>