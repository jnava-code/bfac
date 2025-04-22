<?php
include "../../config/db.php";
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $sql = "UPDATE admin_accounts SET is_archived = 1 WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(['status' => 'success', 'id' => $user_id]);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>