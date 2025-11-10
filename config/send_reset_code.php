<?php
session_start();
include('connection.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email is registered
    $query = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate random reset code and expiration time
        $reset_code = rand(100000, 999999); // 6-digit random code
        $expiration_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));

        // Store reset code and expiration time in the database
        $update_query = "UPDATE user SET reset_code = ?, reset_code_expiration = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sss", $reset_code, $expiration_time, $email);
        $stmt->execute();

        // Send email with reset code
        $to = $email;
        $subject = "Password Reset Code";
        $message = "Your password reset code is: $reset_code. This code is valid for 2 minutes.";
        $headers = "From: piyushpandey7428@gmail.com";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['reset_email'] = $email;
            header("Location: verify_reset_code.php");
        } else {
            echo "Failed to send reset code.";
        }
    } else {
        echo "Email not registered.";
    }
}
?>
