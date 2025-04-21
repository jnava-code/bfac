<?php
    session_start();
    include "config/db.php";

    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/Exception.php';
    require 'vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/PHPMailer.php';
    require 'vendor/PHPMailer-6.9.3/PHPMailer-6.9.3/src/SMTP.php';

    $error = '';
    $success = '';

    function sendResetPasswordLink($conn, $email, $token_hash, $token_expiry) {
        $email = mysqli_real_escape_string($conn, $email);
    
        $sql = "UPDATE user_members SET 
                token = '$token_hash', 
                token_expiry = '$token_expiry'
                WHERE email = '$email'";
    
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['reset'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $token_expiry = date('Y-m-d H:i:s', time() + 3600);

        $sql = "SELECT * FROM user_members WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
            $error = 'Email address not found.';
        } else {
            if(sendResetPasswordLink($conn, $email, $token_hash, $token_expiry)) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = 'aiahnava5@gmail.com'; 
                    $mail->Password = 'qtyf sdvy tfkl jjtv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                                
                    $mail->setFrom('no-reply@yourwebsite.com', 'BFAC Management System'); // Corrected "From" email
                    $mail->addAddress($email); 
                    $mail->Subject = 'Reset Password - BFAC Management System';

                    $message = "Click <a href='http://localhost/bfac/reset-password.php?token=$token_hash'>here</a> to reset your password. <br>";

                    $mail->isHTML(true);
                    $mail->Body = $message;

                    if ($mail->send()) {
                        $_SESSION['success'] = 'A reset password link has been sent to your email address.';
    
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        $error = "An error occurred: " . $stmt->error;
                    }
                } catch (Exception $e) {
                    $error = "Mailer Error: " . $mail->ErrorInfo;
                }
            } else {
                $error = 'There was an error updating your password reset token.';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/reg.css">
    <title>Email Verification</title>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="img/logo.png" alt="Cooperative Logo">
        </div>

        <h1>BFAC Management System</h1>

        <form method="post">
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="submit" style="margin-top: 10px" class="btn-login" name="reset" value="Reset Password">
        </form>
        <?php 
            if (isset($_SESSION['success'])) {
                $success = $_SESSION['success'];
                unset($_SESSION['success']);
            }
        ?>
        <?php if (!empty($error)) echo "<div style='color:red; text-align: center; margin-top:10px'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div style='color:green; text-align: center; margin-top:10px'>$success</div>"; ?>
    </div>
</body>
</html>