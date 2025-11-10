<?php

include("includes/header.php");
include("includes/navbar.php");

$id = $_SESSION['id'];

// Step 1: Get the list of assigned service names for this user
$userQuery = $conn->prepare("SELECT Assigned_Services FROM user WHERE id = ?");
$userQuery->bind_param("i", $id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

$assignedServices = [];

if (!empty($user['Assigned_Services'])) {
    $assignedServices = array_map('trim', explode(',', $user['Assigned_Services']));
}

// Step 2: Fetch only those services from mca_services
$placeholders = implode(',', array_fill(0, count($assignedServices), '?'));
$types = str_repeat('s', count($assignedServices));

$serviceQuery = $conn->prepare("
    SELECT 
        s.*, 
        c.category_name 
    FROM 
        mca_services s 
    LEFT JOIN 
        categories c ON s.category_id = c.id
    WHERE 
        s.service_name IN ($placeholders)
");

if ($assignedServices) {
    $serviceQuery->bind_param($types, ...$assignedServices);
    $serviceQuery->execute();
    $result = $serviceQuery->get_result();
} else {
    $result = new mysqli_result($conn); // empty result if nothing is assigned
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
<!--mainpage chit-chating-->
<div class="chit-chat-layer1" id="services">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:2.2em;text-align:center;color:#000;">
                                 Assigned Services 
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Category</th>
            <th>View Service</th>
            <th>Submissions</th>
        </tr>
    </thead>
    <tbody>            
    <?php
    if ($result && $result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['service_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['category_name'] ?? 'N/A') . "</td>";
            echo "<td><a class='btn btn-lg btn-success' href='../mca-service.php?slug=" . urlencode($row['slug']) . "&id=" . $row['id'] . "'>View Now</a></td>";
            echo "<td><a class='btn btn-lg btn-info' href='manage-submissions.php'>Manage</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No Services found</td></tr>";
    }
    ?>
    </tbody>
</table>

                  </div>
             </div>
      </div>
     <div class="clearfix"> </div>
</div>
<!--main page chit chating end here-->


</div>
<!--inner block end here-->


<?php

include("includes/footer.php");

?>