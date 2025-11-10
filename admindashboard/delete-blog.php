<?php
include("config/connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get image path before deletion
    $getImageQuery = "SELECT blog_image FROM blogs WHERE id = $id";
    $result = $conn->query($getImageQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['blog_image'];

        // Delete the blog entry
        $deleteQuery = "DELETE FROM blogs WHERE id = $id";
        if ($conn->query($deleteQuery) === TRUE) {
            // Optional: Delete the image file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            echo "<script>alert('Blog deleted successfully!'); window.location.href='manage-blogs.php';</script>";
        } else {
            echo "Error deleting blog: " . $conn->error;
        }
    } else {
        echo "Blog not found.";
    }
} else {
    echo "Invalid request.";
}
?>
