<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Check if the category exists
    $sql = "SELECT * FROM categories WHERE id = '$category_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Remove the category_id from mca_services table
        $update_sql = "UPDATE mca_services SET category_id = NULL WHERE category_id = '$category_id'";
        if ($conn->query($update_sql) === TRUE) {
            // Proceed with deletion of the category
            $delete_sql = "DELETE FROM categories WHERE id = '$category_id'";

            if ($conn->query($delete_sql) === TRUE) {
                // Success message and redirect
                echo "<script>
                        alert('Category and associated services updated successfully!');
                        window.location.href = 'manage-categories.php';
                      </script>";
            } else {
                echo "Error deleting category: " . $conn->error;
            }
        } else {
            echo "Error updating services: " . $conn->error;
        }
    } else {
        echo "Category not found.";
    }
} else {
    echo "Invalid category ID.";
}
?>
