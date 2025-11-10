<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

if (!isset($_GET['id'])) {
    echo "No service selected.";
    exit();
}

$id = $_GET['id']; // Blog ID from URL

// Fetch existing blog data
$sql = "SELECT * FROM blogs WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blog_name = $conn->real_escape_string($_POST['blog_name']);
    $blog_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $blog_name))); // Slugify blog name

    $blog_display_name = $conn->real_escape_string($_POST['blog_display_name']);
    $blog_written_by = $conn->real_escape_string($_POST['blog_written_by']);
    $blog_posted_date = $conn->real_escape_string($_POST['blog_posted_date']);
    $blog_meta_title = $conn->real_escape_string($_POST['blog_meta_title']);
    $blog_meta_description = $conn->real_escape_string($_POST['blog_meta_description']);
    $blog_meta_keywords = $conn->real_escape_string($_POST['blog_meta_keywords']);
    $blog_short_description = $conn->real_escape_string($_POST['blog_short_description']);
    $blog_content = $conn->real_escape_string($_POST['blog_content']);

    if (!empty($_FILES["blog_image"]["name"])) {
        $target_dir = "../userdata/";
        $blog_image = $target_dir . basename($_FILES["blog_image"]["name"]);
        move_uploaded_file($_FILES["blog_image"]["tmp_name"], $blog_image);
    } else {
        $blog_image = $row['blog_image'];
    }

    $sql_update = "UPDATE blogs SET 
        blog_name = '$blog_name',
        blog_slug = '$blog_slug',
        blog_display_name = '$blog_display_name',
        blog_written_by = '$blog_written_by',
        blog_posted_date = '$blog_posted_date',
        meta_title = '$blog_meta_title',
        meta_description = '$blog_meta_description',
        meta_keywords = '$blog_meta_keywords',
        short_description = '$blog_short_description',
        blog_content = '$blog_content',
        blog_image = '$blog_image'
        WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Blog updated successfully!'); window.location.href='manage-blogs.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<style>
    .cke_notification_warning{
        display:none !important;
    }
</style>
<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2 class="text-center">Update Blog</h2>
           <form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Blog Name / Slug</label>
            <input type="text" name="blog_name" class="form-control" value="<?= $row['blog_name'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Blog Display Name</label>
            <input type="text" name="blog_display_name" class="form-control" value="<?= $row['blog_display_name'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Blog Written By</label>
            <input type="text" name="blog_written_by" class="form-control" value="<?= $row['blog_written_by'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Blog Posted Date</label>
            <input type="date" name="blog_posted_date" class="form-control" value="<?= $row['blog_posted_date'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Meta Title</label>
            <input type="text" name="blog_meta_title" class="form-control" value="<?= $row['meta_title'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Meta Description</label>
            <input type="text" name="blog_meta_description" class="form-control" value="<?= $row['meta_description'] ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Meta Keywords</label>
            <input type="text" name="blog_meta_keywords" class="form-control" value="<?= $row['meta_keywords'] ?>" required>
        </div>
        <div class="col-md-12 mb-3">
            <label>Short Description</label>
            <textarea name="blog_short_description" class="form-control" required><?= $row['short_description'] ?></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <label>Content</label>
            <textarea name="blog_content" class="form-control" required><?= $row['blog_content'] ?></textarea>
            <script>CKEDITOR.replace('blog_content');</script>
        </div>
        <div class="col-md-6 mb-3">
            <label>Blog Image</label>
            <input type="file" name="blog_image" class="form-control" accept="image/*">
            <p class="mt-2">Current Image:</p>
            <img src="<?= $row['blog_image'] ?>" style="max-width: 200px;">
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Update Blog</button>
    </div>
</form>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>