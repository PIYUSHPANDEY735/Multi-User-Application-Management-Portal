<?php
include("includes/header.php");
include("includes/navbar.php");

// Set the number of results per page
$results_per_page = 10;

// Get the current page number from URL if available, else default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the starting limit
$start_from = ($page - 1) * $results_per_page;

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $search_param = "%{$search}%";
    $query = "SELECT * FROM mca_services WHERE service_name LIKE ? ORDER BY id DESC LIMIT ?, ?";
} else {
    $query = "SELECT * FROM mca_services ORDER BY id DESC LIMIT ?, ?";
}

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $types = "sii";
    $params = [$search_param, $start_from, $results_per_page];
    $stmt->bind_param($types, ...$params);
} else {
    $types = "ii";
    $params = [$start_from, $results_per_page];
    $stmt->bind_param($types, ...$params);
}

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
                            <div class="chit-chat-heading" style="font-size:2.2em;text-align:center;color:#000;">
                                  Our Services 
                            </div>
                            <div class="table-responsive">
                             <!-- Search Form -->
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by service name..." value="<?php echo htmlspecialchars($search); ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<!-- Table -->
<table class="table table-hover">
    <thead>
        <tr>
            <th>Service ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Apply</th>
            <th>View</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['service_name'] . "</td>";
                echo "<td>" . $row['page_heading'] . "</td>";
                echo "<td><a class='btn btn-md btn-success' href='../mca-service.php?slug=" . $row['slug'] . "&id=" . $row['id'] . "'>Apply Now</a></td>";
                echo "<td><a class='btn btn-md btn-primary' href='manage_services.php'>View</a></td>";
                echo "<td><span class='btn btn-md btn-info'>Admin</span></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Services found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Pagination calculation
if (!empty($search)) {
    $count_query = "SELECT COUNT(*) AS total FROM mca_services WHERE service_name LIKE ?";
    $count_stmt = $conn->prepare($count_query);
    $count_stmt->bind_param("s", $search_param);
} else {
    $count_query = "SELECT COUNT(*) AS total FROM mca_services";
    $count_stmt = $conn->prepare($count_query);
}

$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_row = $count_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $results_per_page);
?>

<!-- Pagination Links -->
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?><?php echo (!empty($search)) ? '&search=' . urlencode($search) : ''; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
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