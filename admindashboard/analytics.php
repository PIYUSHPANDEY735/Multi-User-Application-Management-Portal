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

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM admin";
$stmt = $conn->prepare($query);
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
    .market-update-block h3{
        font-size:35px;
        font-weight:normal;
    }
</style>

<!--inner block start here-->

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
<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="portlet-grid-page">
     <h2> Overall Analytics</h2>
    <canvas id="adminAnalyticsChart" style="width: 100%; height: 300px;"></canvas>
</div>

<!--main page chit chating end here-->


</div>
<!--inner block end here-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var servicesCount = 14;
    var usersCount = 29;
    var categoriesCount = 7;
    var enquiriesCount = 16;
    var adminsCount = 10;

    var ctx = document.getElementById('adminAnalyticsChart').getContext('2d');
    var adminAnalyticsChart = new Chart(ctx, {
        type: 'pie',  // You can also use 'bar', 'line', 'doughnut', etc.
        data: {
            labels: ['Services', 'Users', 'Categories', 'Enquiries', 'Admins'],  // Label your stats
            datasets: [{
                label: '# of Items',
                data: [servicesCount, usersCount, categoriesCount, enquiriesCount, adminsCount],  // Your data counts
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>

 <?php
} else {
    echo "No registration details found for this ID.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<?php

include("includes/footer.php");

?>