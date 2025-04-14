<?php
    // include "../config/db.php";
    // session_start();

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $username = mysqli_real_escape_string($conn, $_POST['username']);
    //     $password = mysqli_real_escape_string($conn, $_POST['password']);

    //     $query = "SELECT * FROM user_members WHERE email = '$username'";
    //     $result = mysqli_query($conn, $query);

    //     $query = "SELECT * FROM user_members WHERE username = '$username' AND email = '$username'";
    //     $result = mysqli_query($conn, $query);

    //     if ($result) {
    //         $user = mysqli_fetch_assoc($result);

    //         if (password_verify($password, $user['password_hash'])) {
    //             $_SESSION['user_id'] = $user['member_id'];

    //             echo json_encode([
    //                 'status' => 'success'
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Invalid password. Please try again.'
    //             ]);
    //         }
    //     } else {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'User not found. Please check your username or email.'
    //         ]);
    //     }
    // }
?>

<?php
include "../config/db.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $user = null;
    $source = null;

    $queryUser = "SELECT * FROM user_members WHERE username = '$username' OR email = '$username'";
    $resultUser = mysqli_query($conn, $queryUser);

    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $user = mysqli_fetch_assoc($resultUser);
        $source = $user['role'];
    } else {
        $queryAdmin = "SELECT * FROM admin_accounts WHERE username = '$username' OR email = '$username'";
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
            $_SESSION['role'] = $source;
            
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
            } else {
                $_SESSION['admin_logged'] = true;
            }

            echo json_encode([
                'status' => 'success',
                'role' => $source
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid password. Please try again.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found. Please check your username or email.'
        ]);
    }
}
?>
