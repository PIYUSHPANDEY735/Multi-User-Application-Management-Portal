<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$id = $_SESSION['id'];

include("config/connection.php");

// Fetch the current admin details from the database

$query = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin_data = $result->fetch_assoc();

// Handle the form submission to update admin profile


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    
    $email = $_POST['email'];
    $allemail = $_POST['allemail'];
    $display_name = $_POST['display_name'];
    $phone = $_POST['phone'];
    $phoneall = $_POST['phone_all'];
    $address = $_POST['address'];
    $addressall = $_POST['address_second'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $youtube = $_POST['youtube'];
    $twitter = $_POST['twitter'];
    $designation = $_POST['designation'];
    
      // Handle file upload for banner
    if (!empty($_FILES["QR_Code"]["name"])) {
        $target_dir = "../userdata/";
        $qr_code = $target_dir . basename($_FILES["QR_Code"]["name"]);
        move_uploaded_file($_FILES["QR_Code"]["tmp_name"], $qr_code);
    } else {
        $qr_code = $admin_data['QR_Code']; // Keep the old banner if no new one is uploaded
    }

    // Update query to save changes in the database
    $update_query = "UPDATE admin SET Name = ?, Display_Name = ?, Email = ?, All_Emails = ?, Phone = ?, Phone_all = ?, Address = ?, Address_second = ?, QR_Code = ?, Facebook = ?, Instagram = ?, Linkedin = ?, Youtube = ?, Twitter = ?, Designation = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssssssssssi", $name, $display_name, $email, $allemail, $phone, $phoneall, $address, $addressall, $qr_code, $facebook, $instagram, $linkedin, $youtube, $twitter, $designation, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'admin_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.'); window.location.href = 'update_profile.php';</script>";
    }
}
?>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Update Your Admin Details -:</h2>
    <form action="update-admin.php" method="POST"  enctype="multipart/form-data">
<div class="row">
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($admin_data['Name']) ?>" required>
            </div>
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="name" class="form-label">Query Text</label>
                <input type="text" class="form-control" id="display_name" name="display_name" value="<?= htmlspecialchars($admin_data['Display_Name']) ?>" required>
            </div>
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="designation" class="form-label">Query Detail</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?= htmlspecialchars($admin_data['Designation']) ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="email" class="form-label">Email (Used for Login)</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($admin_data['Email']) ?>" required>
            </div>
            
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="email" class="form-label">All Email Addresses</label>
                <input type="text" class="form-control" id="allemail" name="allemail" value="<?= htmlspecialchars($admin_data['All_Emails']) ?>" required>
            </div>
            
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($admin_data['Phone']) ?>" required>
            </div>
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="phone_all" class="form-label">All Phone Numbers</label>
                <input type="text" class="form-control" id="phone_all" name="phone_all" value="<?= htmlspecialchars($admin_data['Phone_all']) ?>" >
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div style="margin-top:10px;margin-bottom:10px;">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($admin_data['Address']) ?></textarea>
        </div>
            </div>
            <div class="col-md-4">
                <div style="margin-top:10px;margin-bottom:10px;">
            <label for="address_second" class="form-label">Second Address</label>
            <textarea class="form-control" id="address_second" name="address_second" rows="3"><?= htmlspecialchars($admin_data['Address_second']) ?></textarea>
        </div>
            </div>
            <div class="col-md-4">
                <div style="margin-top:10px;margin-bottom:10px;">
            <label for="QR_Code" class="form-label">Your QR Code</label>
            <input type="file" class="form-control" id="QR_Code" name="QR_Code">
                        <img src="<?= $admin_data['QR_Code'] ?>" alt="QR Code" style="width: 100%; margin-top: 10px;">
        </div>
            </div>
        </div>

        <h4>Social Media Links</h4>

        <div class="row">
            <div class="col-md-6"style="margin-top:10px;margin-bottom:10px;">
                <label for="facebook" class="form-label">Facebook Profile Link</label>
                <input type="url" class="form-control" id="facebook" name="facebook" value="<?= htmlspecialchars($admin_data['Facebook']) ?>">
            </div>
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="instagram" class="form-label">Instagram Profile Link</label>
                <input type="url" class="form-control" id="instagram" name="instagram" value="<?= htmlspecialchars($admin_data['Instagram']) ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="linkedin" class="form-label">LinkedIn Profile Link</label>
                <input type="url" class="form-control" id="linkedin" name="linkedin" value="<?= htmlspecialchars($admin_data['Linkedin']) ?>">
            </div>
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="youtube" class="form-label">YouTube Profile Link</label>
                <input type="url" class="form-control" id="youtube" name="youtube" value="<?= htmlspecialchars($admin_data['Youtube']) ?>">
            </div>
            <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                <label for="twitter" class="form-label">Twitter Profile Link</label>
                <input type="url" class="form-control" id="twitter" name="twitter" value="<?= htmlspecialchars($admin_data['Twitter']) ?>">
            </div>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
        </form>
            </div>
    </div>
</div>



<?php

include("includes/footer.php");
?>