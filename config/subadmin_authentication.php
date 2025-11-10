<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("connection.php");

// Get the email and password from the POST request
$naam = $_POST['email'];
$code = $_POST['password'];

// Escape special characters to prevent SQL injection
$naam = stripcslashes($naam);
$naam = mysqli_real_escape_string($conn, $naam);

// Check if the user is a regular user
$sql_user = "SELECT * FROM user WHERE Email='$naam' AND Status='Admin'";
$stmt = $conn->prepare($sql_user);
// $stmt->bind_param("s", $naam);
$stmt->execute();
$result_subadmin = $stmt->get_result();

if ($result_subadmin->num_rows === 1) {
    $row_user = $result_subadmin->fetch_assoc();

    // Use password_verify to compare submitted password with hashed password
    if (password_verify($code, $row_user['Password'])) {
        $_SESSION['id'] = $row_user['id'];
    $_SESSION['name'] = $row_user['Name'];
    $_SESSION['email'] = $naam;
    $_SESSION['status'] = $row_user['Status'];

        header("Location: ../subadmin/index.php");
        exit();
    } else {
        // Wrong password
        echo "<script>
                alert('Invalid Login Credentials');
                window.location.href = 'subadmin.php';
              </script>";
        exit();
    }
} else {
    // No user found
    echo "<script>
            alert('Invalid Login Credentials');
            window.location.href = 'subadmin.php';
          </script>";
    exit();
}
?>
