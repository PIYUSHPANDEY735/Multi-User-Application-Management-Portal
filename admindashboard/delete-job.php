<?php
include("config/connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
        // Delete the blog entry
        $deleteQuery = "DELETE FROM job_openings WHERE id = $id";
        if ($conn->query($deleteQuery) === TRUE) {
            echo "<script>alert('Job Opening Deleted Successfully!'); window.location.href='manage-jobs.php';</script>";
        } else {
            echo "Error deleting blog: " . $conn->error;
        }
     
} else {
    echo "Invalid request.";
}
?>
