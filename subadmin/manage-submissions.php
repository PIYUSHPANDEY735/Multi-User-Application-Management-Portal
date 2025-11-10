<?php

include("includes/header.php");
include("includes/navbar.php");

// Get the logged-in user's id
$id = $_SESSION['id'];

include("config/connection.php");

// Get Assigned_Services (which are stored as comma-separated service names)
$userQuery = $conn->prepare("SELECT Assigned_Services FROM user WHERE id = ?");
$userQuery->bind_param("i", $id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

$assignedServices = [];

if (!empty($user['Assigned_Services'])) {
    $assignedServices = array_map('trim', explode(',', $user['Assigned_Services']));
}

$placeholders = implode(',', array_fill(0, count($assignedServices), '?'));
$types = str_repeat('s', count($assignedServices));

// Get service_ids that belong to assigned service names
$serviceIdQuery = $conn->prepare("SELECT id FROM mca_services WHERE service_name IN ($placeholders)");
$serviceIdQuery->bind_param($types, ...$assignedServices);
$serviceIdQuery->execute();
$serviceIdResult = $serviceIdQuery->get_result();

$allowedServiceIds = [];
while ($row = $serviceIdResult->fetch_assoc()) {
    $allowedServiceIds[] = $row['id'];
}


if (count($allowedServiceIds) > 0) {
    $placeholders = implode(',', array_fill(0, count($allowedServiceIds), '?'));
    $types = str_repeat('i', count($allowedServiceIds));

    $query = "
        SELECT 
            service_id, 
            user_id, 
            current_status, 
            created_at 
        FROM form_submissions 
        WHERE service_id IN ($placeholders)
        GROUP BY service_id, created_at
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$allowedServiceIds);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = new mysqli_result($conn); // empty result set
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
                                 Manage Submissions
                            </div>
                              
                            <div class="table-responsive">
                        <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Form Id</th>
                                      <th>User Id</th>
                                      <th>Form Name</th>
                                      <th>Status</th>
                                      <th>Update Status</th>
                                      <th>Action</th>
                                      <th>Document</th>
                                      <th>View Info</th>
                                  </tr>
                              </thead>
                              <tbody>
                                   <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Fetch service_name for each service_id
                    $service_name = '';
                    $sid = $row['service_id'];

                    $service_query = $conn->prepare("SELECT service_name FROM mca_services WHERE id = ?");
                    $service_query->bind_param("i", $sid);
                    $service_query->execute();
                    $service_result = $service_query->get_result();

                    if ($service = $service_result->fetch_assoc()) {
                        $service_name = $service['service_name'];
                    }
                    
                    // Fetch existing response if any
$response_query = $conn->prepare("
    SELECT action_text, document_path 
    FROM form_submission_responses 
    WHERE user_id = ? AND service_id = ? AND created_at = ?
");
$response_query->bind_param("iis", $row['user_id'], $sid, $row['created_at']);
$response_query->execute();
$response_result = $response_query->get_result();
$response = $response_result->fetch_assoc();

$actionText = $response['action_text'] ?? '';
$documentPath = $response['document_path'] ?? '';



                    echo "<tr>";
                    echo "<td>" . $sid . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($service_name) . "</td>";
                    echo "<td>" . htmlspecialchars($row['current_status']) . "</td>";
                      echo "<td>
           <a href='update-form-status.php?formid=" . $sid . "&submitted=" . urlencode($row['created_at']) . "&action=Approve' class='btn btn-success'>Approve</a>
    <a href='update-form-status.php?formid=" . $sid . "&submitted=" . urlencode($row['created_at']) . "&action=Decline' class='btn btn-danger'>Decline</a>
      </td>";
      // Action column
echo "<td>
    <form action='update-response.php' method='POST'>
        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
        <input type='hidden' name='service_id' value='" . $sid . "'>
        <input type='hidden' name='created_at' value='" . $row['created_at'] . "'>
        <input type='text' name='action_text' value='" . htmlspecialchars($actionText) . "' class='form-control' style='min-width:150px;'/>
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
            <input type='file' name='document' accept='.pdf,.jpg,.png,.docx' class='form-control-file mb-1'/>
            <button type='submit' class='btn btn-sm btn-warning'>Upload</button>
        </form>
    ";
}

echo "</td>";


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
            const response = await fetch('export-gst-registration.php'); // Adjust path if needed
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
            XLSX.utils.book_append_sheet(wb, ws, 'GST Registration');

            // Trigger file download
            XLSX.writeFile(wb, 'GST_Registration.xlsx');
        } catch (error) {
            console.error('Error exporting to Excel:', error);
            alert('Failed to download Excel file.');
        }
    }
</script>

<?php

include("includes/footer.php");

?>