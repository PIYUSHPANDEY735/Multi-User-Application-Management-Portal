<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $conn->real_escape_string($_POST['category_name']);
    $slug = strtolower(str_replace(" ", "-", $category_name));

    $sql = "INSERT INTO categories (category_name, slug) VALUES ('$category_name', '$slug')";
    
    if ($conn->query($sql) === TRUE) {
        // Display success alert and redirect to manage-services.php
        echo "<script>
                alert('Category added successfully!');
                window.location.href = 'manage-categories.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
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
    .market-update-block h3{
        font-size:35px;
        font-weight:normal;
    }
</style>

<div class="inner-block">
    <!--market updates updates-->
	 <div class="market-updates">
			<div class="col-md-4 market-update-gd">
			    <a href="registered-users.php">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>Registered </h3>
						<h3> Users</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-users"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="contact-enquiries.php">
				<div class="market-update-block clr-block-2">
				 <div class="col-md-8 market-update-left">
					<h3>Contact </h3>
					<h3> Enquiries</h3>
				  </div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-envelope"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="callback-enquiries.php">
				<div class="market-update-block clr-block-3">
					<div class="col-md-8 market-update-left">
						<h3>Callback</h3>
						<h3> Enquiries</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-phone-alt"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
		   <div class="clearfix"> </div>
		</div>
        <div class="container mt-5" style="margin-top:20px">
            <h2>Add New Category</h2>
            <form method="POST" style="margin-top:20px;">
    <label>Category Name:</label>
    <input type="text" name="category_name" required>
    <button type="submit">Add Category</button>
</form>
        </div>
</div>


<?php include("includes/footer.php"); ?>