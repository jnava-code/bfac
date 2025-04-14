<?php 
    session_start();    

    if (!isset($_SESSION['user_logged'])) {
        header("Location: ../index.php");
        exit();
    } else {
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
    }

    
?>
