<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

// Get the service ID to update
if (!isset($_GET['id'])) {
    echo "No service selected.";
    exit();
}

$service_id = $_GET['id'];

// Fetch service details
$sql_service = "SELECT * FROM mca_services WHERE id = '$service_id'";
$result_service = $conn->query($sql_service);
if ($result_service->num_rows == 0) {
    echo "Service not found!";
    exit();
}
$service = $result_service->fetch_assoc();

// Fetch associated data (benefits, FAQs, testimonials)
$sql_benefits = "SELECT * FROM mca_service_benefits WHERE service_id = $service_id";
$benefits = $conn->query($sql_benefits);

$sql_faqs = "SELECT * FROM mca_service_faqs WHERE service_id = $service_id";
$faqs = $conn->query($sql_faqs);

$sql_testimonials = "SELECT * FROM mca_service_testimonials WHERE service_id = $service_id";
$testimonials = $conn->query($sql_testimonials);

// Fetch form fields
$sql_fields = "SELECT * FROM forms WHERE service_id = '$service_id'";
$result_fields = $conn->query($sql_fields);
$fields = [];
while ($row = $result_fields->fetch_assoc()) {
    $fields[] = $row;
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page_title = $conn->real_escape_string($_POST['page_title']);
    $page_description = $conn->real_escape_string($_POST['page_description']);
    $page_heading = $conn->real_escape_string($_POST['page_heading']);
    $page_content = $conn->real_escape_string($_POST['page_content']);

    // Handle file upload
    if (!empty($_FILES["page_banner"]["name"])) {
        $target_dir = "../userdata/";
        $page_banner = $target_dir . basename($_FILES["page_banner"]["name"]);
        move_uploaded_file($_FILES["page_banner"]["tmp_name"], $page_banner);
    } else {
        $page_banner = $service['page_banner'];
    }

    // Update service
    $slug = strtolower(str_replace(" ", "-", $page_title));
    $sql_update = "UPDATE mca_services SET 
                   page_title='$page_title', page_description='$page_description', 
                   page_heading='$page_heading', page_content='$page_content', 
                   page_banner='$page_banner', slug='$slug' 
                   WHERE id='$service_id'";
    $conn->query($sql_update);
    
    if ($conn->query($sql_update) === TRUE) {
        
        // Update dynamic form fields
    $conn->query("DELETE FROM forms WHERE service_id='$service_id'");

    if (!empty($_POST['field_label']) && !empty($_POST['field_type'])) {
        for ($i = 0; $i < count($_POST['field_label']); $i++) {
            $field_label = $conn->real_escape_string($_POST['field_label'][$i]);
            $field_type = $conn->real_escape_string($_POST['field_type'][$i]);

            $sql_form = "INSERT INTO forms (service_id, field_label, field_type) 
                         VALUES ('$service_id', '$field_label', '$field_type')";
            $conn->query($sql_form);
        }
    }
        
        // Update Benefits
        if (!empty($_POST['benefit_id'])) {
            foreach ($_POST['benefit_id'] as $key => $benefit_id) {
                $benefit_heading = $conn->real_escape_string($_POST['benefit_heading'][$key]);
                $benefit_content = $conn->real_escape_string($_POST['benefit_content'][$key]);
                if ($benefit_id == "new") {
                    // Insert new benefit
                    $sql_insert_benefit = "INSERT INTO mca_service_benefits (service_id, benefit_heading, benefit_content) 
                                           VALUES ('$service_id', '$benefit_heading', '$benefit_content')";
                    $conn->query($sql_insert_benefit);
                } else {
                    // Update existing benefit
                    $sql_update_benefit = "UPDATE mca_service_benefits SET 
                                           benefit_heading = '$benefit_heading',
                                           benefit_content = '$benefit_content'
                                           WHERE id = $benefit_id";
                    $conn->query($sql_update_benefit);
                }
            }
        }

        // Update FAQs
        if (!empty($_POST['faq_id'])) {
            foreach ($_POST['faq_id'] as $key => $faq_id) {
                $faq_question = $conn->real_escape_string($_POST['faq_question'][$key]);
                $faq_answer = $conn->real_escape_string($_POST['faq_answer'][$key]);
                if ($faq_id == "new") {
                    // Insert new FAQ
                    $sql_insert_faq = "INSERT INTO mca_service_faqs (service_id, question, answer) 
                                       VALUES ('$service_id', '$faq_question', '$faq_answer')";
                    $conn->query($sql_insert_faq);
                } else {
                    // Update existing FAQ
                    $sql_update_faq = "UPDATE mca_service_faqs SET 
                                       question = '$faq_question',
                                       answer = '$faq_answer'
                                       WHERE id = $faq_id";
                    $conn->query($sql_update_faq);
                }
            }
        }

        // Update Testimonials
        if (!empty($_POST['testimonial_id'])) {
            foreach ($_POST['testimonial_id'] as $key => $testimonial_id) {
                $testimonial_name = $conn->real_escape_string($_POST['testimonial_name'][$key]);
                $testimonial_profession = $conn->real_escape_string($_POST['testimonial_profession'][$key]);
                $testimonial_text = $conn->real_escape_string($_POST['testimonial_text'][$key]);
                $testimonial_rating = $_POST['testimonial_rating'][$key];
                if ($testimonial_id == "new") {
                    // Insert new testimonial
                    $sql_insert_testimonial = "INSERT INTO mca_service_testimonials (service_id, name, profession, testimonial_text, rating) 
                                               VALUES ('$service_id', '$testimonial_name', '$testimonial_profession', '$testimonial_text', '$testimonial_rating')";
                    $conn->query($sql_insert_testimonial);
                } else {
                    // Update existing testimonial
                    $sql_update_testimonial = "UPDATE mca_service_testimonials SET 
                                               name = '$testimonial_name',
                                               profession = '$testimonial_profession',
                                               testimonial_text = '$testimonial_text',
                                               rating = '$testimonial_rating'
                                               WHERE id = $testimonial_id";
                    $conn->query($sql_update_testimonial);
                }
            }
        }

        echo "Service Updated Successfully!";
        // header("Location: mca_services.php");
        
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Update Service</h2>
            <form method="POST" enctype="multipart/form-data">
                <!-- Service Fields -->
                <div class="row">
                    <div class="col-md-4">
                        <label for="page_title">Page Title</label>
                        <input type="text" class="form-control" id="page_title" name="page_title" value="<?= $service['page_title'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="page_description">Page Description</label>
                        <input type="text" class="form-control" id="page_description" name="page_description" value="<?= $service['page_description'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="page_heading">Page Heading</label>
                        <input type="text" class="form-control" id="page_heading" name="page_heading" value="<?= $service['page_heading'] ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="page_content" class="form-label">Page Content</label>
                        <textarea class="form-control" id="page_content" name="page_content" required><?php echo htmlspecialchars($service['page_content']); ?></textarea><br>
                        <script>
                            CKEDITOR.replace('page_content');
                        </script><br>
                    </div>
                    <div class="col-md-6">
                        <label for="page_banner">Page Banner</label>
                        <input type="file" class="form-control" id="page_banner" name="page_banner">
                        <img src="<?= $service['page_banner'] ?>" alt="Banner" style="width: 100%; margin-top: 10px;">
                    </div>
                </div>

                <!-- Benefits -->
                <h3>Benefits</h3>
                <div id="benefits-container">
                    <?php while ($benefit = $benefits->fetch_assoc()): ?>
                        <div class="benefit-item">
                            <input type="hidden" name="benefit_id[]" value="<?= $benefit['id'] ?>">
                            <input type="text" class="form-control" name="benefit_heading[]" value="<?= $benefit['benefit_heading'] ?>" required>
                            <textarea class="form-control" name="benefit_content[]" required><?= $benefit['benefit_content'] ?></textarea>
                        </div>
                    <?php endwhile; ?>
                    <button type="button" class="btn btn-secondary" onclick="addBenefit()">Add New Benefit</button>
                </div>

                <!-- FAQs -->
                <h3>FAQs</h3>
                <div id="faqs-container">
                    <?php while ($faq = $faqs->fetch_assoc()): ?>
                        <div class="faq-item">
                            <input type="hidden" name="faq_id[]" value="<?= $faq['id'] ?>">
                            <input type="text" class="form-control" name="faq_question[]" value="<?= $faq['question'] ?>" required>
                            <textarea class="form-control" name="faq_answer[]" required><?= $faq['answer'] ?></textarea>
                        </div>
                    <?php endwhile; ?>
                    <button type="button" class="btn btn-secondary" onclick="addFAQ()">Add New FAQ</button>
                </div>

                <!-- Testimonials -->
                <h3>Testimonials</h3>
                <div id="testimonials-container">
                    <?php while ($testimonial = $testimonials->fetch_assoc()): ?>
                        <div class="testimonial-item">
                            <input type="hidden" name="testimonial_id[]" value="<?= $testimonial['id'] ?>">
                            <input type="text" class="form-control" name="testimonial_name[]" value="<?= $testimonial['name'] ?>" required>
                            <input type="text" class="form-control" name="testimonial_profession[]" value="<?= $testimonial['profession'] ?>" required>
                            <textarea class="form-control" name="testimonial_text[]" required><?= $testimonial['testimonial_text'] ?></textarea>
                            <input type="number" class="form-control" name="testimonial_rating[]" value="<?= $testimonial['rating'] ?>" required>
                        </div>
                    <?php endwhile; ?>
                    <button type="button" class="btn btn-secondary" onclick="addTestimonial()">Add New Testimonial</button>
                </div>
                
                 <h4>Dynamic Form Fields</h4>
        <div id="form-fields-container">
            <?php foreach ($fields as $field) : ?>
                <div class="form-field">
                    <input type="text" class="form-control" name="field_label[]" value="<?= $field['field_label'] ?>" required>
                    <select class="form-control" name="field_type[]" required>
                        <option value="text" <?= $field['field_type'] == 'text' ? 'selected' : '' ?>>Text</option>
                        <option value="email" <?= $field['field_type'] == 'email' ? 'selected' : '' ?>>Email</option>
                        <option value="number" <?= $field['field_type'] == 'number' ? 'selected' : '' ?>>Number</option>
                        <option value="date" <?= $field['field_type'] == 'date' ? 'selected' : '' ?>>Date</option>
                        <option value="textarea" <?= $field['field_type'] == 'textarea' ? 'selected' : '' ?>>Textarea</option>
                        <option value="file" <?= $field['field_type'] == 'file' ? 'selected' : '' ?>>File Upload</option>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addFormField()">Add Another Field</button>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// JavaScript to add more fields dynamically
function addBenefit() {
    const container = document.getElementById("benefits-container");
    const div = document.createElement("div");
    div.innerHTML = `
        <input type="hidden" name="benefit_id[]" value="new">
        <input type="text" class="form-control" name="benefit_heading[]" placeholder="Benefit Heading" required>
        <textarea class="form-control" name="benefit_content[]" placeholder="Benefit Content" required></textarea>
    `;
    container.appendChild(div);
}

function addFAQ() {
    const container = document.getElementById("faqs-container");
    const div = document.createElement("div");
    div.innerHTML = `
        <input type="hidden" name="faq_id[]" value="new">
        <input type="text" class="form-control" name="faq_question[]" placeholder="Question" required>
        <textarea class="form-control" name="faq_answer[]" placeholder="Answer" required></textarea>
    `;
    container.appendChild(div);
}

function addTestimonial() {
    const container = document.getElementById("testimonials-container");
    const div = document.createElement("div");
    div.innerHTML = `
        <input type="hidden" name="testimonial_id[]" value="new">
        <input type="text" class="form-control" name="testimonial_name[]" placeholder="Name" required>
        <input type="text" class="form-control" name="testimonial_profession[]" placeholder="Profession" required>
        <textarea class="form-control" name="testimonial_text[]" placeholder="Testimonial" required></textarea>
        <input type="number" class="form-control" name="testimonial_rating[]" placeholder="Rating" required>
    `;
    container.appendChild(div);
}

function addFormField() {
    const container = document.getElementById("form-fields-container");
    const newField = document.createElement("div");
    newField.classList.add("form-field");
    newField.innerHTML = `
        <input type="text" class="form-control" name="field_label[]" placeholder="Field Label" required>
        <select class="form-control" name="field_type[]" required>
            <option value="text">Text</option>
            <option value="email">Email</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
            <option value="textarea">Textarea</option>
            <option value="file">File Upload</option>
        </select>
    `;
    container.appendChild(newField);
}
</script>

<?php include("includes/footer.php"); ?>
 