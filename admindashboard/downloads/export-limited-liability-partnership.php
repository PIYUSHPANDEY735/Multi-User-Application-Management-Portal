<?php
include('./config/connection.php'); // Ensure correct path to your connection file

header('Content-Type: application/json'); // Response will be in JSON format

try {
    // Fetch specific columns if needed, or use `*` for all columns
    $sql = "SELECT id, userid, llp_name, partner1_name, partner1_pan, partner2_name, partner2_pan, office_address, email, phone, created_at,  current_status  FROM limited_liability_partnership";
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
