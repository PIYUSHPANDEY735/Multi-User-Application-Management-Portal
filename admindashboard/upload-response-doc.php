<?php
session_start(); // Ensure session is started
include("config/connection.php");

$user_id = $_POST['user_id'];
$service_id = $_POST['service_id'];
$created_at = $_POST['created_at'];
$admin_id = $_SESSION['admin_id'] ?? 0; // Fallback if session not set

// Upload logic
$upload_dir = "../userdata/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0775, true); // Ensure directory exists
}

$filename = $_FILES['document']['name'];
$tmpname = $_FILES['document']['tmp_name'];
$file_extension = pathinfo($filename, PATHINFO_EXTENSION);
$unique_filename = time() . "_" . basename($filename);
$filepath = $upload_dir . $unique_filename;

// Only proceed if file is uploaded and moved successfully
if (is_uploaded_file($tmpname) && move_uploaded_file($tmpname, $filepath)) {
    // Save to database (insert or update existing entry)
    $sql = "INSERT INTO form_submission_responses (user_id, service_id, created_at, document_path, updated_by)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                document_path = VALUES(document_path),
                updated_by = VALUES(updated_by),
                updated_at = CURRENT_TIMESTAMP";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $user_id, $service_id, $created_at, $filepath, $admin_id);
    $stmt->execute();
}

// Redirect back to manage submissions
header("Location: manage-submissions.php");
exit;
?>
