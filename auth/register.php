<?php
include "../config/db.php";

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/Exception.php';
require '../vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/PHPMailer.php';
require '../vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/SMTP.php';

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
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $token_expiry = date('Y-m-d H:i:s', time() + 3600);
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

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aiahnava5@gmail.com';
        $mail->Password = 'ceep fcsw jrxj dvqg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
                    
        $mail->setFrom('no-reply@yourwebsite.com', '');
        $mail->addAddress($email);
        $mail->Subject = 'Email verification - BFAC Management System';

        $message = "Hello!
                <br><a href='http://localhost/bfac/auth/verify-email.php?token=$token_hash'>Click here</a> to verify your email address.
                <br><br>If you did not create an account, no further action is required.
                <br><br>Thanks,
                <br>Your BFACMS-2000 Team
                ";

        $mail->isHTML(true);
        $mail->Body = $message;

        if ($mail->send()) { 
            $query = "INSERT INTO user_members (
                first_name, middle_name, last_name, username, email, password, phone, rsbsa_number, address, farm_location, role,
                token, token_expiry
                ) VALUES (
                '$firstName', '$middleName', '$lastName', '$username', '$email', '$hashedPassword', '$phone', '$rsbsaNumber', '$address', '$farmLocation', '$role',
                '$token_hash', '$token_expiry'
                )";
            if(mysqli_query($conn, $query)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registration successful!'
                ]);
                exit;
            }
        } 
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Mailer Error: ' . $mail->ErrorInfo
        ]);
        exit;
    }
}
?>
