<?php
include("config/connection.php");

$userid = $_POST['userid'];
$services = $_POST['services']; // Array of selected services

// Fetch currently assigned services
$query = "SELECT Assigned_Services FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($assignedServices);
$stmt->fetch();
$stmt->close();

// Convert to array and merge with new services
$existingServices = !empty($assignedServices) ? explode(',', $assignedServices) : [];
$updatedServices = array_merge($existingServices, $services);

// Update assigned services in the database
$assignedServicesStr = implode(',', $updatedServices);
$query = "UPDATE user SET Assigned_Services = ? WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $assignedServicesStr, $userid);
$stmt->execute();
$stmt->close();

echo "<script>alert('Services assigned successfully'); window.location.href='registered-users.php';</script>";
?>
