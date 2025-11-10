<?php
session_start();
include("config/connection.php");

$user_id = $_POST['user_id'];
$service_id = $_POST['service_id'];
$created_at = $_POST['created_at'];
$action_text = $_POST['action_text'];
$admin_id = $_SESSION['admin_id'] ?? 0;

// Upsert into the table (insert or update)
$sql = "INSERT INTO form_submission_responses (user_id, service_id, created_at, action_text, updated_by)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            action_text = VALUES(action_text),
            updated_by = VALUES(updated_by),
            updated_at = CURRENT_TIMESTAMP";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iissi", $user_id, $service_id, $created_at, $action_text, $admin_id);
$stmt->execute();

header("Location: manage-submissions.php");
exit;
?>