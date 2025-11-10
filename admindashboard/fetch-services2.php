<?php
include("config/connection.php");

$userid = $_GET['userid'];

// Get all services
$allServices = ['Private Limited Company', 'One Person Company', 'Limited Liability Partnership', 'Public Limited Company','Basic Partnership Firm', 'Basic Proprietorship','Import Export Code', 'GST Registration', 'Balance Sheet', 'Income Tax Return', 'FSSAI Registration','Tan Registration','MSME Registration','GST Return'];

// Fetch assigned services for the user
$query = "SELECT Assigned_Services FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($assignedServices);
$stmt->fetch();
$stmt->close();

// Convert assigned services to array
$assignedServicesArray = !empty($assignedServices) ? explode(',', $assignedServices) : [];

// Get available services by excluding assigned ones
$availableServices = array_diff($allServices, $assignedServicesArray);

// Return as JSON
echo json_encode([
    'availableServices' => $availableServices,
    'assignedServices' => $assignedServicesArray
]);
?>
