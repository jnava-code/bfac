<?php
include "../../config/db.php";
header('Content-Type: application/json');

$sql_share = "
    SELECT 
        asl.member_id,
        asl.paid_up_share_capital,
        asl.share_capital,
        asl.created_at,
        um.first_name,
        um.middle_name,
        um.last_name
    FROM admin_shares_list asl
    LEFT JOIN user_members um ON um.member_id = asl.member_id
    LEFT JOIN admin_shares ash ON um.member_id = ash.member_id
    WHERE ash.is_archived = 0
    ORDER BY asl.member_id, asl.created_at DESC
";

$result_share = mysqli_query($conn, $sql_share);

$data = [];

if ($result_share) {
    while ($row = mysqli_fetch_assoc($result_share)) {
        $member_id = $row['member_id'];

        if (!isset($data[$member_id])) {
            $data[$member_id] = [
                'member_id' => $member_id,
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'last_name' => $row['last_name'],
                'shares' => [] 
            ];
        }

        $data[$member_id]['shares'][] = [
            'paid_up_share_capital' => $row['paid_up_share_capital'],
            'share_capital' => $row['share_capital'],
            'created_at' => $row['created_at']
        ];
    }

    echo json_encode(array_values($data));
} else {
    echo json_encode([
        "error" => "Query failed: " . mysqli_error($conn)
    ]);
}

exit;
?>
