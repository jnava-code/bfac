<?php
    include "../../config/db.php";
    header('Content-Type: application/json');
    
    $sql_share = "
            SELECT 
                as.paid_up_share_capital,
                as.share_capital,
                as.receipt_number,
                um.first_name,
                um.middle_name,
                um.last_name
            FROM admin_shares as
            LEFT JOIN user_members um ON um.member_id = as.member_id";

    $result_share = mysqli_query($conn, $sql_share);

    $data = [];
    if($result_share) {
        while($row = mysqli_fetch_assoc($result_share)) {
            $data[] = $row;
        }

        echo json_encode($data);
            exit;
    }
?>