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
    echo "No Job Opening selected.";
    exit();
}
$job_id = $_GET['id'];

// Fetch the existing service data
$sql_service = "SELECT * FROM job_openings WHERE id = $job_id";
$result_service = $conn->query($sql_service);

if ($result_service->num_rows == 0) {
    echo "Service not found.";
    exit();
}
$service = $result_service->fetch_assoc();


// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $job_title = $_POST['job_title'];
$who_can_apply = $_POST['who_can_apply'];
$about_job = $_POST['about_job'];


    $sql = "UPDATE job_openings SET 
        job_title = '$job_title',
        who_can_apply = '$who_can_apply',
        about_job = '$about_job',
        created_at = NOW()
        WHERE id = $job_id";

if ($conn->query($sql)) {
    echo "<script>alert('Job Opening Updated Successfully'); window.location='manage-jobs.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
}

?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Update Job Opening</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                           <label>Job Title</label>
    <input type="text" name="job_title" class="form-control" value="<?= $service['job_title'] ?>" required>
</div>
<div class="col-md-6">
<label>Who Can Apply</label>
    <textarea name="who_can_apply" class="form-control" required><?php echo htmlspecialchars($service['who_can_apply']); ?></textarea>
    </div>
    
    <div class="col-md-12">
          <label>About the Job</label>
    <textarea name="about_job" required class="form-control"><?php echo htmlspecialchars($service['about_job']); ?></textarea><br>
                        <script>CKEDITOR.replace('about_job');</script><br>
    </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Update Job Opening</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>
