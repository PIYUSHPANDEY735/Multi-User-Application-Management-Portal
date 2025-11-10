<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['status'])) {
    header("Location: ../config/subadmin.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$id = $_SESSION['id'];

include("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $reenter_password = $_POST['reenter_password'];

    if ($new_password !== $reenter_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href = 'update_password.php';</script>";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password query
    $update_password_query = "UPDATE user SET Password = ? WHERE id = ? AND Status='Admin'";
    $stmt = $conn->prepare($update_password_query);
    $stmt->bind_param("si", $hashed_password, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Password updated successfully!'); window.location.href = 'subadmin_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating password. Please try again.'); window.location.href = 'update_password.php';</script>";
    }
}

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id); // Bind the userid parameter
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result


// Check if any record is found
if ($result->num_rows == 1) {
    // Fetch the registration details
    $data = $result->fetch_assoc();
    ?>
    <style>
    .market-update-right i{
        font-size: 3em;
    color: #000;
    width: 80px;
    height: 80px;
    background: #fff;
    text-align: center;
    border-radius: 49px;
    -webkit-border-radius: 49px;
    -moz-border-radius: 49px;
    -o-border-radius: 49px;
    line-height: 1.7em;
    }
    .portlet-grid-page h2{
        font-size: 2em;
    font-weight: 700;
    color: #000;
    margin-bottom: 1em;
    margin-top: 1em;
    text-align: center;
    font-family: 'Carrois Gothic', sans-serif;
    }
</style>

<!--inner block start here-->

<div class="inner-block">

<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="portlet-grid-page">  
    	<h2>Update Sub Admin Password</h2>	
    	
    	    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
             <div class="col-md-12 col-lg-12 col-sm-12" style="margin-top:10px;margin-bottom:10px;">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12" style="margin-top:10px;margin-bottom:10px;">
                <label for="reenter_password" class="form-label">Reenter Password</label>
                <input type="password" class="form-control" id="reenter_password" name="reenter_password" required>
            </div>
        </div>
         <div class="text-left" style="margin-bottom:20px;">
    <button type="submit" class="btn btn-primary" style="text-decoration:none !important;"> Update Password</button>
  </div>
    </form>
    	
		<div class="clearfix"> </div>
		
		    <div class="panel-heading" style="background-color:#fff;border:1px solid #000;font-weight:600;width:fit-content;">
		    <a href="subadmin_profile.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;"> View User Profile</a>
		</div>
  </div>
<!--main page chit chating end here-->


</div>
<!--inner block end here-->

 <?php
} else {
    echo "No User details found for this ID.";
}

// Close the statement and connection
$stmt->close();


include("includes/footer.php");

?>