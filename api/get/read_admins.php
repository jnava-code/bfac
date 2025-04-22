<?php
include "../../config/db.php";

$sql_admin = "SELECT full_name, username, email, role, profile_image FROM admin_accounts WHERE is_archived = 0";
$result_admin = mysqli_query($conn, $sql_admin);

$data = [];

if(mysqli_num_rows($result_admin) > 0) {
    while ($row = mysqli_fetch_assoc($result_admin)) {
        $data[] = $row;
    }
} else {
    $data = []; 
}

header('Content-Type: application/json');
echo json_encode($data);
exit;
?>
