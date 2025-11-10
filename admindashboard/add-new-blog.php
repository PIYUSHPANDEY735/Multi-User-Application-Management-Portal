<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php"); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 
    $blog_slug = strtolower(str_replace(" ", "-", $conn->real_escape_string($_POST['blog_name']))); 
$blog_name = $conn->real_escape_string($_POST['blog_name']); 
$blog_display_name = $conn->real_escape_string($_POST['blog_display_name']); 
$blog_written_by = $conn->real_escape_string($_POST['blog_written_by']); 
$blog_posted_date = $conn->real_escape_string($_POST['blog_posted_date']); 
$meta_title = $conn->real_escape_string($_POST['meta_title']); 
$meta_description = $conn->real_escape_string($_POST['meta_description']); 
$meta_keywords = $conn->real_escape_string($_POST['meta_keywords']); 
$short_description = $conn->real_escape_string($_POST['short_description']); 
$content = $conn->real_escape_string($_POST['content']); 
// Handle file upload 
$target_dir = "../userdata/"; $blog_image = $target_dir . basename($_FILES["blog_image"]["name"]); move_uploaded_file($_FILES["blog_image"]["tmp_name"], $blog_image); $sql = "INSERT INTO blogs (blog_slug, blog_name, blog_display_name, blog_written_by, blog_posted_date, meta_title, meta_description, meta_keywords, short_description, blog_content, blog_image) VALUES ('$blog_slug', '$blog_name', '$blog_display_name', '$blog_written_by', '$blog_posted_date', '$meta_title', '$meta_description', '$meta_keywords', '$short_description', '$content', '$blog_image')"; if ($conn->query($sql) === TRUE) { echo "<script>alert('Blog added successfully!'); window.location.href='manage-blogs.php';</script>"; } 
else { echo "Error: " . $conn->error; } 
} ?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<style>
    .cke_notification_warning{
        display:none !important;
    }
</style>
<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Add New Blog</h2>
           <form method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-4 mb-3"> <label for="blog_name" class="form-label">Blog Name (Slug)</label>
      <p style="color:#ffaa0a;">*Do Not Use Special Characters</p> <input type="text" class="form-control"
        id="blog_name" name="blog_name" required>
    </div>
    <div class="col-md-4 mb-3"> <label for="blog_display_name" class="form-label">Blog Display Name</label> <input
        type="text" class="form-control" id="blog_display_name" name="blog_display_name" required> </div>
    <div class="col-md-4 mb-3"> <label for="blog_written_by" class="form-label">Written By</label> <input type="text"
        class="form-control" id="blog_written_by" name="blog_written_by" required> </div>
    <div class="col-md-4 mb-3"> <label for="blog_posted_date" class="form-label">Posted Date</label> <input type="date"
        class="form-control" id="blog_posted_date" name="blog_posted_date" required> </div>
    <div class="col-md-4 mb-3"> <label for="meta_title" class="form-label">Meta Title</label> <input type="text"
        class="form-control" id="meta_title" name="meta_title" required> </div>
    <div class="col-md-4 mb-3"> <label for="meta_description" class="form-label">Meta Description</label> <input
        type="text" class="form-control" id="meta_description" name="meta_description" required> </div>
    <div class="col-md-4 mb-3"> <label for="meta_keywords" class="form-label">Meta Keywords</label> <input type="text"
        class="form-control" id="meta_keywords" name="meta_keywords" required> </div>
    <div class="col-md-8 mb-3"> <label for="short_description" class="form-label">Short Description</label> <textarea
        class="form-control" id="short_description" name="short_description" rows="3" required></textarea> </div>
    <div class="col-md-6 mb-3"> <label for="content" class="form-label">Blog Content</label> <textarea
        class="form-control" id="content" name="content" required></textarea>
      <script>CKEDITOR.replace('content');</script>
    </div>
    <div class="col-md-6 mb-3"> <label for="blog_image" class="form-label">Blog Image</label> <input type="file"
        class="form-control" id="blog_image" name="blog_image" accept="image/*" required> </div>
  </div>
  <div class="text-center mt-3">
    <button type="submit" class="btn btn-primary">Add Blog</button>
  </div>
</form>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>
