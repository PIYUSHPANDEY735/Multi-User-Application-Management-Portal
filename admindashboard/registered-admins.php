<?php

include("includes/header.php");
include("includes/navbar.php");

include("config/connection.php");


$query = "SELECT * FROM user WHERE Status='Admin'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result

// Fetch services
$servicesQuery = "SELECT * FROM mca_services";
$servicesResult = $conn->query($servicesQuery);

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

<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="save-assigned-services.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Assign Services to Subadmin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="assign_user_id">
          <div class="row">
            <?php while ($service = $servicesResult->fetch_assoc()) { ?>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input service-checkbox" type="checkbox" name="services[]" value="<?= $service['id'] ?>" id="srv<?= $service['id'] ?>">
                  <label class="form-check-label" for="srv<?= $service['id'] ?>">
                    <?= htmlspecialchars($service['service_name']) ?>
                  </label>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="inner-block">
<!--market updates updates-->
	 <div class="market-updates">
	     
	     
			<div class="col-md-4 market-update-gd">
			    <a href="index.php#services">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3>Overall </h3>
						<h3>Services</h3>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-clipboard-list"> </i>
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
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;">
                                  Registered Admins
                            </div>
                            <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;width:auto;text-align:right;box-shadow:none;">
                                      <button onclick="downloadExcel()" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Download Data</button>
                                  </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Status</th>
                                      <th>Update Status</th>
                                      <th>Assign Service</th>
                                      <th>Info</th>
                                  </tr>
                              </thead>
                              <tbody>
              <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['userid'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Status'] . "</td>";
                         echo "<td><a class='btn btn-warning' href='change-status.php?id=" . $row['userid'] . "&status=" . $row['Status'] . "'>Change Status</a></td>";
                        echo "<td><button type='button' class='btn btn-primary assign-btn' data-userid='" . $row["id"] . "'>Assign Services</button></td>";
                        echo "<td><a class='btn btn-primary' href='view-registration-details.php?id=" . $row['id'] . "'>View Admin</a></td>";
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
  $('.assign-btn').on('click', function() {
    const userId = $(this).data('userid');
    $('#assign_user_id').val(userId);

    // Uncheck all first
    $('.service-checkbox').prop('checked', false);

    // Fetch assigned services
    $.ajax({
      url: 'get-assigned-services.php',
      method: 'GET',
      data: {
        user_id: userId
      },
      dataType: 'json',
      success: function(assigned) {
        assigned.forEach(function(id) {
          $('#srv' + id).prop('checked', true);
        });
      }
    });

    $('#assignModal').modal('show');
  });
</script>

<script>
    async function downloadExcel() {
        try {
            // Fetch data from the PHP script
            const response = await fetch('export-registered-admins.php'); // Adjust path if needed
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
            XLSX.utils.book_append_sheet(wb, ws, 'Registered Admins');

            // Trigger file download
            XLSX.writeFile(wb, 'Registered_Admins.xlsx');
        } catch (error) {
            console.error('Error exporting to Excel:', error);
            alert('Failed to download Excel file.');
        }
    }
</script>

<?php

include("includes/footer.php");

?>