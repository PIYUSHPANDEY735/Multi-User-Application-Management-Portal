<?php
include("config/connection.php");

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    $stmt = $conn->prepare("SELECT Assigned_Services FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && !empty($user['Assigned_Services'])) {
        $assigned_names = array_map('trim', explode(',', $user['Assigned_Services']));

        // Prepare a placeholder query string for service_name
        $placeholders = implode(',', array_fill(0, count($assigned_names), '?'));
        $types = str_repeat('s', count($assigned_names));

        // Prepare and execute query
        $stmt2 = $conn->prepare("SELECT id, service_name FROM mca_services WHERE service_name IN ($placeholders)");
        $stmt2->bind_param($types, ...$assigned_names);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $assigned_ids = [];
        while ($row = $result2->fetch_assoc()) {
            $assigned_ids[] = $row['id'];
        }

        echo json_encode($assigned_ids);
    } else {
        echo json_encode([]);
    }
}
?>
