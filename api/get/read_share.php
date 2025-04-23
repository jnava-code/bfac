<?php
    include "../../config/db.php";

    header('Content-Type: application/json');

    $sql_share = "
        SELECT 
            ashares.id,
            ashares.member_id,
            ashares.update_at,
            ashares.is_archived,
            SUM(asl.paid_up_share_capital) AS total_paid_up_share_capital,
            SUM(asl.share_capital) AS total_share_capital,
            um.first_name,
            um.middle_name,
            um.last_name,
            asl.created_at
        FROM admin_shares AS ashares
        LEFT JOIN admin_shares_list asl ON asl.member_id = ashares.member_id
        LEFT JOIN user_members um ON um.member_id = ashares.member_id
        WHERE ashares.is_archived = 0
          
        GROUP BY 
            ashares.member_id,
            ashares.update_at,
            ashares.is_archived,
            um.first_name,
            um.middle_name,
            um.last_name
    ";
    // AND DATE(asl.created_at) = CURDATE()
    $result_share = mysqli_query($conn, $sql_share);

    $data = [];

    if ($result_share) {
        while ($row = mysqli_fetch_assoc($result_share)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    exit;
?>
