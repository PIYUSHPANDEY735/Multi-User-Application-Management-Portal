<?php
include("config/connection.php");

if (isset($_GET['q'])) {
    $q = '%' . $_GET['q'] . '%';
    $stmt = $conn->prepare("SELECT id, service_name, slug FROM mca_services WHERE service_name LIKE ?");
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $result = $stmt->get_result();

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    echo json_encode($services);
}
?>
