<?php
    include "../config/db.php";

    if (!isset($_GET['token'])) {
        $message = "Invalid verification link.";
        exit;
    }

    $token = $_GET['token'];

    $query = "SELECT * FROM user_members WHERE token = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $member_id = $user['member_id'];

        if ($user['is_verified']) {
            $message = "Your email is already verified.";
            exit;
        }

        $currentTimestamp = time();
        $tokenExpiry = strtotime($user['token_expiry']);

        if ($currentTimestamp > $tokenExpiry) {
            $deleteQuery = "DELETE FROM user_members WHERE member_id = '$member_id'";
            mysqli_query($conn, $deleteQuery);

            $message = "Verification link has expired. Your registration has been removed. Please <a href=\"../user/reg.php\">Sign up</a> again.";
            exit;
        }

        $updateQuery = "UPDATE user_members 
                        SET is_verified = 1, 
                            token = NULL
                        WHERE member_id = '$member_id'";

        if (mysqli_query($conn, $updateQuery)) {
            $message = 'Email verified successfully! Please wait for your account to be approved, then you can <a href="../index.php">log in</a>.';
        } else {
            $message = "Something went wrong during verification. Please try again.";
        }

    } else {
        $message = "Invalid or expired verification token.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/reg.css">
    <title>Email Verification</title>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="../img/logo.png" alt="Cooperative Logo">
        </div>

        <h1>BFAC Management System</h1>

        <p><?php echo $message; ?></p>
    </div>
</body>
</html>