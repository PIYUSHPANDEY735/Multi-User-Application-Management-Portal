<?php
include('./config/connection.php'); // Ensure correct path to your connection file

header('Content-Type: application/json'); // Response will be in JSON format

try {
    // Fetch specific columns if needed, or use `*` for all columns
    $sql = "SELECT id, userid, name, email, phone, pan, business_address, bank_details, created_at, current_status  FROM import_export_code";
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
