<?php
include("includes/header.php");
include("includes/navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../config/login.php"); //Redirect to login page if not logged in
    exit();
}

include("config/connection.php");
require("functions.php");

$user_id = $_SESSION['userid'];
$service_id = isset($_GET['formid']) ? intval($_GET['formid']) : 0;

if ($service_id === 0) {
    echo "Invalid form ID.";
    exit();
}

// Fetch existing form fields and submitted data
$sql = "SELECT field_label, field_value FROM form_submissions WHERE user_id = ? AND service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $service_id);
$stmt->execute();
$result = $stmt->get_result();

$form_data = [];
while ($row = $result->fetch_assoc()) {
    $form_data[$row['field_label']] = $row['field_value'];
}

// Fetch form field definitions
$sql_fields = "SELECT * FROM forms WHERE service_id = ?";
$stmt_fields = $conn->prepare($sql_fields);
$stmt_fields->bind_param("i", $service_id);
$stmt_fields->execute();
$result_fields = $stmt_fields->get_result();

$form_fields = [];
while ($field = $result_fields->fetch_assoc()) {
    $field['safe_name'] = safe_name($field['field_label']);
    $form_fields[] = $field;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_form'])) {
    foreach ($form_fields as $field) {
        $safe_name = $field['safe_name'];
        $field_label = $field['field_label'];
        $field_value = '';

        if ($field['field_type'] === 'file') {
            if (isset($_FILES[$safe_name]) && $_FILES[$safe_name]['error'] === 0) {
                $upload_dir = "userdata/";
                $file_name = time() . "_" . basename($_FILES[$safe_name]['name']);
                $target_file = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES[$safe_name]['tmp_name'], "../" . $target_file)) {
                    $field_value = $target_file;
                } else {
                    $field_value = $form_data[$field_label] ?? 'File upload failed.';
                }
            } else {
                // Keep existing file
                $field_value = $form_data[$field_label] ?? '';
            }
        } else {
            $field_value = $conn->real_escape_string($_POST[$safe_name] ?? '');
        }

        // Update value in database
        $sql_update = "UPDATE form_submissions SET field_value = ? WHERE user_id = ? AND service_id = ? AND field_label = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("siis", $field_value, $user_id, $service_id, $field_label);
        $stmt_update->execute();
    }

    echo "<script>alert('Form updated successfully!'); window.location.href='view-form-submission.php?formid=$service_id';</script>";
    exit();
}
?>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
           <br><br> <h2>Update Your Form Submissions -:</h2>
    <form action="" method="POST"  enctype="multipart/form-data">
<div class="row">
        <?php foreach ($form_fields as $field): 
            $safe_name = $field['safe_name'];
            $existing_value = $form_data[$field['field_label']] ?? '';
            $is_required = ($field['is_required'] == 1);
            $required_attr = ($is_required && $field['field_type'] !== 'file') ? 'required' : '';
        ?>
            <div class="col-md-4">
                <label for="<?= $safe_name ?>"><?= htmlspecialchars($field['field_label']) ?>:</label>

                <?php if (in_array($field['field_type'], ['text', 'email', 'number', 'date'])): ?>
                    <input type="<?= $field['field_type'] ?>" name="<?= $safe_name ?>" id="<?= $safe_name ?>"
                           value="<?= htmlspecialchars($existing_value) ?>" <?= $required_attr ?> class="form-control">

                <?php elseif ($field['field_type'] === 'textarea'): ?>
                    <textarea name="<?= $safe_name ?>" id="<?= $safe_name ?>" rows="4" <?= $required_attr ?>
                              class="form-control"><?= htmlspecialchars($existing_value) ?></textarea>

                <?php elseif ($field['field_type'] === 'file'): ?>
                    <?php if (!empty($existing_value) && file_exists("../" . $existing_value)): ?>
                        <p>Previously uploaded: <a href="../<?= $existing_value ?>" target="_blank">View File</a></p>
                    <?php endif; ?>
                    <input type="file" name="<?= $safe_name ?>" id="<?= $safe_name ?>" class="form-control">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

        <div class="text-center">
            <button type="submit" name="update_form" class="btn btn-success">Update Submission</button>
        </div>
        </form>
            </div>
    </div>
</div>



<?php

include("includes/footer.php");
?>