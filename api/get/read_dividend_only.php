<?php
    include "../../config/db.php";

    $sql_dividend = "
    SELECT ad.*, um.first_name, um.middle_name, um.last_name 
    FROM admin_dividends ad
    LEFT JOIN user_members um ON um.member_id = ad.member_id";
    $result_dividend = mysqli_query($conn, $sql_dividend);

    $dividends = [];

    if($result_dividend) {
        while($row = mysqli_fetch_assoc($result_dividend)) {
            $dividends[] = $row;
        }
    }

    echo json_encode($dividends);
    exit;
?>