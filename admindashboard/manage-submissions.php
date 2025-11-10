<?php
include("includes/header.php");
include("includes/navbar.php");

// Get the logged-in admin's id
$id = $_SESSION['id'];

include("config/connection.php");

// Fetch DISTINCT submissions by grouping service_id and created_at
$query = "
    SELECT 
        service_id, 
        user_id, 
        current_status, 
        created_at 
    FROM form_submissions 
    GROUP BY service_id, created_at
    ORDER BY created_at DESC
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); 


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
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;">
                                  Form Submissions
                            </div>
                              <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;width:auto;text-align:right;box-shadow:none;">
                                      <button onclick="downloadExcel()" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Download Data</button>
                                  </div>
                            <div class="table-responsive">
                      
                      <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Applicant Name</th>
                                      <th>Form Name</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <th>Document</th>
                                      <th>Remarks</th>
                                      <th>View Info</th>
                                  </tr>
                              </thead>
                              <tbody>
                                   <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Fetch service_name for each service_id
                    $service_name = '';
                    $applicant_name = '';
                    $sid = $row['service_id'];
                    $uid = $row['user_id'];

                    $service_query = $conn->prepare("SELECT service_name FROM mca_services WHERE id = ?");
                    $service_query->bind_param("i", $sid);
                    $service_query->execute();
                    $service_result = $service_query->get_result();

                    if ($service = $service_result->fetch_assoc()) {
                        $service_name = $service['service_name'];
                    }
                    
                     $applicant_query = $conn->prepare("SELECT Name FROM user WHERE userid = ?");
                    $applicant_query->bind_param("i", $uid);
                    $applicant_query->execute();
                    $applicant_result = $applicant_query->get_result();

                    if ($applicant = $applicant_result->fetch_assoc()) {
                        $applicant_name = $applicant['Name'];
                    }
                    
                    // Fetch existing response if any
$response_query = $conn->prepare("
    SELECT action_text, document_path, remarks 
    FROM form_submission_responses 
    WHERE user_id = ? AND service_id = ? AND created_at = ?
");
$response_query->bind_param("iis", $row['user_id'], $sid, $row['created_at']);
$response_query->execute();
$response_result = $response_query->get_result();
$response = $response_result->fetch_assoc();

$actionText = $response['action_text'] ?? '';
$documentPath = $response['document_path'] ?? '';
$remarks = $response['remarks'] ?? '';



                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($applicant_name) . "</td>";
                    echo "<td>" . htmlspecialchars($service_name) . "</td>";
                    echo "<td>" . htmlspecialchars($row['current_status']) . "</td>";
      // Action column
echo "<td>
    <form action='update-response.php' method='POST'>
        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
        <input type='hidden' name='service_id' value='" . $sid . "'>
        <input type='hidden' name='created_at' value='" . $row['created_at'] . "'>
        <input type='text' name='action_text' value='" . htmlspecialchars($actionText) . "' class='form-control' style='max-width:100px;'/>
        <button type='submit' class='btn btn-sm btn-primary mt-1'>Update</button>
    </form>
</td>";

// Document column
echo "<td>";

// If a document is already uploaded
if (!empty($documentPath) && file_exists($documentPath)) {
    echo "
        <a href='" . htmlspecialchars($documentPath) . "' target='_blank' class='btn btn-sm btn-info mb-1'>View</a><br>
        <a href='delete-document.php?uid={$row['user_id']}&sid={$sid}&submitted=" . urlencode($row['created_at']) . "' 
           class='btn btn-sm btn-danger' 
           onclick=\"return confirm('Are you sure you want to delete this document?')\">
           Delete
        </a>
    ";
} else {
    // If no document exists yet
    echo "
        <form action='upload-response-doc.php' method='POST' enctype='multipart/form-data' class='mt-2'>
            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
            <input type='hidden' name='service_id' value='" . $sid . "'>
            <input type='hidden' name='created_at' value='" . $row['created_at'] . "'>
            <input type='file' name='document' accept='.pdf,.jpg,.png,.docx' class='form-control-file mb-1' style='max-width:105px;'/>
            <button type='submit' class='btn btn-sm btn-warning'>Upload</button>
        </form>
    ";
}

echo "</td>";

      // Remarks column
echo "<td>
    <form action='update-remarks.php' method='POST'>
        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
        <input type='hidden' name='service_id' value='" . $sid . "'>
        <input type='hidden' name='created_at' value='" . $row['created_at'] . "'>
        <input type='text' name='remarks' value='" . htmlspecialchars($remarks) . "' class='form-control' style='max-width:100px;'/>
        <button type='submit' class='btn btn-sm btn-primary mt-1'>Update</button>
    </form>
</td>";


                    echo "<td><a class='btn btn-lg btn-primary' href='view-form-submission.php?formid=" . $sid . "&submitted=" . urlencode($row['created_at']) . "'>View</a></td>";
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No submissions found.</td></tr>";
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
            const response = await fetch('export-form-submissions.php'); // Adjust path if needed
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
            XLSX.utils.book_append_sheet(wb, ws, 'Form Submissions');

            // Trigger file download
            XLSX.writeFile(wb, 'Form_Submissions.xlsx');
        } catch (error) {
            console.error('Error exporting to Excel:', error);
            alert('Failed to download Excel file.');
        }
    }
</script>

<?php

include("includes/footer.php");

?>