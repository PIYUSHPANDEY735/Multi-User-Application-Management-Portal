<?php

include("includes/header.php");
include("includes/navbar.php");

?>

<?php
include("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $what_is_service = $_POST['what_is_service'];
    
    // For the Banner Upload
    $banner_image = $_FILES['banner_image'];
    $banner_image_name = $banner_image['name'];
    $banner_image_tmp = $banner_image['tmp_name'];
    $upload_dir = '../serviceimages/';
    
    // Move the uploaded file to the specified directory
    $banner_image_path = $upload_dir . $banner_image_name;
    move_uploaded_file($banner_image_tmp, $banner_image_path);
    
    // Insert the service into the database
    $query = "INSERT INTO services (service_name, service_description, banner_image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $service_name, $what_is_service, $banner_image_name);
    $stmt->execute();

    // Get the service_id of the newly created service
    $service_id = $stmt->insert_id;

    // Insert benefits and required documents
    foreach ($_POST['benefits'] as $key => $benefit) {
        $benefit_icon = $_POST['benefit_icons'][$key];
        $query_benefits = "INSERT INTO service_benefits (service_id, benefit_text, benefit_icon) VALUES (?, ?, ?)";
        $stmt_benefits = $conn->prepare($query_benefits);
        $stmt_benefits->bind_param("iss", $service_id, $benefit, $benefit_icon);
        $stmt_benefits->execute();
    }

    foreach ($_POST['documents'] as $key => $document) {
        $document_icon = $_POST['document_icons'][$key];
        $query_documents = "INSERT INTO service_documents (service_id, document_text, document_icon) VALUES (?, ?, ?)";
        $stmt_documents = $conn->prepare($query_documents);
        $stmt_documents->bind_param("iss", $service_id, $document, $document_icon);
        $stmt_documents->execute();
    }

   echo "<script>
            alert('Service Created Successfully!');
            window.location.href = 'updated-services.php'; // Redirect to dashboard or service list
          </script>";
}
?>

 <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }
        h1, h3 {
            color: #007bff;
        }
        .add-btn {
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 10px;
        }
        .remove-btn {
            color: #dc3545;
            border: none;
            background: none;
        }
        .remove-btn:hover {
            color: #ff4b5c;
        }
    </style>

<!--inner block start here-->

<div class="inner-block">


<div class="container mt-5">
    <h2>Create a New Service</h2>
    <form action="create-service.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
        </div>

        <div class="mb-3">
            <label for="what_is_service" class="form-label">What is the Service?</label>
            <textarea class="form-control" id="what_is_service" name="what_is_service" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="banner_image" class="form-label">Upload Banner (1600px x 500px)</label>
            <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*" required>
        </div>

        <div id="benefits_section">
            <h4>Benefits</h4>
            <div class="benefit-group mb-3">
                <label for="benefit_icons[]" class="form-label">Benefit Icon Code</label>
                <input type="text" class="form-control mb-2" name="benefit_icons[]" placeholder="Icon code (e.g., fas fa-check-circle)" required>
                <label for="benefits[]" class="form-label">Benefit Text</label>
                <input type="text" class="form-control" name="benefits[]" placeholder="Benefit description" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-benefit-btn">Add Another Benefit</button>

        <div id="documents_section">
            <h4>Required Documents</h4>
            <div class="document-group mb-3">
                <label for="document_icons[]" class="form-label">Document Icon Code</label>
                <input type="text" class="form-control mb-2" name="document_icons[]" placeholder="Icon code (e.g., fas fa-id-card)" required>
                <label for="documents[]" class="form-label">Document Text</label>
                <input type="text" class="form-control" name="documents[]" placeholder="Document description" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-document-btn">Add Another Document</button>

        <button type="submit" class="btn btn-primary">Create Service</button>
    </form>
</div>



</div>
<!--inner block end here-->

<script>
    document.getElementById('add-benefit-btn').addEventListener('click', function () {
        const benefitSection = document.getElementById('benefits_section');
        const newBenefitGroup = document.createElement('div');
        newBenefitGroup.classList.add('benefit-group', 'mb-3');
        newBenefitGroup.innerHTML = `
            <label for="benefit_icons[]" class="form-label">Benefit Icon Code</label>
            <input type="text" class="form-control mb-2" name="benefit_icons[]" placeholder="Icon code (e.g., fas fa-check-circle)" required>
            <label for="benefits[]" class="form-label">Benefit Text</label>
            <input type="text" class="form-control" name="benefits[]" placeholder="Benefit description" required>
        `;
        benefitSection.appendChild(newBenefitGroup);
    });

    document.getElementById('add-document-btn').addEventListener('click', function () {
        const documentSection = document.getElementById('documents_section');
        const newDocumentGroup = document.createElement('div');
        newDocumentGroup.classList.add('document-group', 'mb-3');
        newDocumentGroup.innerHTML = `
            <label for="document_icons[]" class="form-label">Document Icon Code</label>
            <input type="text" class="form-control mb-2" name="document_icons[]" placeholder="Icon code (e.g., fas fa-id-card)" required>
            <label for="documents[]" class="form-label">Document Text</label>
            <input type="text" class="form-control" name="documents[]" placeholder="Document description" required>
        `;
        documentSection.appendChild(newDocumentGroup);
    });
</script>

<?php

include("includes/footer.php");

?>