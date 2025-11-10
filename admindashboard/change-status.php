<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_start(); Comment OUt at 16/11 10:58AM
include("config/connection.php");

$id = $_GET['id']; // Fetch correct user id
$status = $_GET['status']; // Fetch correct status

if ($status === 'Admin') {
    // If already an Admin, provide the option to demote to User
    $new_status = 'User';
    
    // Update the user's status to 'User'
    $stmt = $conn->prepare("UPDATE user SET Status = ?, Assigned_Services = '' WHERE userid = ?");
    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        // Clear assigned services in the individual service tables (assigned_admins column)
        $serviceTables = ['private_limited_company', 'one_person_company', 'limited_liability_partnership', 'public_limited_company', 'basic_partnership_firm', 'basic_proprietorship', 'import_export_code', 'gst_registration', 'balance_sheet', 'income_tax_return', 'fssai_registration', 'tan_registration', 'msme_registration', 'gst_return'];
        
        foreach ($serviceTables as $table) {
            // Set assigned_admins to 'No Admin' for the relevant user in each service table
            $clearAssignedStmt = $conn->prepare("UPDATE $table SET assigned_admins = 'No Admin' WHERE assigned_admins = (SELECT Name FROM user WHERE userid = ?)");
            $clearAssignedStmt->bind_param("i", $id);
            $clearAssignedStmt->execute();
            $clearAssignedStmt->close();
        }

        echo "<script>alert('Admin converted to User successfully and Assigned Services are cleared.'); window.location.href='registered-users.php';</script>";
    } else {
        echo "<script>alert('Failed to update status. Please try again.'); window.location.href='registered-admins.php';</script>";
    }
} else {
    // Promote User to Admin
    $new_status = 'Admin';
    
    // Prepare SQL to change status to Admin
    $stmt = $conn->prepare("UPDATE user SET Status = ? WHERE userid = ?");
    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User converted to Admin successfully.'); window.location.href='registered-admins.php';</script>";
    } else {
        echo "<script>alert('Failed to update status. Please try again.'); window.location.href='registered-users.php';</script>";
    }
}

?>
