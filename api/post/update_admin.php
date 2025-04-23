<?php
include "../../config/db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $updateProfileImage = "";

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile']['tmp_name'];
        $fileName = $_FILES['profile']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $randomId = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);

        $safeFullname = preg_replace('/[^A-Za-z0-9]/', '', $fullname);
        $newFileName = $randomId . "_" . $safeFullname . "." . $fileExt;

        $uploadDir = '../../admin_profile/';
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            $profileImagePath = "admin_profile/" . $newFileName;
            $updateProfileImage = ", profile_image = '" . mysqli_real_escape_string($conn, $profileImagePath) . "'";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload profile image.']);
            exit;
        }
    }

    $sql = "UPDATE admin_accounts 
            SET full_name = '$fullname',
                email = '$email',
                username = '$username',
                role = '$role'
                $updateProfileImage
            WHERE user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['profile_image'] = $profileImagePath;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
