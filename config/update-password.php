<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM user WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $update = $conn->prepare("UPDATE user SET Password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
        $update->bind_param("si", $new_password, $user['id']);
        $update->execute();

        echo "<script>alert('Password Updated Successfully.'); window.location.href='login.php';</script>";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
