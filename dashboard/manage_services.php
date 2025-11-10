<?php
include("includes/header.php");
include("includes/navbar.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the logged-in user's id
$userid = $_SESSION['userid'];

include("config/connection.php");

// Records per page
$records_per_page = 10;

// Get the total number of records
$total_query = "SELECT COUNT(DISTINCT service_id, created_at) AS total_records FROM form_submissions WHERE user_id = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("i", $userid);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total_records'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Get current page from URL or default to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Ensure the current page is within range
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

// Calculate the starting record for the current page
$start_record = ($current_page - 1) * $records_per_page;

// Fetch DISTINCT submissions by grouping service_id and created_at with LIMIT
$query = "
    SELECT service_id, user_id, current_status, created_at 
    FROM form_submissions 
    WHERE user_id = ? 
    GROUP BY service_id, created_at
    ORDER BY created_at DESC
    LIMIT ?, ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $userid, $start_record, $records_per_page);
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
    .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    margin: 0 5px;
    padding: 10px;
    background-color: #f1f1f1;
    text-decoration: none;
    border: 1px solid #ddd;
}

.pagination a:hover {
    background-color: #ddd;
}

.pagination span {
    padding: 10px;
    margin: 0 5px;
    border: 1px solid #ddd;
}

</style>

<!--inner block start here-->

<div class="inner-block">
<!--mainpage chit-chating-->
<div class="chit-chat-layer1">
	<div class="col-md-12 chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading" style="font-size:30px;text-align:center;color:#000;margin-bottom:10px;display:flex;align-items:center;justify-content:space-around;">
                                Form Submissions
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
    <thead>
        <tr>
            <th>Form Id</th>
            <th>Form Name</th>
            <th>Status</th>  
            <th>Action</th>
            <th>Document</th>
            <th>Remarks</th>
            <th>View Data</th>
            <th>Update</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
                $remarks = 'No Remarks';
                $created_at = $row['created_at'];

                $getting_action = $conn->prepare("SELECT action_text, document_path, remarks FROM form_submission_responses WHERE user_id = ? AND service_id = ? AND created_at = ?");
                $getting_action->bind_param("iis", $userid, $sid, $created_at);
                $getting_action->execute();
                $action_taken = $getting_action->get_result();

                if ($action = $action_taken->fetch_assoc()) {
                    $actiontext = $action['action_text'] ?? 'Not Available';
                    $documentPath = $action['document_path'] ?? null;
                    $remarks = $action['remarks'] ?? 'No Remarks';
                }

                echo "<tr>";
                echo "<td>" . $sid . "</td>";
                echo "<td>" . htmlspecialchars($service_name) . "</td>";
                echo "<td>" . htmlspecialchars($row['current_status']) . "</td>";
                echo "<td>" . htmlspecialchars($actiontext) . "</td>";

                // NEW COLUMN: Document
                if (!empty($documentPath)) {
                    echo "<td><a class='btn btn-success btn-md' href='download.php?file=" . urlencode(basename($documentPath)) . "'>Download</a></td>";
                } else {
                    echo "<td><span>Not Available</span></td>";
                }
                echo "<td>" . htmlspecialchars($remarks) . "</td>";

                echo "<td><a class='btn btn-md btn-primary' href='view-form-submission.php?formid=" . $sid . "&submitted=" . urlencode($row['created_at']) . "'>View</a></td>";
                  echo "<td><a class='btn btn-md btn-info' href='update-form-submission.php?formid=" . $sid . "'>Update</a></td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No submissions found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Pagination Links -->
<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="?page=1">&laquo; First</a>
        <a href="?page=<?php echo $current_page - 1; ?>">Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $current_page; ?> of <?php echo $total_pages; ?></span>

    <?php if ($current_page < $total_pages) : ?>
        <a href="?page=<?php echo $current_page + 1; ?>">Next</a>
        <a href="?page=<?php echo $total_pages; ?>">Last &raquo;</a>
    <?php endif; ?>
</div>

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