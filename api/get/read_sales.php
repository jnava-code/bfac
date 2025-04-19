<?php
    include "../../config/db.php";

    header('Content-Type: application/json');

    $sql_share = "SELECT 
            *
        FROM admin_sales AS asales
        LEFT JOIN user_members um ON um.member_id = asales.member_id
        WHERE um.is_archived = 0 AND um.is_verified = 1
    ";

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
