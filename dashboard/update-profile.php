<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../config/login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$userid = $_SESSION['userid'];

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid); // Bind the userid parameter
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result
$userprofile = $result->fetch_assoc();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    // Update query to save changes in the database
    $update_query = "UPDATE user SET Name = ?, Email = ?, Phone = ?, State = ?, Pincode = ? WHERE userid = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $name, $email, $phone, $state, $pincode, $userid);
    
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'user_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.'); window.location.href = 'user_profile.php';</script>";
    }
}
?>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <br><br>
            <h2>Update Your User Details -:</h2>
    <form action="" method="POST"  enctype="multipart/form-data">
<div class="row">
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($userprofile['Name']) ?>" required>
            </div>
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($userprofile['Phone']) ?>" required>
            </div>
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="Email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userprofile['Email']) ?>" required>
            </div>
           <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="State" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="<?= htmlspecialchars($userprofile['State']) ?>" required>
            </div>
            <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                <label for="Pincode" class="form-label">Pincode</label>
                <input type="number" class="form-control" id="pincode" name="pincode" value="<?= htmlspecialchars($userprofile['Pincode']) ?>" required>
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