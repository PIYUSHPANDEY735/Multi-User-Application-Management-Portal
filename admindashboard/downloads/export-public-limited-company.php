<?php
include('./config/connection.php'); // Ensure correct path to your connection file

header('Content-Type: application/json'); // Response will be in JSON format

try {
    // Fetch specific columns if needed, or use `*` for all columns
    $sql = "SELECT id, userid, company_name, nature_of_business, authorized_capital, registered_office_address, director_full_name, director_din, director_residential_address, director_email, director_phone, shareholder_full_name, 	number_of_shares, declaration_of_compliance, created_at, current_status  FROM public_limited_company";
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
