<?php
include("config/connection.php");

// Validate incoming parameters
if (isset($_GET['formid'], $_GET['submitted'], $_GET['action'])) {
    $form_id = intval($_GET['formid']);
    $created_at = $_GET['submitted'];
    $action = $_GET['action'];

    // Allow only Approve or Decline
    $valid_actions = ['Approve', 'Decline'];
    if (!in_array($action, $valid_actions)) {
        echo "<script>alert('Invalid action.'); window.history.back();</script>";
        exit;
    }

    // Set new status
    $new_status = ($action === 'Approve') ? 'Approved' : 'Declined';

    // Update form submission based on form ID and submission time
    $query = "UPDATE form_submissions SET current_status = ? WHERE service_id = ? AND created_at = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $new_status, $form_id, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully!'); window.history.back();</script>";
    } else {
        echo "<script>alert('Failed to update status. Please try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Missing required parameters.'); window.history.back();</script>";
}
?>
