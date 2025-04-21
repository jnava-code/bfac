<?php
    include "config/db.php";

    $token = $_GET['token'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
        $newpassword = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    
        if (empty($newpassword) || empty($cpassword)) {
            $error = "Please fill in all fields.";
        } else {
            $sql = "SELECT * FROM user_members WHERE token='$token'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
    
                if ($row['token_expiry'] < date('Y-m-d H:i:s')) {
                    $error = "Token has expired. Please request a new password reset.";
                } else {
                    if ($newpassword == $cpassword) {
                        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
                        $update_sql = "UPDATE user_members SET password='$hashed_password', token=NULL, token_expiry=NULL WHERE token='$token'";
                        if (mysqli_query($conn, $update_sql)) {
                            $success = "Password updated successfully. <a href='index.php'>Login</a>";
                        } else {
                            $error = "Error updating password. Please try again.";
                        }
                    } else {
                        $error = "New passwords do not match.";
                    }
                }
            } else {
                $error = "Token not found.";
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
            <input type="password" name="password" id="password" placeholder="New Password" required>
            <input type="password" style="margin-top: 5px" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
            <input type="submit" style="margin-top: 10px" class="btn-login" name="change" value="Change Password">
        </form>
        <?php if (!empty($error)) echo "<div style='color:red; text-align: center; margin-top:10px'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div style='color:green; text-align: center; margin-top:10px'>$success</div>"; ?>
    </div>
</body>
</html>