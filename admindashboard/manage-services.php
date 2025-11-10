<?php

error_reporting(E_ALL);
ini_set('display_errors',1); 

include("includes/header.php");
include("includes/navbar.php");

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM mca_services";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result


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
<!--market updates end here-->
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;display:flex;align-items:center;justify-content:space-around;">
                                  All Services
                                  <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;background: #d9d9d9;width:auto;">
                                      <a href="add-new-service.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Create New Service</a>
                                  </div>
                                  <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;background: #d9d9d9;width:auto;">
                                      <a href="callback-enquiries.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Service Enquiries</a>
                                  </div>
                                  
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Service ID</th>
                                      <th>Service Name</th>
                                      <th>View </th>
                                      <th>Update</th>
                                      <th>Delete</th>
                                      <th>Created At</th>
                                  </tr>
                              </thead>
                              <tbody>
              <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['service_name'] . "</td>";
                        echo "<td><a class='btn btn-info' href='../mca-service.php?slug=" . $row['slug'] .  "&id=" . $row['id'] . "' >View Service</a></td>";
                        echo "<td><a class='btn btn-primary' href='update-service.php?id=" . $row['id'] . "'>Update Service</a></td>";
                        echo "<td><a class='btn btn-warning' href='#' onclick='confirmDelete(" . $row['id'] . ")'>Delete Service</a></td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                        
     
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
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

<script type="text/javascript">
  function confirmDelete(serviceId) {
    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this service?")) {
      // Redirect to the PHP delete page if "Yes"
      window.location.href = "delete-service.php?id=" + serviceId;
    } else {
      // Redirect to the MCA services page if "No"
      window.location.href = "manage-services.php";
    }
  }
</script>



<?php

include("includes/footer.php");

?>