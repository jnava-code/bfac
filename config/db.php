<?php
    $conn = mysqli_connect("localhost", "root", "", "bfac");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>