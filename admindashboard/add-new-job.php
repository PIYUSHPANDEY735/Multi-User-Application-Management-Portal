<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $job_title = $_POST['job_title'];
$who_can_apply = $_POST['who_can_apply'];
$about_job = $_POST['about_job'];

$sql = "INSERT INTO job_openings (job_title, who_can_apply, about_job, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $job_title, $who_can_apply, $about_job);

if ($stmt->execute()) {
    echo "<script>alert('Job created successfully'); window.location='manage-jobs.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
}

?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<style>
    .cke_notification_warning{
        display:none !important;
    }
</style>
<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Add New Job Opening</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                           <label>Job Title</label>
    <input type="text" name="job_title" required class="form-control">
</div>
<div class="col-md-6">
<label>Who Can Apply</label>
    <textarea name="who_can_apply" required class="form-control"></textarea>
    </div>
    
    <div class="col-md-12">
          <label>About the Job</label>
    <textarea name="about_job" required class="form-control"></textarea><br>
                        <script>CKEDITOR.replace('about_job');</script><br>
    </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Create New Job</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

include("includes/footer.php");

?>