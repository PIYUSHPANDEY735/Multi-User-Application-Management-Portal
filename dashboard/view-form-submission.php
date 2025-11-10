<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../config/login.php");
    exit();
}

$user_id = $_SESSION['userid'];
$service_id = isset($_GET['formid']) ? intval($_GET['formid']) : 0;

if ($service_id === 0) {
    echo "Invalid form ID.";
    exit();
}

// Fetch all fields for this user and service
$sql = "SELECT field_label, field_value FROM form_submissions WHERE user_id = ? AND service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $service_id);
$stmt->execute();
$result = $stmt->get_result();

// Check for submission
if ($result->num_rows === 0) {
    echo "No submission data found.";
    exit();
}

$form_data = [];
while ($row = $result->fetch_assoc()) {
    $form_data[$row['field_label']] = $row['field_value'];
}
?>

<div class="inner-block">
    <div class="portlet-grid-page" style="width:100%;height:100vh;">  
    <br>
        <h2>Your Submitted Form</h2>	

        <?php foreach ($form_data as $label => $value): ?>
            <div class="portlet-grid panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= htmlspecialchars($label) ?></h3>
                </div> 
                <div class="panel-body">
                    <?php
    $is_file = preg_match('/\.(jpg|jpeg|png|webp|gif|pdf|doc|docx)$/i', $value);
    $file_path = "../" . $value;

    if ($is_file && file_exists($file_path)):
?>
    <button onclick="openPreview('<?= $file_path ?>')" class="btn btn-info">Open</button>
<?php else: ?>
    <?= nl2br(htmlspecialchars($value)) ?>
<?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>

        <!-- Add a Back Button -->
        <div class="portlet-grid panel-info">
            <div class="panel-body">
                <a href="manage_services.php" class="btn btn-secondary">Back to Form Submissions</a>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" style="display:none; position:fixed; top:10%; left:10%; width:80%; height:80%; background:#fff; border:2px solid #000; z-index:9999; overflow:auto;">
    <button onclick="closePreview()" style="float:right; margin:10px;" class="btn btn-danger">Close</button>
    <div id="previewContent" style="padding:20px;"></div>
</div>

<script>
function openPreview(filePath) {
    const extension = filePath.split('.').pop().toLowerCase();
    let content = '';

    if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
        content = `<img src="${filePath}" style="max-width:100%; height:auto;">`;
    } else if (['pdf'].includes(extension)) {
        content = `<iframe src="${filePath}" style="width:100%; height:80vh;" frameborder="0"></iframe>`;
    } else {
        window.open(filePath, '_blank');
        return;
    }

    document.getElementById('previewContent').innerHTML = content;
    document.getElementById('previewModal').style.display = 'block';
}


function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
    document.getElementById('previewContent').innerHTML = '';
}
</script>

<?php include("includes/footer.php"); ?>
