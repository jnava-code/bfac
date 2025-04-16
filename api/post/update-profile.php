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

    $query = "UPDATE `user_members` 
              SET `first_name`='$firstName', 
                  `middle_name`='$middleName', 
                  `last_name`='$lastName', 
                  `email`='$email', 
                  `phone`='$phone', 
                  `rsbsa_number`='$rsbsaNumber', 
                  `address`='$address', 
                  `farm_location`='$farmLocation' 
              WHERE `member_id`='$member_id'";

    if (mysqli_query($conn, $query)) {

        $_SESSION['first_name'] = $firstName;
        $_SESSION['middle_name'] = $middleName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['rsbsa_number'] = $rsbsaNumber;
        $_SESSION['address'] = $address;
        $_SESSION['farm_location'] = $farmLocation;

        echo json_encode(['status' => 'success', 'message' => 'Successfully updated profile.']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. Error: ' . mysqli_error($conn)]);
        exit;
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

?>