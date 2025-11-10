<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

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

// Fetch categories
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

// Fetch associated data
$sql_benefits = "SELECT * FROM mca_service_benefits WHERE service_id = $service_id";
$benefits = $conn->query($sql_benefits);

$sql_documents = "SELECT * FROM mca_services_documents WHERE service_id = $service_id";
$documents = $conn->query($sql_documents);

$sql_faqs = "SELECT * FROM mca_service_faqs WHERE service_id = $service_id";
$faqs = $conn->query($sql_faqs);

$sql_fields = "SELECT * FROM forms WHERE service_id = '$service_id'";
$fields = $conn->query($sql_fields);

// Update logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Service details update
    $page_title = $conn->real_escape_string($_POST['page_title']);
    $page_description = $conn->real_escape_string($_POST['page_description']);
    $page_heading = $conn->real_escape_string($_POST['page_heading']);
    $page_content = $conn->real_escape_string($_POST['page_content']);
    $page_keywords = $conn->real_escape_string($_POST['page_keywords']);
    $page_slug = $conn->real_escape_string($_POST['page_slug']);
    $service_mrp = $conn->real_escape_string($_POST['service_mrp']);
    $service_mrp_link = $conn->real_escape_string($_POST['service_mrp_link']);

    $benefits_subheading = $conn->real_escape_string($_POST['benefits_subheading']);
    $benefits_heading = $conn->real_escape_string($_POST['benefits_heading']);
    $documents_subheading = $conn->real_escape_string($_POST['documents_subheading']);
    $documents_heading = $conn->real_escape_string($_POST['documents_heading']);
    $faqs_subheading = $conn->real_escape_string($_POST['faqs_subheading']);
    $faqs_heading = $conn->real_escape_string($_POST['faqs_heading']);
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'] ?? null; 

    // Banner handling
    if (!empty($_FILES['page_banner']['name'])) {
        $target_dir = "../userdata/";
        $page_banner = $target_dir . basename($_FILES["page_banner"]["name"]);
        move_uploaded_file($_FILES["page_banner"]["tmp_name"], $page_banner);
    } else {
        $page_banner = $service['page_banner'];
    }

    if (isset($_POST['delete_banner']) && $_POST['delete_banner'] == 'on') {
        $page_banner = '';
    }
    
       // Insert into `mca_services`
    $slug = strtolower(str_replace(" ", "-", $page_slug));

    // Update mca_services
    $sql_update_service = "UPDATE mca_services SET page_title = '$page_title', page_description = '$page_description', page_banner = '$page_banner', page_heading = '$page_heading', service_mrp = '$service_mrp', service_mrp_link = '$service_mrp_link', benefits_section_subheading = '$benefits_subheading', benefits_section_heading = '$benefits_heading', documents_section_subheading = '$documents_subheading', documents_section_heading = '$documents_heading', faqs_section_subheading = '$faqs_subheading', faqs_section_heading = '$faqs_heading',  page_content = '$page_content', page_keywords = '$page_keywords', slug = '$slug', service_name = '$page_slug', category_id = '$category_id', subcategory_id=" . ($subcategory_id ? "'$subcategory_id'" : "NULL") . " WHERE id = '$service_id'";
    $conn->query($sql_update_service);

    // Benefits update/delete/add
    if (isset($_POST['benefit_id'])) {
        foreach ($_POST['benefit_id'] as $key => $benefit_id) {
            $heading = $conn->real_escape_string($_POST['benefit_heading'][$key]);
            $content = $conn->real_escape_string($_POST['benefit_content'][$key]);

            if ($benefit_id == 'new') {
                // Add new benefit
                $sql_add_benefit = "INSERT INTO mca_service_benefits (service_id, benefit_heading, benefit_content) VALUES ('$service_id', '$heading', '$content')";
                $conn->query($sql_add_benefit);
            } else {
                // Update existing benefit
                $sql_update_benefit = "UPDATE mca_service_benefits SET benefit_heading = '$heading', benefit_content = '$content' WHERE id = '$benefit_id'";
                $conn->query($sql_update_benefit);

                // Delete benefits
                if (isset($_POST['delete_benefits']) && in_array($benefit_id, $_POST['delete_benefits'])) {
                    $sql_delete_benefit = "DELETE FROM mca_service_benefits WHERE id = '$benefit_id'";
                    $conn->query($sql_delete_benefit);
                }
            }
        }
    }

      // Documents update/delete/add
    if (isset($_POST['document_id'])) {
        foreach ($_POST['document_id'] as $key => $document_id) {
            // Check if keys exist before accessing
            $heading = isset($_POST['document_heading'][$key]) ? $conn->real_escape_string($_POST['document_heading'][$key]) : '';
            $content = isset($_POST['document_content'][$key]) ? $conn->real_escape_string($_POST['document_content'][$key]) : '';

            if ($document_id == 'new') {
                // Add new Document
                $sql_add_document = "INSERT INTO mca_services_documents (service_id, required_heading, required_content) VALUES ('$service_id', '$heading', '$content')";
                $conn->query($sql_add_document);
            } else {
                // Update existing Document
                $sql_update_document = "UPDATE mca_services_documents SET required_heading = '$heading', required_content = '$content' WHERE id = '$document_id'";
                $conn->query($sql_update_document);

                // Delete Documents
                if (isset($_POST['delete_documents']) && in_array($document_id, $_POST['delete_documents'])) {
                    $sql_delete_document = "DELETE FROM mca_services_documents WHERE id = '$document_id'";
                    $conn->query($sql_delete_document);
                }
            }
        }
    }

    // FAQs update/delete/add
    if (isset($_POST['faq_id'])) {
        foreach ($_POST['faq_id'] as $key => $faq_id) {
            $question = $conn->real_escape_string($_POST['faq_question'][$key]);
            $answer = $conn->real_escape_string($_POST['faq_answer'][$key]);

            if ($faq_id == 'new') {
                $sql_add_faq = "INSERT INTO mca_service_faqs (service_id, question, answer) VALUES ('$service_id', '$question', '$answer')";
                $conn->query($sql_add_faq);
            } else {
                $sql_update_faq = "UPDATE mca_service_faqs SET question = '$question', answer = '$answer' WHERE id = '$faq_id'";
                $conn->query($sql_update_faq);

                if (isset($_POST['delete_faqs']) && in_array($faq_id, $_POST['delete_faqs'])) {
                    $sql_delete_faq = "DELETE FROM mca_service_faqs WHERE id = '$faq_id'";
                    $conn->query($sql_delete_faq);
                }
            }
        }
    }

    // Dynamic Form Fields update/delete/add
    if (isset($_POST['field_id'])) {
        foreach ($_POST['field_id'] as $key => $field_id) {
            $label = $conn->real_escape_string($_POST['field_label'][$key]);
            $type = $conn->real_escape_string($_POST['field_type'][$key]);
            $name = $conn->real_escape_string($_POST['field_name'][$key]);
            $required = isset($_POST['is_required'][$field_id]) ? 1 : 0;

            if ($field_id == 'new') {
                $sql_add_field = "INSERT INTO forms (service_id, field_label, field_name, field_type, is_required) VALUES ('$service_id', '$label', '$name', '$type', '$required')";
                $conn->query($sql_add_field);
            } else {
                $sql_update_field = "UPDATE forms SET field_label = '$label', field_type = '$type', field_name = '$name', is_required = '$required' WHERE id = '$field_id'";
                $conn->query($sql_update_field);

                if (isset($_POST['delete_fields']) && in_array($field_id, $_POST['delete_fields'])) {
                    $sql_delete_field = "DELETE FROM forms WHERE id = '$field_id'";
                    $conn->query($sql_delete_field);
                }
            }
        }
    }

    echo "<script>alert('Service Updated Successfully'); window.location.href='manage-services.php?id=$service_id';</script>";
}
?>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<style>
    .cke_notification_warning{
        display:none !important;
    }
