<?php
include('./config/connection.php'); // Ensure correct path to your connection file

header('Content-Type: application/json'); // Response will be in JSON format

try {
    // Fetch specific columns if needed, or use `*` for all columns
    $sql = "SELECT 
        service_id, 
        user_id, 
        current_status, 
        created_at 
    FROM form_submissions 
    GROUP BY service_id, created_at
    ORDER BY created_at DESC";
    $result = $conn->query($sql);

    // Store results in an array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data); // Output data as JSON
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
