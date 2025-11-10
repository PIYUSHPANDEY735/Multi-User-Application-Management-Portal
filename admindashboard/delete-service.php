<?php
include('config/connection.php');

if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    // Check if service exists before deleting
    $checkService = "SELECT page_title FROM mca_services WHERE id = ?";
    $stmt_check = $conn->prepare($checkService);
    $stmt_check->bind_param('i', $service_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        echo "<script>alert('Service not found!'); window.location.href = 'manage-services.php';</script>";
        exit();
    }

    $row = $result_check->fetch_assoc();
    $page_title = $row['page_title'];

    // Delete related records
    $queries = [
        "DELETE FROM mca_services_enquiries WHERE Purpose = ?" => 's',
        "DELETE FROM forms WHERE service_id = ?" => 'i',
        "DELETE FROM form_submissions WHERE service_id = ?" => 'i',
        "DELETE FROM mca_services_documents WHERE service_id = ?" => 'i',
        "DELETE FROM mca_service_benefits WHERE service_id = ?" => 'i',
        "DELETE FROM mca_service_faqs WHERE service_id = ?" => 'i',
        "DELETE FROM mca_service_testimonials WHERE service_id = ?" => 'i',
        "DELETE FROM mca_services WHERE id = ?" => 'i'
    ];

    foreach ($queries as $sql => $type) {
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $value = ($type === 's') ? $page_title : $service_id;
            $stmt->bind_param($type, $value);
            if (!$stmt->execute()) {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error in preparing statement.');</script>";
        }
    }

    echo "<script>
            alert('Service Deleted Successfully!');
            window.location.href = 'manage-services.php';
          </script>";
}
?>
