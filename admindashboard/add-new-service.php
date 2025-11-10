<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $page_slug = $conn->real_escape_string($_POST['page_slug']);
    $page_title = $conn->real_escape_string($_POST['page_title']);
     $page_keywords = $conn->real_escape_string($_POST['page_keywords']);
    $page_description = $conn->real_escape_string($_POST['page_description']);
    $page_heading = $conn->real_escape_string($_POST['page_heading']);
    $page_content = $conn->real_escape_string($_POST['page_content']);
    $service_mrp = $conn->real_escape_string($_POST['service_mrp']);
    if (filter_var($_POST['service_mrp_link'], FILTER_VALIDATE_URL)) {
    $service_mrp_link = $conn->real_escape_string($_POST['service_mrp_link']);
}
    $benefits_section_subheading = $conn->real_escape_string($_POST['benefits_section_subheading']);
    $benefits_section_heading = $conn->real_escape_string($_POST['benefits_section_heading']);
    $required_section_subheading = $conn->real_escape_string($_POST['required_section_subheading']);
    $required_section_heading = $conn->real_escape_string($_POST['required_section_heading']);
    $faqs_section_subheading = $conn->real_escape_string($_POST['faqs_section_subheading']);
    $faqs_section_heading = $conn->real_escape_string($_POST['faqs_section_heading']);
    $category_id = $_POST['category_id'];
$subcategory_id = $_POST['subcategory_id'] ?? null; // Optional

    // Handle file upload for banner
    $target_dir = "../userdata/";
    $page_banner = $target_dir . basename($_FILES["page_banner"]["name"]);
    move_uploaded_file($_FILES["page_banner"]["tmp_name"], $page_banner);

    // Insert into `mca_services`
    $slug = strtolower(str_replace(" ", "-", $page_slug));
