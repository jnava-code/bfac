<?php 
include "../../config/db.php";
header('Content-Type: application/json');

if (isset($_POST['id']) && isset($_POST['member_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);

    $sql = "DELETE FROM admin_shares WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    $sql_list = "DELETE FROM admin_shares_list WHERE member_id = '$member_id'";
    $result_list = mysqli_query($conn, $sql_list);

    if ($result && $result_list) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
