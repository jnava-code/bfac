<?php
include "../config/db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $user = null;
    $source = null;

    $queryUser = "SELECT * FROM user_members WHERE (username = '$username' OR email = '$username') AND status = 'Approved' AND is_archived = 0";
    $resultUser = mysqli_query($conn, $queryUser);

    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $user = mysqli_fetch_assoc($resultUser);
        $source = $user['role'];
    } else {
        $queryAdmin = "SELECT * FROM admin_accounts WHERE (username = '$username' OR email = '$username') AND is_archived = 0";
        $resultAdmin = mysqli_query($conn, $queryAdmin);

        if ($resultAdmin && mysqli_num_rows($resultAdmin) > 0) {
            $user = mysqli_fetch_assoc($resultAdmin);
            $source = $user['role'];
        }
    }

    if ($user) {
        $_SESSION['admin_logged'] = false;
        $_SESSION['user_logged'] = false;
        
        if (password_verify($password, $user['password'])) {
            $source = $user['role'];
            
            if($source == 'User') {
                $_SESSION['user_logged'] = true;
                $_SESSION['member_id'] = $user['member_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['middle_name'] = $user['middle_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['rsbsa_number'] = $user['rsbsa_number'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['farm_location'] = $user['farm_location'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_image'] = $user['profile_image'];
            } else {
                $_SESSION['admin_logged'] = true;
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['profile_image'] = $user['profile_image'];
            }

            echo json_encode([
                'status' => 'success',
                'role' => $source
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid password. Please try again.'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found or not approved. Please check your username or email.'
        ]);
        exit;
    }
}
?>