$sql = "INSERT INTO mca_services (page_title, page_keywords, page_description, page_heading, service_mrp, service_mrp_link, benefits_section_subheading, benefits_section_heading, documents_section_subheading, documents_section_heading, faqs_section_subheading, faqs_section_heading, page_content, page_banner, slug, service_name, category_id, subcategory_id) 
        VALUES ('$page_title', '$page_keywords', '$page_description', '$page_heading', '$service_mrp', '$service_mrp_link', '$benefits_section_subheading', '$benefits_section_heading', '$required_section_subheading', '$required_section_heading', '$faqs_section_subheading', '$faqs_section_heading', '$page_content', '$page_banner', '$slug', '$page_slug', '$category_id', " . ($subcategory_id ? "'$subcategory_id'" : "NULL") . ")";

    if ($conn->query($sql) === TRUE) {
        $service_id = $conn->insert_id;
        
        // Insert Benefits (if any)
        if (!empty($_POST['benefit_heading']) && !empty($_POST['benefit_content'])) {
            for ($i = 0; $i < count($_POST['benefit_heading']); $i++) {
                $benefit_heading = $conn->real_escape_string($_POST['benefit_heading'][$i]);
                $benefit_content = $conn->real_escape_string($_POST['benefit_content'][$i]);
                $sql_benefit = "INSERT INTO mca_service_benefits (service_id, benefit_heading, benefit_content) 
                                VALUES ('$service_id', '$benefit_heading', '$benefit_content')";
                $conn->query($sql_benefit);
            }
        }
        
                  // Insert Required Documents (if any)
        if (!empty($_POST['required_heading']) && !empty($_POST['required_content'])) {
            for ($i = 0; $i < count($_POST['required_heading']); $i++) {
                $required_heading = $conn->real_escape_string($_POST['required_heading'][$i]);
                $required_content = $conn->real_escape_string($_POST['required_content'][$i]);
                $sql_document = "INSERT INTO mca_services_documents (service_id, required_heading, required_content) 
                                VALUES ('$service_id', '$required_heading', '$required_content')";
                $conn->query($sql_document);
            }
        }
        
        // Insert FAQs (if any)
        if (!empty($_POST['faq_question']) && !empty($_POST['faq_answer'])) {
            for ($i = 0; $i < count($_POST['faq_question']); $i++) {
                $faq_question = $conn->real_escape_string($_POST['faq_question'][$i]);
                $faq_answer = $conn->real_escape_string($_POST['faq_answer'][$i]);
                $sql_faq = "INSERT INTO mca_service_faqs (service_id, question, answer) 
                            VALUES ('$service_id', '$faq_question', '$faq_answer')";
                $conn->query($sql_faq);
            }
        }


        // Insert Dynamic Form Fields into `forms`
if (!empty($_POST['field_label']) && !empty($_POST['field_type'])) {
    for ($i = 0; $i < count($_POST['field_label']); $i++) {
        $field_label = $conn->real_escape_string($_POST['field_label'][$i]);
        $field_name = $conn->real_escape_string($_POST['field_name'][$i]); // New field
        $field_type = $conn->real_escape_string($_POST['field_type'][$i]);
        $is_required = isset($_POST['is_required'][$i]) ? 1 : 0; // Store required status

        $sql_form = "INSERT INTO forms (service_id, field_label, field_name, field_type, is_required) 
                     VALUES ('$service_id', '$field_label', '$field_name', '$field_type', '$is_required')";
        $conn->query($sql_form);
    }
}

 echo "<script>alert('Service Added successfully!'); window.location.href='manage-services.php';</script>";
        // echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<style>
    .cke_notification_warning{
        display:none !important;
    }
</style>
<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Add New Service</h2>
            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        <label for="page_slug" class="form-label">Page Slug / Page Name</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Do Not Use Any Special Characters</p>
                        <input type="text" class="form-control" id="page_slug" name="page_slug" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        <label for="page_title" class="form-label">Page Title</label>
                        <input type="text" class="form-control" id="page_title" name="page_title" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        <label for="page_keywords" class="form-label">Page Keywords</label>
                        <input type="text" class="form-control" id="page_keywords" name="page_keywords" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        <label for="page_description" class="form-label">Page Description</label>
                        <input type="text" class="form-control" id="page_description" name="page_description" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_heading" class="form-label">Page Heading</label>
                        <input type="text" class="form-control" id="page_heading" name="page_heading" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_content" class="form-label">Page Content</label>
                        <textarea class="form-control" id="page_content" name="page_content" required></textarea><br>
                        <script>CKEDITOR.replace('page_content');</script><br>
                    </div>
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_banner" class="form-label">Page Banner</label>
                        <input type="file" class="form-control" id="page_banner" name="page_banner" accept="image/*" required>
                    </div>
                    
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        <label for="service_mrp" class="form-label">Service MRP Text</label>
                        <input type="text" class="form-control" id="service_mrp" name="service_mrp">
                    </div>
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        <label for="service_mrp_link" class="form-label">Pay Now Link</label>
                        <input type="url" class="form-control" id="service_mrp_link" name="service_mrp_link">
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="row" style="margin-bottom:15px;">
                     <label for="benefit_heading" class="form-label">Benefits</label>
                    <div class="col-md-6">
                        <label for ="benefit_section_subheading" class="form-label">Section Sub Heading</label>
                               <input type="text" class="form-control" id="benefits_section_subheading" name="benefits_section_subheading">
                    </div>
                    <div class="col-md-6">
                        <label for ="benefit_section_subheading" class="form-label">Section Heading</label>
                               <input type="text" class="form-control" id="benefits_section_heading" name="benefits_section_heading">
                    </div>
                    
                    <div class="col-md-12">
                       
                        <p style="color:#ffaa0a;padding-bottom:10px;">*4 Benefits Should be listed</p>
                        <div id="benefits-container">
                            <div class="benefit-item">
                                <input type="text" class="form-control" name="benefit_heading[]" placeholder="Benefit Heading">
                                <textarea class="form-control" name="benefit_content[]" placeholder="Benefit Content"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addBenefit()">Add Another Benefit</button>
                    </div>
                </div>
                
                                <!-- Required Documents Section -->
                <div class="row" style="margin-bottom:15px;">
                     <label for="required_heading" class="form-label">Required Documents</label>
                    <div class="col-md-6">
                        <label for ="required_section_subheading" class="form-label">Section Sub Heading</label>
                               <input type="text" class="form-control" id="required_section_subheading" name="required_section_subheading">
                    </div>
                    <div class="col-md-6">
                        <label for ="required_section_heading" class="form-label">Section Heading</label>
                               <input type="text" class="form-control" id="required_section_heading" name="required_section_heading">
                    </div>
                    
                    <div class="col-md-12">
                        <p style="color:#ffaa0a;padding-bottom:10px;">*3-4 Required Documents Should be listed</p>
                        <div id="required-container">
                            <div class="required-item">
                                <input type="text" class="form-control" name="required_heading[]" placeholder="Required Document Heading">
                                <textarea class="form-control" name="required_content[]" placeholder="Required Document Content"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addRequired()">Add Another Required Document</button>
                    </div>
                </div>

                <!-- FAQs Section -->
                <div class="row" style="margin-bottom:15px;">
                    <label for="faq_question" class="form-label">Frequently Asked Questions</label>
                    <div class="col-md-6">
                        <label for ="faqs_section_subheading" class="form-label">Section Sub Heading</label>
                               <input type="text" class="form-control" id="faqs_section_subheading" name="faqs_section_subheading">
                    </div>
                    <div class="col-md-6">
                        <label for ="faqs_section_subheading" class="form-label">Section Heading</label>
                               <input type="text" class="form-control" id="faqs_section_heading" name="faqs_section_heading">
                    </div>
                    <div class="col-md-12">
                        <p style="color:#ffaa0a;padding-bottom:10px;">*4 FAQs Should be listed</p>
                        <div id="faqs-container">
                            <div class="faq-item">
                                <input type="text" class="form-control" name="faq_question[]" placeholder="Question">
                                <textarea class="form-control" name="faq_answer[]" placeholder="Answer"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addFAQ()">Add Another FAQ</button>
                    </div>
                </div>

             <!-- Dynamic Form Fields Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <h4>Dynamic Form Fields</h4>
        <div id="form-fields-container">
            <div class="form-field">
                <input type="text" class="form-control field-label" name="field_label[]" placeholder="Field Label" oninput="generateFieldName(this)">
                <input type="hidden" class="form-control field-name" name="field_name[]" readonly> <!-- Hidden field_name -->
                <select class="form-control" name="field_type[]" >
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="textarea">Textarea</option>
                    <option value="file">File Upload</option> 
                </select>
                <label>
                    <input type="checkbox" name="is_required[]" value="1"> Required
                </label>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addFormField()">Add Another Field</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
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

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </div>
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
// Add Required Documents
function addRequired() {
    const requiredContainer = document.getElementById("required-container");
    const newRequired = document.createElement("div");
    newRequired.classList.add("required-item");
    newRequired.innerHTML = `
        <input type="text" class="form-control" name="required_heading[]" placeholder="Required Document Heading" required>
        <textarea class="form-control" name="required_content[]" placeholder="Required Document Content" required></textarea>
    `;
    requiredContainer.appendChild(newRequired);
}
// Add Benefit
function addBenefit() {
    const benefitsContainer = document.getElementById("benefits-container");
    const newBenefit = document.createElement("div");
    newBenefit.classList.add("benefit-item");
    newBenefit.innerHTML = `
        <input type="text" class="form-control" name="benefit_heading[]" placeholder="Benefit Heading" required>
        <textarea class="form-control" name="benefit_content[]" placeholder="Benefit Content" required></textarea>
    `;
    benefitsContainer.appendChild(newBenefit);
}

// Add FAQ
function addFAQ() {
    const faqsContainer = document.getElementById("faqs-container");
    const newFAQ = document.createElement("div");
    newFAQ.classList.add("faq-item");
    newFAQ.innerHTML = `
        <input type="text" class="form-control" name="faq_question[]" placeholder="Question" required>
        <textarea class="form-control" name="faq_answer[]" placeholder="Answer" required></textarea>
    `;
    faqsContainer.appendChild(newFAQ);
}

// Function to generate `field_name` based on `field_label`
function generateFieldName(input) {
    let label = input.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
    input.parentElement.querySelector(".field-name").value = label;
}

// JavaScript to add more dynamic form fields
function addFormField() {
    const container = document.getElementById("form-fields-container");
    const newField = document.createElement("div");
    newField.classList.add("form-field");
    newField.innerHTML = `
        <input type="text" class="form-control field-label" name="field_label[]" placeholder="Field Label" required oninput="generateFieldName(this)">
        <input type="hidden" class="form-control field-name" name="field_name[]" readonly> <!-- Hidden field_name -->
        <select class="form-control" name="field_type[]" required>
            <option value="text">Text</option>
            <option value="email">Email</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
            <option value="textarea">Textarea</option>
            <option value="file">File Upload</option> 
        </select>
        <label>
            <input type="checkbox" name="is_required[]" value="1"> Required
        </label>
    `;
    container.appendChild(newField);
}
</script>

<?php include("includes/footer.php"); ?>
