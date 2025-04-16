<?php 
    session_start();    

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == true) {
        $role = $_SESSION['role'];
        $member_id = $_SESSION['member_id'];
        $firstname = $_SESSION['first_name'];
        $middlename = $_SESSION['middle_name'];
        $lastname = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        $rsbsa_number = $_SESSION['rsbsa_number'];
        $address = $_SESSION['address'];
        $farm_location = $_SESSION['farm_location'];
        $profile_image = $_SESSION['profile_image'];
    } else if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
        $role = $_SESSION['role'];
        $full_name = $_SESSION['full_name'];
        $email = $_SESSION['email'];
        $username = $_SESSION['username'];
        $profile_image = $_SESSION['profile_image'];
    } else {
        header("Location: ../index.php");
        exit();
    }

    
?>
