<?php
include("connection.php");

error_reporting(E_ALL);
ini_set('display_errors',1);

date_default_timezone_set('Asia/Kolkata');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        // Generate token and expiry
        $token = bin2hex(random_bytes(32));
       $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        // Store token in database
        $update = $conn->prepare("UPDATE user SET reset_token = ?, token_expiry = ? WHERE Email = ?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();
        // Create reset link
        $reset_link = "https://localhost/piyushproject/config/reset-password.php?token=$token";
        
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'company.in';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@company.in';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('noreply@company.in', 'Piyush Project');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = " <h3>Hello,</h3><br><br> <h4>Click the link below to reset your password:<br> <a href='$reset_link'>$reset_link</a><br><br> This link will expire in 5 Minutes. Hurry Up ! Update Your Password.</h4><br><br> <h4>Regards,<br>Company Team</h4> ";
            $mail->send();
            echo "<script>alert('Reset link sent! Please check your email.'); window.location.href='login.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send email. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email address.');window.location.href='forget-password.php';</script>";
    }
}

?>