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
        if (password_verify($password, $user['password'])) {
            // $_SESSION['user_id'] = $user['member_id'];
            $_SESSION['role'] = $source;
            
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
