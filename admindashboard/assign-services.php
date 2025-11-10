<?php
include("config/connection.php");

$userid = $_POST['userid'];
$services = isset($_POST['services']) ? $_POST['services'] : []; // Array of selected services

// Fetch currently assigned services
$query = "SELECT Assigned_Services FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($assignedServices);
$stmt->fetch();
$stmt->close();

// Convert to array and merge with new services (while keeping deselected in mind)
$existingServices = !empty($assignedServices) ? explode(',', $assignedServices) : [];
$updatedServices = array_unique(array_merge($existingServices, $services));

// Remove deselected services
if (!empty($existingServices)) {
    $updatedServices = array_filter($updatedServices, function($service) use ($services) {
        return in_array($service, $services); // Keep only selected services
    });
}

// Update assigned services in the database
$assignedServicesStr = implode(',', $updatedServices);
$query = "UPDATE user SET Assigned_Services = ? WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $assignedServicesStr, $userid);
$stmt->execute();
$stmt->close();

// Now update the assigned_admins column in the relevant service tables
foreach ($updatedServices as $service) {
    $serviceTable = getServiceTableName($service); // You need a function that maps service names to table names
    $query = "UPDATE $serviceTable SET assigned_admins = ? WHERE assigned_admins = 'No Admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['name']);
    $stmt->execute();
    $stmt->close();
}

echo "<script>alert('Services updated successfully'); window.location.href='registered-admins.php';</script>";

function getServiceTableName($serviceName) {
    $serviceTables = [
       'Basic Partnership Firm' => 'basic_partnership_firm',
    'Basic Proprietorship' => 'basic_proprietorship',
    'Balance Sheet' => 'balance_sheet',
    'Private Limited Company' => 'private_limited_company',
    'GST Registration' => 'gst_registration',
    'GST Return' => 'gst_return',
    'Import Export Code' => 'import_export_code',
    'Income Tax Return' => 'income_tax_return',
    'Limited Liability Partnership' => 'limited_liability_partnership',
    'MSME Registration' => 'msme_registration',
    'FSSAI Registration' => 'fssai_registration',
    'One Person Company' => 'one_person_company',
    'Tan Registration' => 'tan_registration'  
    ];

    return isset($serviceTables[$serviceName]) ? $serviceTables[$serviceName] : '';
}


?>