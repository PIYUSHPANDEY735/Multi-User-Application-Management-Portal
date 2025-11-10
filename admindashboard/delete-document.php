<?php
session_start();
include("config/connection.php");

$user_id = $_GET['uid'];
$service_id = $_GET['sid'];
$created_at = $_GET['submitted'];

// Get existing document path
$sql = "SELECT document_path FROM form_submission_responses WHERE user_id = ? AND service_id = ? AND created_at = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $service_id, $created_at);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $doc_path = $row['document_path'];

    // Delete file from server
    if (file_exists($doc_path)) {
        unlink($doc_path);
    }

    // Update record to remove path
    $update_sql = "UPDATE form_submission_responses SET document_path = NULL WHERE user_id = ? AND service_id = ? AND created_at = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("iis", $user_id, $service_id, $created_at);
    $update_stmt->execute();
}

header("Location: manage-submissions.php");
exit;
?>