</style>
<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2 class="text-center">Update Service</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" name="page_title" class="form-control" value="<?= $service['page_title'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Page Description</label>
                    <textarea name="page_description" class="form-control"><?= $service['page_description'] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Page Keywords</label>
                    <input type="text" name="page_keywords" class="form-control" value="<?= $service['page_keywords'] ?>">
                </div>
                <div class="form-group">
                    <label>Page Slug / Page Name</label>
                    <input type="text" name="page_slug" class="form-control" value="<?= $service['slug'] ?>">
                </div>
                <div class="form-group">
                    <label>Page Banner</label>
                    <input type="file" name="page_banner" class="form-control">
                    <?php if ($service['page_banner']) : ?>
                        <img src="<?= $service['page_banner'] ?>" width="200">
                        <label>
                            <input type="checkbox" name="delete_banner"> Delete Existing Banner
                        </label>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Page Heading</label>
                    <input type="text" name="page_heading" class="form-control" value="<?= $service['page_heading'] ?>">
                </div>
                <div class="form-group">
                    <label>Page Content</label>
                    <textarea name="page_content" class="form-control ckeditor"><?= $service['page_content'] ?></textarea><br>
                    <script>CKEDITOR.replace('page_content');</script>
                </div>
                 <div class="form-group">
                    <label>Service MRP</label>
                    <input type="text" name="service_mrp" class="form-control" value="<?= $service['service_mrp'] ?>">
                </div>
                 <div class="form-group">
                    <label>Pay Now Link</label>
                    <input type="url" name="service_mrp_link" class="form-control" value="<?= $service['service_mrp_link'] ?>">
                </div>
                
                <p>Fill If These Section's Created</p>
                <div class="form-group">
                    <label>Benefits Sub Heading</label>
                    <input type="text" name="benefits_subheading" class="form-control" value="<?= $service['benefits_section_subheading'] ?>">
                </div>
                <div class="form-group">
                    <label>Benefits Heading</label>
                    <input type="text" name="benefits_heading" class="form-control" value="<?= $service['benefits_section_heading'] ?>">
                </div>
                <div class="form-group">
                    <label>Required Documents Sub Heading</label>
                    <input type="text" name="documents_subheading" class="form-control" value="<?= $service['documents_section_subheading'] ?>">
                </div>
                <div class="form-group">
                    <label>Required Documents Heading</label>
                    <input type="text" name="documents_heading" class="form-control" value="<?= $service['documents_section_heading'] ?>">
                </div>
                <div class="form-group">
                    <label>FAQ's Sub Heading</label>
                    <input type="text" name="faqs_subheading" class="form-control" value="<?= $service['faqs_section_subheading'] ?>">
                </div>
                <div class="form-group">
                    <label>FAQ's Heading</label>
                    <input type="text" name="faqs_heading" class="form-control" value="<?= $service['faqs_section_heading'] ?>">
                </div>
                

                <?php
                    // Benefits
                    echo "<h4>Benefits</h4>";
                    echo "<div id='benefits_section'>";
                    while ($benefit = $benefits->fetch_assoc()) {
                        echo "<div class='benefit-item'>";
                        echo "<input type='hidden' name='benefit_id[]' value='" . $benefit['id'] . "'>";
                        echo "<input type='text' name='benefit_heading[]' class='form-control' value='" . $benefit['benefit_heading'] . "' placeholder='Heading'>";
                        echo "<textarea name='benefit_content[]' class='form-control'>" . $benefit['benefit_content'] . "</textarea>";
                        echo "<input type='checkbox' name='delete_benefits[]' value='" . $benefit['id'] . "'> Delete";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<button type='button' class='btn btn-info' onclick='addBenefit()'>Add Benefit</button>";

              echo "<h4>Required Documents</h4>";
    echo "<div id='documents_section'>";
    while ($document = $documents->fetch_assoc()) {
        echo "<div class='document-item'>";
        echo "<input type='hidden' name='document_id[]' value='" . $document['id'] . "'>";
        echo "<input type='text' name='document_heading[]' class='form-control' value='" . $document['required_heading'] . "' placeholder='Document Heading'>";
        echo "<textarea name='document_content[]' class='form-control'>" . $document['required_content'] . "</textarea>";
        echo "<input type='checkbox' name='delete_documents[]' value='" . $document['id'] . "'> Delete";
        echo "</div>";
    }
    echo "</div>";
    echo "<button type='button' class='btn btn-info' onclick='addDocument()'>Add Document</button>";


                    // FAQs
                    echo "<h4>FAQs</h4>";
                    echo "<div id='faqs_section'>";
                    while ($faq = $faqs->fetch_assoc()) {
                        echo "<div class='faq-item'>";
                        echo "<input type='hidden' name='faq_id[]' value='" . $faq['id'] . "'>";
                        echo "<input type='text' name='faq_question[]' class='form-control' value='" . $faq['question'] . "' placeholder='Question'>";
                        echo "<textarea name='faq_answer[]' class='form-control'>" . $faq['answer'] . "</textarea>";
                        echo "<input type='checkbox' name='delete_faqs[]' value='" . $faq['id'] . "'> Delete";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<button type='button' class='btn btn-info' onclick='addFAQ()'>Add FAQ</button>";

                    // Dynamic Form Fields
                    echo "<h4>Dynamic Form Fields</h4>";
                    echo "<div id='form_fields_section'>";
                    while ($field = $fields->fetch_assoc()) {
                        echo "<div class='field-item'>";
                        echo "<input type='hidden' name='field_id[]' value='" . $field['id'] . "'>";
                        echo "<input type='text' name='field_label[]' class='form-control' value='" . $field['field_label'] . "' placeholder='Field Label'>";
                        echo "<input type='text' name='field_name[]' class='form-control' value='" . $field['field_name'] . "' placeholder='Field Name' readonly>";
                        echo "<select name='field_type[]' class='form-control'>";
                        echo "<option value='text' " . (($field['field_type'] == 'text') ? 'selected' : '') . ">Text</option>";
                        echo "<option value='number' " . (($field['field_type'] == 'number') ? 'selected' : '') . ">Number</option>";
                        echo "<option value='file' " . (($field['field_type'] == 'file') ? 'selected' : '') . ">File</option>";
                        echo "<option value='email' " . (($field['field_type'] == 'email') ? 'selected' : '') . ">Email</option>";
                        echo "<option value='date' " . (($field['field_type'] == 'date') ? 'selected' : '') . ">Date</option>";
                        echo "<option value='textarea' " . (($field['field_type'] == 'textarea') ? 'selected' : '') . ">Textarea</option>";
                        echo "</select>";
                        echo "<label><input type='checkbox' name='is_required[" . $field['id'] . "]' " . (($field['is_required'] == 1) ? 'checked' : '') . "> Required</label>";
                        echo "<input type='checkbox' name='delete_fields[]' value='" . $field['id'] . "'> Delete";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<button type='button' class='btn btn-info' onclick='addField()'>Add Field</button>";
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Select Category -->
<select name="category_id" id="category_select" required>
  <option value="">Select Category</option>
  <?php
    $catRes = $conn->query("SELECT * FROM categories");
    while ($cat = $catRes->fetch_assoc()) {
        echo "<option value='{$cat['id']}'>{$cat['category_name']}</option>";
    }
  ?>
</select>

<!-- Select Subcategory -->
<select name="subcategory_id" id="subcategory_select">
  <option value="">Select Subcategory (optional)</option>
  <?php
    $subRes = $conn->query("SELECT * FROM subcategories");
    while ($sub = $subRes->fetch_assoc()) {
        echo "<option value='{$sub['id']}' data-category='{$sub['category_id']}'>{$sub['subcategory_name']}</option>";
    }
  ?>
</select>
                    </div>
                </div>

                <br><br>
                <button type="submit" class="btn btn-success">Update Service</button>
            </form>
        </div>
    </div>
</div>

<script>
  // Optional JS to filter subcategories based on selected category
  document.getElementById('category_select').addEventListener('change', function () {
    const selectedCat = this.value;
    document.querySelectorAll('#subcategory_select option').forEach(opt => {
      if (opt.value === "") return opt.style.display = '';
      opt.style.display = opt.dataset.category === selectedCat ? '' : 'none';
    });
    document.getElementById('subcategory_select').value = '';
  });
</script>

<script>
    function addBenefit() {
        let div = document.createElement('div');
        div.innerHTML = `<input type="hidden" name="benefit_id[]" value="new">
                           <input type="text" name="benefit_heading[]" class="form-control" placeholder="Heading">
                           <textarea name="benefit_content[]" class="form-control"></textarea>`;
        document.getElementById('benefits_section').appendChild(div);
    }

    function addDocument() {
    let div = document.createElement('div');
    div.innerHTML = `<input type="hidden" name="document_id[]" value="new">
                     <input type="text" name="document_heading[]" class="form-control" placeholder="Document Heading">
                     <textarea name="document_content[]" class="form-control"></textarea>`;
    document.getElementById('documents_section').appendChild(div);
}

    function addFAQ() {
        let div = document.createElement('div');
        div.innerHTML = `<input type="hidden" name="faq_id[]" value="new">
                           <input type="text" name="faq_question[]" class="form-control" placeholder="Question">
                           <textarea name="faq_answer[]" class="form-control"></textarea>`;
        document.getElementById('faqs_section').appendChild(div);
    }

    function addField() {
        const container = document.getElementById("form_fields_section");
        const newField = document.createElement("div");
        newField.classList.add("field-item");
        newField.innerHTML = `
            <input type="hidden" name="field_id[]" value="new">
            <input type="text" class="form-control" name="field_label[]" placeholder="Field Label" oninput="generateFieldName(this)">
            <input type="text" class="form-control" name="field_name[]" placeholder="Field Name" readonly>
            <select class="form-control" name="field_type[]">
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="number">Number</option>
                <option value="date">Date</option>
                <option value="textarea">Textarea</option>
                <option value="file">File Upload</option>
            </select>
            <label><input type="checkbox" name="is_required[]" value="1"> Required</label>
        `;
        container.appendChild(newField);
    }

    function generateFieldName(input) {
        let label = input.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
        input.parentElement.querySelector("input[name='field_name[]']").value = label;
    }
</script>

<?php include("includes/footer.php"); ?>