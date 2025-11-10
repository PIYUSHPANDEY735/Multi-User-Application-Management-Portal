<?php

include("includes/header.php");
include("includes/navbar.php");

?>

<?php

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
</style>

<!--inner block start here-->
<div class="inner-block">
<!--market updates updates-->
	 <div class="market-updates">
			<div class="col-md-4 market-update-gd">
			    <a href="gst-registration.php">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>GST</h3>
						<h4>Registration</h4>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-file-invoice"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="msme-registration.php">
				<div class="market-update-block clr-block-2">
				 <div class="col-md-8 market-update-left">
					<h3>MSME</h3>
					<h4>Registration</h4>
				  </div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-industry"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="fssai-registration.php">
				<div class="market-update-block clr-block-3">
					<div class="col-md-8 market-update-left">
						<h3>FSSAI</h3>
						<h4>Registration</h4>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-utensils"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
		   <div class="clearfix"> </div>
		</div>
<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:2.2em;text-align:center;color:#000;">
                                  Our MCA Services 
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Service ID</th>
                                      <th>Service Name</th>
                                      <th>Service Heading</th>
                                      <th>Apply</th>                        
                                      <th>Created</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['page_title'] . "</td>";
                       echo "<td>" . $row['page_heading'] . "</td>";
                         echo "<td><a class='btn btn-info' href='../mca-service.php?slug=" . $row['slug'] .  "&id=" . $row['id'] . "' >Apply Service</a></td>";
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


<?php

include("includes/footer.php");

?>