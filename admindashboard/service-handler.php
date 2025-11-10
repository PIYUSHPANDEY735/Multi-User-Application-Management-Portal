<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_start(); Comment OUt at 16/11 10:58AM
include("config/connection.php");

if (isset($_POST['create_service'])) {
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];

    // Handle banner upload
    $target_dir = "../serviceimages/";
    $banner_image = $target_dir . basename($_FILES['banner_image']['name']);
    move_uploaded_file($_FILES['banner_image']['tmp_name'], $banner_image);

    // Insert service details into 'services' table
    $sql = "INSERT INTO services (service_name, service_description, banner_image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $service_name, $service_description, $banner_image);
    $stmt->execute();
    $service_id = $stmt->insert_id;

    // Insert benefits into 'service_benefits' table
    foreach ($_POST['benefit_text'] as $key => $benefit_text) {
        $benefit_icon = $_POST['benefit_icon'][$key];
        $sql_benefit = "INSERT INTO service_benefits (service_id, benefit_text, benefit_icon) VALUES (?, ?, ?)";
        $stmt_benefit = $conn->prepare($sql_benefit);
        $stmt_benefit->bind_param('iss', $service_id, $benefit_text, $benefit_icon);
        $stmt_benefit->execute();
    }

    // Insert required documents into 'service_documents' table
    foreach ($_POST['document_text'] as $key => $document_text) {
        $document_icon = $_POST['document_icon'][$key];
        $sql_document = "INSERT INTO service_documents (service_id, document_text, document_icon) VALUES (?, ?, ?)";
        $stmt_document = $conn->prepare($sql_document);
        $stmt_document->bind_param('iss', $service_id, $document_text, $document_icon);
        $stmt_document->execute();
    }

    echo "Service Created Successfully!";
}
?>
