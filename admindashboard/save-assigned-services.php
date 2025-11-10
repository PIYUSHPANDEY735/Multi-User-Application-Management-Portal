<?php
include("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $service_ids = isset($_POST['services']) ? $_POST['services'] : [];

    if (!empty($service_ids)) {
        // Convert IDs to integers for safety
        $placeholders = implode(',', array_fill(0, count($service_ids), '?'));
        $types = str_repeat('i', count($service_ids));

        $stmt = $conn->prepare("SELECT service_name FROM mca_services WHERE id IN ($placeholders)");

        // Bind parameters dynamically
        $stmt->bind_param($types, ...$service_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        $service_names = [];
        while ($row = $result->fetch_assoc()) {
            $service_names[] = $row['service_name'];
        }

        // Convert service names to comma-separated string
        $services = implode(',', $service_names);

    } else {
        $services = '';
    }

    $updateStmt = $conn->prepare("UPDATE user SET Assigned_Services = ? WHERE id = ?");
    $updateStmt->bind_param("si", $services, $user_id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Services assigned successfully!'); window.location.href = 'registered-admins.php';</script>";
    } else {
        echo "<script>alert('Failed to assign services.'); window.history.back();</script>";
    }
}
?>
