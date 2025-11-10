<?php
include('./config/connection.php'); // Ensure correct path to your connection file

header('Content-Type: application/json'); // Response will be in JSON format

try {
    // Fetch specific columns if needed, or use `*` for all columns
    $sql = "SELECT id, userid, company_name, director_full_name, director_pan_card_number, registered_office_address, email_address, phone_number, created_at, current_status  FROM private_limited_company";
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
