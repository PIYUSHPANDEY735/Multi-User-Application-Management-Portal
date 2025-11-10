<?php
include("config/connection.php");

$query = "SELECT id, service_name FROM mca_services";
$result = $conn->query($query);

$services = [];

while ($row = $result->fetch_assoc()) {
    $services[] = ['id' => $row['id'], 'name' => $row['service_name']];
}

header('Content-Type: application/json');
echo json_encode($services);
?>