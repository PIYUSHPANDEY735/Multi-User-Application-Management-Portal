<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

// Get the service ID to update
if (!isset($_GET['id'])) {
    echo "No service selected.";
    exit();
}
$service_id = $_GET['id'];

// Fetch the existing service data
$sql_service = "SELECT * FROM offers WHERE id = $service_id";
$result_service = $conn->query($sql_service);

if ($result_service->num_rows == 0) {
    echo "Service not found.";
    exit();
}
$service = $result_service->fetch_assoc();


// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page_title = $conn->real_escape_string($_POST['page_title']);
    $page_heading = $conn->real_escape_string($_POST['page_heading']);
    $page_content = $conn->real_escape_string($_POST['page_content']);

    // Handle file upload for banner
    if (!empty($_FILES["page_banner"]["name"])) {
        $target_dir = "../userdata/";
        $page_banner = $target_dir . basename($_FILES["page_banner"]["name"]);
        move_uploaded_file($_FILES["page_banner"]["tmp_name"], $page_banner);
    } else {
        $page_banner = $service['page_banner']; // Keep the old banner if no new one is uploaded
    }

    
    // Update the service data
    $sql_update_service = "UPDATE offers SET 
        page_title = '$page_title',
        page_heading = '$page_heading',
        page_banner = '$page_banner',
        page_content = '$page_content'
        WHERE id = $service_id";
    
    if ($conn->query($sql_update_service)) {
        echo "Service updated successfully!";
        // header("Location: mca_services.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Update Our Offers</h2>
            <form method="POST" enctype="multipart/form-data">
                <!-- Service Fields -->
                <div class="row">
                    <div class="col-md-6">
                        <label for="page_title">Page Title</label>
                        <input type="text" class="form-control" id="page_title" name="page_title" value="<?= $service['page_title'] ?>" required>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="page_heading">Page Heading</label>
                        <input type="text" class="form-control" id="page_heading" name="page_heading" value="<?= $service['page_heading'] ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="page_content" class="form-label">Page Content</label>
                        <textarea class="form-control" id="page_content" name="page_content" required><?php echo htmlspecialchars($service['page_content']); ?></textarea><br>
                        <script>
                            CKEDITOR.replace('page_content');
                        </script><br>
                    </div>
                    <div class="col-md-6">
                        <label for="page_banner">Page Banner</label>
                        <input type="file" class="form-control" id="page_banner" name="page_banner">
                        <img src="<?= $service['page_banner'] ?>" alt="Banner" style="width: 100%; margin-top: 10px;">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>
