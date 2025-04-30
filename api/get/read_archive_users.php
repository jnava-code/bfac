<?php
include "../../config/db.php";

$sql = "SELECT * FROM user_members 
  WHERE is_archived = 1 AND status = 'Approved' AND is_verified = 1 AND is_deleted = 0";
	$result = mysqli_query($conn, $sql);
$data = [];
if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    $data = []; 
}
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>