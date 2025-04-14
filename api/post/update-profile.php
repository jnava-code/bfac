<?php
include "../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = mysqli_real_escape_string($conn, $_POST['memberId']); // 👈 Get from POST

    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $rsbsaNumber = mysqli_real_escape_string($conn, $_POST['rsbsaNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $farmLocation = mysqli_real_escape_string($conn, $_POST['farmLocation']);

    $query = "UPDATE user_members 
              SET first_name='$firstName', middle_name='$middleName', last_name='$lastName', 
                  email='$email', phone='$phone', rsbsa_number='$rsbsaNumber', 
                  address='$address', farm_location='$farmLocation' 
              WHERE member_id='$member_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
