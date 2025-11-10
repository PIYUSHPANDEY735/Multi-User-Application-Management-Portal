<?php
include("includes/header.php");
include("includes/navbar.php");

$trackData = [];
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = trim($_POST['user_id']);
    $selectedService = $_POST['service_id'] ?? '';
    if (empty($userId)) {
        $error = "User ID is required.";
    } else {
        $query = " SELECT fs.service_id, fs.user_id, fs.current_status, fs.created_at, ms.service_name, MAX(fr.action_text) AS latest_action, MAX(fr.document_path) AS document_path FROM form_submissions fs LEFT JOIN mca_services ms ON fs.service_id = ms.id LEFT JOIN form_submission_responses fr ON fs.user_id = fr.user_id AND fs.service_id = fr.service_id AND fs.created_at = fr.created_at WHERE fs.user_id = ? ";
        if (!empty($selectedService)) {
            $query .= " AND fs.service_id = ?";
        }
        $query .= " GROUP BY fs.service_id, fs.user_id, fs.created_at, ms.service_name, fs.current_status ORDER BY fs.created_at DESC ";
        if (!empty($selectedService)) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userId, $selectedService);
        } else {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $trackData[] = $row;
        }
    }
}

?>

<div class="breadcrumb-area section-padding light-bg-1 pb-0" style="padding-top:40px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-bg">
                    <img src="assets/img/knowledge-banner.webp" alt="Knowledge Bank Banner">
                </div>
            </div>
        </div>
    </div>
</div>
<h4>For Example Search the User Id 2528 with All Services Filter</h4>
<h4>Track Your Application Status</h4>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="mb-4">
    <div class="form-group">
        <label for="user_id">User ID <span class="text-danger">*</span></label>
        <input type="text" name="user_id" class="form-control" required value="<?= htmlspecialchars($_POST['user_id'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="service_id">Select Service (Optional)</label>
        <select name="service_id" class="form-control">
            <option value="">-- All Services --</option>
            <?php
            $services = $conn->query("SELECT id, service_name FROM mca_services");
            while ($service = $services->fetch_assoc()) {
                $selected = ($_POST['service_id'] ?? '') == $service['id'] ? 'selected' : '';
                echo "<option value='" . $service['id'] . "' $selected>" . htmlspecialchars($service['service_name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Track</button>
</form>

<?php if (!empty($trackData)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Form ID</th>
                <th>Form Name</th>
                <th>Status</th>
                <th>Action</th>
                <th>Document</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trackData as $data): ?>
                <tr>
                    <td><?= htmlspecialchars($data['service_id']) ?></td>
                    <td><?= htmlspecialchars($data['service_name']) ?></td>
                    <td><?= htmlspecialchars($data['current_status']) ?></td>
                    <td><?= htmlspecialchars($data['latest_action'] ?? '-') ?></td>
                    <?php
                    $prefix = 'https://localhost/piyushproject/';
                    $rawPath = $data['document_path'] ?? '';
                    $adjustedPath = ltrim($rawPath, './'); // remove leading '.' or './' from the path
                    $fullUrl = $prefix . $adjustedPath;
                    ?>
                    <td>
                        <?php if (!empty($rawPath)): ?>
                            <a href="<?= $fullUrl ?>" target="_blank" class="btn btn-sm btn-primary">View</a>
                            <a href="<?= $fullUrl ?>" download class="btn btn-sm btn-secondary">Download</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars(date("d M Y, h:i A", strtotime($data['created_at']))) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="alert alert-warning">No submissions found for this user.</div>
<?php endif; ?>



<?php

include("includes/footer.php");

?>