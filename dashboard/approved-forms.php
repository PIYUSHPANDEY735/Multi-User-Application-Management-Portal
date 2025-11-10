<?php

include("includes/header.php");
include("includes/navbar.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the logged-in user's id
$userid = $_SESSION['userid'];

include("config/connection.php");

$service_query = $conn->prepare("SELECT service_id FROM form_submissions WHERE user_id = ?");
$service_query->bind_param("i", $userid);
$service_query->execute();
$service_result = $service_query->get_result();

$service_id = null;

if ($row = $service_result->fetch_assoc()) {
    $service_id = $row['service_id'];
}

$getformtime = $conn->prepare("SELECT created_at FROM form_submissions WHERE user_id = ?");
$getformtime->bind_param("i", $userid);
$getformtime->execute();
$get_time = $getformtime->get_result();

if ($new = $get_time->fetch_assoc()) {
    $created_at = $new['created_at'];
}


if ($service_id !== null) {
    $page_query = $conn->prepare("SELECT service_name FROM mca_services WHERE id = ?");
    $page_query->bind_param("i", $service_id);
    $page_query->execute();
    $page_result = $page_query->get_result();

    if ($page = $page_result->fetch_assoc()) {
        $service_name = $page['service_name'];
    }
}

// Fetch DISTINCT submissions by grouping service_id and created_at
$query = "
    SELECT 
        service_id, 
        user_id, 
        current_status, 
        created_at 
    FROM form_submissions 
    WHERE user_id = ? AND current_status = 'Approved'
    GROUP BY service_id, created_at
    ORDER BY created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
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
<!--mainpage chit-chating-->
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;display:flex;align-items:center;justify-content:space-around;">
                                Approved Form Submissions
                                <div class="btn-effcts panel-widget" style="margin:0px;padding:0px;padding-left: 5px;padding-right: 5px;background: #d9d9d9;width:auto;">
                                      <a href="declined_forms.php" class="hvr-icon-float-away hvr-trim" style="text-decoration:none !important;">Declined Forms</a>
                                  </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th>Form Id</th>
                                      <th>Userid</th>
                                      <th>Form Name</th>
                                      <th>Current Status</th>  
                                      <th>Action</th>
                                      <th>Document</th>
                                      <th>View Data</th>
                                      <th>Submitted At</th>
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
                    
$actiontext = 'Not Available';
$documentPath = null;
$created_at = $row['created_at'];

$getting_action = $conn->prepare("SELECT action_text, document_path FROM form_submission_responses WHERE user_id = ? AND service_id = ? AND created_at = ?");
$getting_action->bind_param("iis", $userid, $sid, $created_at);
$getting_action->execute();
$action_taken = $getting_action->get_result();

if ($action = $action_taken->fetch_assoc()) {
    $actiontext = $action['action_text'] ?? 'Not Available';
    $documentPath = $action['document_path'] ?? null;
}


                    echo "<tr>";
                    echo "<td>" . $sid . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($service_name) . "</td>";
                    echo "<td>" . htmlspecialchars($row['current_status']) . "</td>";
                    echo "<td>" . htmlspecialchars($actiontext) . "</td>";

// NEW COLUMN: Document
if (!empty($documentPath)) {
  echo "<td><a class='btn btn-success btn-sm' href='download.php?file=" . urlencode(basename($documentPath)) . "'>Download</a></td>";

} else {
    echo "<td><span class='text-muted'>Not Available</span></td>";
}

                    echo "<td><a class='btn btn-lg btn-primary' href='view-form-submission.php?formid=" . $sid . "&submitted=" . urlencode($row['created_at']) . "'>View</a></td>";
                    echo "<td>" . $row['created_at'] . "</td>";
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


<?php

include("includes/footer.php");

?>