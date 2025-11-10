<?php
include("includes/header.php");
include("includes/navbar.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the logged-in user's id
$userid = $_SESSION['userid'];

include("config/connection.php");

// Set the number of records per page
$records_per_page = 10;

// Get the current page from the URL (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the query
$start_from = ($page - 1) * $records_per_page;

// Fetch grouped submissions by submitted_at time with pagination
$query = "
    SELECT 
        fs.service_id, 
        fs.user_id, 
        fs.current_status, 
        fs.created_at,
        COUNT(fs.service_id) AS submission_count
    FROM form_submissions AS fs
    LEFT JOIN form_submission_responses AS fsr ON fs.service_id = fsr.service_id AND fs.user_id = fsr.user_id
    WHERE fs.user_id = ? AND (fsr.document_path IS NOT NULL OR fsr.document_path = 'Not Available')
    GROUP BY fs.created_at, fs.service_id
    HAVING COUNT(fs.service_id) > 0
    ORDER BY fs.created_at DESC
    LIMIT ?, ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $userid, $start_from, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .market-update-right i {
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
                    Form Submissions
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Form Id</th>
                                <th>Service Name</th>
                                <th>Document</th>
                                <th>Submitted At</th>
                                <th>Current Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $sid = $row['service_id'];

                                    // Fetch the service name for each service_id
                                    $service_query = $conn->prepare("SELECT service_name FROM mca_services WHERE id = ?");
                                    $service_query->bind_param("i", $sid);
                                    $service_query->execute();
                                    $service_result = $service_query->get_result();
                                    $service_name = '';
                                    if ($service = $service_result->fetch_assoc()) {
                                        $service_name = $service['service_name'];
                                    }

                                    // Get the document path for the given submission
                                    $documentPath = null;
                                    $document_query = $conn->prepare("SELECT document_path FROM form_submission_responses WHERE user_id = ? AND service_id = ? AND created_at = ?");
                                    $document_query->bind_param("iis", $userid, $sid, $row['created_at']);
                                    $document_query->execute();
                                    $document_result = $document_query->get_result();
                                    if ($document = $document_result->fetch_assoc()) {
                                        $documentPath = $document['document_path'];
                                    }

                                    // Display data
                                    echo "<tr>";
                                    echo "<td>" . $sid . "</td>";
                                    echo "<td>" . htmlspecialchars($service_name) . "</td>";
                                    echo "<td>";

                                    // Display Download and View buttons for documents
                                    if (!empty($documentPath)) {
                                        echo "<a class='btn btn-success btn-md' href='download.php?file=" . urlencode(basename($documentPath)) . "'>Download</a> ";

                                        echo "
        <a href='" . htmlspecialchars($documentPath) . "' target='_blank' class='btn btn-sm btn-info mb-1'>View</a>";
                                    } else {
                                        echo "<span>Not Available</span>";
                                    }

                                    echo "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>" . htmlspecialchars($row['current_status']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No submissions with documents found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                    // Pagination: Get the total number of grouped submissions
                    $total_query = "
    SELECT COUNT(DISTINCT fs.created_at) AS total 
    FROM form_submissions AS fs
    LEFT JOIN form_submission_responses AS fsr 
        ON fs.service_id = fsr.service_id 
        AND fs.user_id = fsr.user_id
    WHERE fs.user_id = ?
      AND (fsr.document_path IS NOT NULL OR fsr.document_path = 'Not Available')
";
                    $total_stmt = $conn->prepare($total_query);
                    $total_stmt->bind_param("i", $userid);
                    $total_stmt->execute();
                    $total_result = $total_stmt->get_result();
                    $total_row = $total_result->fetch_assoc();
                    $total_records = $total_row['total'];

                    // Calculate total pages
                    $total_pages = ceil($total_records / $records_per_page);

                    // Display pagination links
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='certificates.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                    ?>

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