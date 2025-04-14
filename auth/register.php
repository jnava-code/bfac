<?php
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $rsbsaNumber = mysqli_real_escape_string($conn, $_POST['rsbsaNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $farmLocation = mysqli_real_escape_string($conn, $_POST['farmLocation']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $role = 'User';

    if ($password !== $confirmPassword) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password and Confirm Password do not match.'
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $username = strtolower(substr($firstName, 0, 1) . $lastName);

    $checkQuery = "SELECT * FROM user_members WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username or email already exists.'
        ]);
        exit;
    }

    $query = "INSERT INTO user_members (
                first_name, middle_name, last_name, username, email, password, phone, rsbsa_number, address, farm_location, role
              ) VALUES (
                '$firstName', '$middleName', '$lastName', '$username', '$email', '$hashedPassword', '$phone', '$rsbsaNumber', '$address', '$farmLocation', '$role'
              )";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful!'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Registration failed. Please try again.'
        ]);
        exit;
    }
}
?>
