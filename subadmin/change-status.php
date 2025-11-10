<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config/connection.php");

$id = $_GET['id']; // Fetch correct user id
$status = $_GET['status']; // Fetch correct status

if ($status === 'Admin') {
    echo "<script>alert('This user is already an admin. Services cannot be assigned.'); window.location.href='registered-users.php';</script>";
} else {
    // Toggle the status between 'User' and 'Admin'
    $new_status = ($status === 'User') ? 'Admin' : 'User';
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE user SET Status = ? WHERE userid = ?");
    $stmt->bind_param("si", $new_status, $id);
    
    if ($stmt->execute()) {
        // If the status is successfully updated
        echo "<script>alert('Status updated successfully.'); window.location.href='registered-users.php';</script>";
        // echo "Status Updated Successfully";
    } else {
        // If there was an error updating the status
        echo "<script>alert('Failed to update status. Please try again.'); window.location.href='registered-users.php';</script>";
        // echo "Cannot Update the Status ";
    }
}
?>
