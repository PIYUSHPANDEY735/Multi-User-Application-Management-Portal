<?php
session_start();
include("config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];  // Get the user ID from the hidden input
    $services = implode(',', $_POST['services']);  // Join the selected services into a comma-separated string

    // Update the user table with the assigned services
    $stmt = $conn->prepare("UPDATE user SET assigned_services = ? WHERE userid = ?");
    $stmt->bind_param("si", $services, $userid);
    if ($stmt->execute()) {
        echo "<script>
                alert('Services assigned successfully!');
                window.location.href = 'registered-users.php'; // Reload the page to reflect changes
              </script>";
    } else {
        echo "<script>
                alert('Error assigning services.');
                window.location.href = 'registered-users.php'; // Reload the page to reflect changes
              </script>";
    }
}
?>
