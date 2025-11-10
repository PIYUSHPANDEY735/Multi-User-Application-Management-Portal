<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

// Get service ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Service ID is missing!";
    exit();
}

$service_id = intval($_GET['id']);

// Delete service and related data
$sql_delete_service = "DELETE FROM mca_services WHERE id = '$service_id'";
$sql_delete_forms = "DELETE FROM forms WHERE service_id = '$service_id'";

if ($conn->query($sql_delete_service) === TRUE && $conn->query($sql_delete_forms) === TRUE) {
    echo "Service and related form fields deleted successfully!";
    header("Location: mca_services.php"); // Redirect to service listing
    exit();
} else {
    echo "Error deleting service: " . $conn->error;
}

include("includes/footer.php");
?>
