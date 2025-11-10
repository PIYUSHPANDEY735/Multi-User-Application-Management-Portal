<?php
session_start();
include("config/connection.php");

$user_id = $_POST['user_id'];
$service_id = $_POST['service_id'];
$created_at = $_POST['created_at'];
$remarks = $_POST['remarks'];
$admin_id = $_SESSION['admin_id'] ?? 0;

// Upsert into the table (insert or update)
$sql = "INSERT INTO form_submission_responses (user_id, service_id, created_at, remarks, updated_by)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            remarks = VALUES(remarks),
            updated_by = VALUES(updated_by),
            updated_at = CURRENT_TIMESTAMP";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iissi", $user_id, $service_id, $created_at, $remarks, $admin_id);
$stmt->execute();

header("Location: manage-submissions.php");
exit;
?>