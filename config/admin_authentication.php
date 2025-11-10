<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("connection.php");

if (isset($_POST['email']) && isset($_POST['password'])) {
    $naam = $_POST['email'];
    $code = $_POST['password'];

    // Sanitize input
    $naam = stripcslashes($naam);
    $naam = mysqli_real_escape_string($conn, $naam);

    // Prepare statement to safely fetch admin by email
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `Email` = ?");
    $stmt->bind_param("s", $naam);
    $stmt->execute();
    $result_user = $stmt->get_result();

    if ($result_user->num_rows === 1) {
        $row_user = $result_user->fetch_assoc();

        // Verify password using password_verify
        if (password_verify($code, $row_user['Password'])) {
            $_SESSION['id'] = $row_user['id'];
            $_SESSION['email'] = $row_user['Email'];
            $_SESSION['name'] = $row_user['Name'];
            $_SESSION['Status'] = $row_user['Status'];

            header("Location: ../admindashboard/index.php");
            exit();
        } else {
            // Password didn't match
            header("Location: ./config/admin_login.php?error=1");  
            exit();
        }
    } else {
        // No user with that email
        header("Location: ./config/admin_login.php?error=1");  
        exit();
    }
} else {
    echo "Email or Password not set!";
    exit();
}
?>
