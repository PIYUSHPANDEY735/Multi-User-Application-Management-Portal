<?php

include("includes/header.php");
include("includes/navbar.php");

?>

<?php

include("config/connection.php");

// Query to fetch data from the public_limited_registration table where userid matches
$query = "SELECT * FROM mca_services_enquiries";
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
			    <a href="callback-enquiries.php">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>Callback </h3>
						<h3>Enquiries</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-phone-alt"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
				</a>
			</div>
			<div class="col-md-4 market-update-gd">
			    <a href="registered-users.php">
				<div class="market-update-block clr-block-1" style="background-color:#FC8213;">
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
				<div class="market-update-block clr-block-3">
					<div class="col-md-8 market-update-left">
						<h3>Contact</h3>
						<h3> Enquiries</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-envelope"> </i>
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
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;">
                                MCA Service Enquiries
                            </div>
                            <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;width:auto;text-align:right;box-shadow:none;">
                                      <button onclick="downloadExcel()" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Download Enquiries</button>
                                  </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Name</th>
                                      <th>Email</th>                                  
                                      <th>Phone</th>
                                      <th>Info</th>
                                      <th>Submitted At</th>
                                  </tr>
                              </thead>
                              <tbody>
              <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Phone'] . "</td>";
                        echo "<td><a class='btn btn-primary' href='view-mca-callback-details.php?id=" . $row['id'] . "'>View Record</a></td>";
                        echo "<td>" . $row['submitted_at'] . "</td>";
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

<script>
    async function downloadExcel() {
        try {
            // Fetch data from the PHP script
            const response = await fetch('export-mca-callback-enquiries.php'); // Adjust path if needed
            const data = await response.json();

            // Check for errors
            if (data.error) {
                alert("Error: " + data.error);
                return;
            }

            // Convert JSON data to an Excel worksheet
            const ws = XLSX.utils.json_to_sheet(data);

            // Create a new Excel workbook and append the worksheet
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'MCA Callback Enquiries');

            // Trigger file download
            XLSX.writeFile(wb, 'MCA_Callback_Enquiries.xlsx');
        } catch (error) {
            console.error('Error exporting to Excel:', error);
            alert('Failed to download Excel file.');
        }
    }
</script>

<?php

include("includes/footer.php");

?>