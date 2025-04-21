<?php 
    include "../../config/db.php";
    header('Content-Type: application/json');

    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE admin_accounts SET is_archived = 0 WHERE user_id = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
?>