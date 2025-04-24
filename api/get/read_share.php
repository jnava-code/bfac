<?php
include "../../config/db.php";
header('Content-Type: application/json');

$sql_share = "
    SELECT 
        a_sh.id,
        a_sh.member_id,
        a_sh.update_at,
        a_sh.is_archived,
        SUM(asl.paid_up_share_capital) AS total_paid_up_share_capital,
        SUM(asl.share_capital) AS total_share_capital,
        um.first_name,
        um.middle_name,
        um.last_name,
        MAX(asl.created_at) AS created_at
    FROM admin_shares a_sh
    LEFT JOIN admin_shares_list asl ON asl.member_id = a_sh.member_id
    LEFT JOIN user_members um ON um.member_id = a_sh.member_id
    WHERE a_sh.is_archived = 0
    -- AND DATE(asl.created_at) = CURDATE()
    GROUP BY 
        a_sh.id,
        a_sh.member_id,
        a_sh.update_at,
        a_sh.is_archived,
        um.first_name,
        um.middle_name,
        um.last_name
";

$result_share = mysqli_query($conn, $sql_share);

$data = [];

if ($result_share) {
    while ($row = mysqli_fetch_assoc($result_share)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([
        "error" => "Query failed: " . mysqli_error($conn)
    ]);
}

exit;
?>
