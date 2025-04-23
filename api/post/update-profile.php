<?php
session_start();
include "../../config/db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $member_id = mysqli_real_escape_string($conn, $_POST['memberId']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $rsbsaNumber = mysqli_real_escape_string($conn, $_POST['rsbsaNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $farmLocation = mysqli_real_escape_string($conn, $_POST['farmLocation']);

    $updateProfileImage = ""; // To store SQL segment for profile_image update

    // ✅ Check if a file was uploaded
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile']['tmp_name'];
        $fileName = $_FILES['profile']['name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // ✅ Sanitize file name
        $randomId = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        $newFileName = $randomId . "_" . preg_replace('/[^A-Za-z0-9]/', '', $firstName) . "_" . preg_replace('/[^A-Za-z0-9]/', '', $lastName) . "." . $fileExt;

        $uploadDir = '../../profile_images/';
        $uploadPath = $uploadDir . $newFileName;

        // ✅ Move the uploaded file
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            $profileImagePath = "profile_images/" . $newFileName;
            $updateProfileImage = ", `profile_image` = '" . mysqli_real_escape_string($conn, $profileImagePath) . "'";
            $profile_image = "profile_images/" . $newFileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded file.']);
            exit;
        }
    }

    // ✅ Build update query
    $query = "UPDATE `user_members` 
              SET `first_name` = '$firstName',
                  `middle_name` = '$middleName',
                  `last_name` = '$lastName',
                  `email` = '$email',
                  `phone` = '$phone',
                  `rsbsa_number` = '$rsbsaNumber',
                  `address` = '$address',
                  `farm_location` = '$farmLocation'
                  $updateProfileImage
              WHERE `member_id` = '$member_id'";

    if (mysqli_query($conn, $query)) {
        // Update session
        $_SESSION['first_name'] = $firstName;
        $_SESSION['middle_name'] = $middleName;
        $_SESSION['profile_image'] = $profile_image;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['rsbsa_number'] = $rsbsaNumber;
        $_SESSION['address'] = $address;
        $_SESSION['farm_location'] = $farmLocation;

        echo json_encode(['status' => 'success', 'message' => 'Successfully updated profile.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. Error: ' . mysqli_error($conn)]);
    }
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
?>
