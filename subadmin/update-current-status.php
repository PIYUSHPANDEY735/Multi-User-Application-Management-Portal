<?php
include("config/connection.php");

$id = $_GET['id'];
$action = $_GET['action'];

// Assume you're passing the service table dynamically
$table = $_GET['service_table']; // e.g., 'balance_sheet', 'gst_registration', etc.

// Set the status based on the action
$new_status = ($action === 'Approve') ? 'Approved' : 'Declined';

// Update the status in the relevant service table
$query = "UPDATE $table SET current_status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_status, $id);

if ($stmt->execute()) {
    echo "<script>alert('Status updated successfully!'); window.history.back();</script>";
} else {
    echo "<script>alert('Failed to update status. Please try again.'); window.history.back();</script>";
}
?>
