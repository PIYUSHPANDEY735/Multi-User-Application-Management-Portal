<?php
session_start();
include('connection.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reset_code = $_POST['reset_code'];
    $email = $_SESSION['reset_email'];

    // Check if the reset code matches and is within the valid time
    $query = "SELECT * FROM user WHERE Email = ? AND reset_code = ? AND reset_code_expiration >= NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $reset_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        header("Location: https://localhost/piyushproject/");
    } else {
        echo "Invalid or expired reset code.";
    }
}
?>
