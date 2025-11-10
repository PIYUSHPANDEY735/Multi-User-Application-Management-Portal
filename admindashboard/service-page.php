<?php
include("includes/header.php");
include("includes/navbar.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../config/admin_login.php");
    exit();
}

include("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page_title = $conn->real_escape_string($_POST['page_title']);
    $page_description = $conn->real_escape_string($_POST['page_description']);
    $page_heading = $conn->real_escape_string($_POST['page_heading']);
    $page_content = $conn->real_escape_string($_POST['page_content']);

    // Handle file upload for banner
    $target_dir = "../userdata/";
    $page_banner = $target_dir . basename($_FILES["page_banner"]["name"]);
    move_uploaded_file($_FILES["page_banner"]["tmp_name"], $page_banner);

    // Insert into `mca_services`
    $slug = strtolower(str_replace(" ", "-", $page_title));
    $sql = "INSERT INTO mca_services (page_title, page_description, page_heading, page_content, page_banner, slug) 
            VALUES ('$page_title', '$page_description', '$page_heading', '$page_content', '$page_banner', '$slug')";

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

        // Insert Testimonials (if any)
        if (!empty($_POST['testimonial_name']) && !empty($_POST['testimonial_text'])) {
            for ($i = 0; $i < count($_POST['testimonial_name']); $i++) {
                $testimonial_name = $conn->real_escape_string($_POST['testimonial_name'][$i]);
                $testimonial_profession = $conn->real_escape_string($_POST['testimonial_profession'][$i]);
                $testimonial_text = $conn->real_escape_string($_POST['testimonial_text'][$i]);
                $testimonial_rating = $_POST['testimonial_rating'][$i];
                $sql_testimonial = "INSERT INTO mca_service_testimonials (service_id, name, profession, testimonial_text, rating) 
                                    VALUES ('$service_id', '$testimonial_name', '$testimonial_profession', '$testimonial_text', '$testimonial_rating')";
                $conn->query($sql_testimonial);
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


        echo "Service & Form Fields added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<div class="inner-block">
    <div class="market-updates">
        <div class="container mt-5">
            <h2>Add New Service</h2>
            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        <label for="page_title" class="form-label">Page Title</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Do Not Use Any Special Characters</p>
                        <input type="text" class="form-control" id="page_title" name="page_title" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_description" class="form-label">Page Description</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Description should have only 18words</p>
                        <input type="text" class="form-control" id="page_description" name="page_description" required>
                    </div>
                    <div class="col-md-4" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_heading" class="form-label">Page Heading</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Page Heading should have only 5words</p>
                        <input type="text" class="form-control" id="page_heading" name="page_heading" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_content" class="form-label">Page Content</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Avoid this warning, Add content</p>
                        <textarea class="form-control" id="page_content" name="page_content" required></textarea><br>
                        <script>CKEDITOR.replace('page_content');</script><br>
                    </div>
                    <div class="col-md-6" style="margin-top:10px;margin-bottom:10px;">
                        
                        <label for="page_banner" class="form-label">Page Banner</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Use Ideal Banner Size (1600px X 500px)</p>
                        <input type="file" class="form-control" id="page_banner" name="page_banner" accept="image/*" required>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-12">
                        
                        <label for="benefit_heading" class="form-label">Benefits</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*4 Benefits Should be listed</p>
                        <div id="benefits-container">
                            <div class="benefit-item">
                                <input type="text" class="form-control" name="benefit_heading[]" placeholder="Benefit Heading" required>
                                <textarea class="form-control" name="benefit_content[]" placeholder="Benefit Content" required></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addBenefit()">Add Another Benefit</button>
                    </div>
                </div>

                <!-- FAQs Section -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-12">
                        
                        <label for="faq_question" class="form-label">FAQs</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*4 FAQs Should be listed</p>
                        <div id="faqs-container">
                            <div class="faq-item">
                                <input type="text" class="form-control" name="faq_question[]" placeholder="Question" required>
                                <textarea class="form-control" name="faq_answer[]" placeholder="Answer" required></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addFAQ()">Add Another FAQ</button>
                    </div>
                </div>

                <!-- Testimonials Section -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-12">
                        
                        <label for="testimonial_name" class="form-label">Testimonials</label>
                        <p style="color:#ffaa0a;padding-bottom:10px;">*Minimum 5 Testimonials are needed.</p>
                        <div id="testimonials-container">
                            <div class="testimonial-item">
                                <input type="text" class="form-control" name="testimonial_name[]" placeholder="Name" required>
                                <input type="text" class="form-control" name="testimonial_profession[]" placeholder="Profession" required>
                                <textarea class="form-control" name="testimonial_text[]" placeholder="Testimonial" required></textarea>
                                <input type="number" class="form-control" name="testimonial_rating[]" placeholder="Rating (1-5) like(3.2)" required min="1" max="5">
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addTestimonial()">Add Another Testimonial</button>
                    </div>
                </div>

             <!-- Dynamic Form Fields Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <h4>Dynamic Form Fields</h4>
        <div id="form-fields-container">
            <div class="form-field">
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
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addFormField()">Add Another Field</button>
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

// Add Testimonial
function addTestimonial() {
    const testimonialsContainer = document.getElementById("testimonials-container");
    const newTestimonial = document.createElement("div");
    newTestimonial.classList.add("testimonial-item");
    newTestimonial.innerHTML = `
        <input type="text" class="form-control" name="testimonial_name[]" placeholder="Name" required>
        <input type="text" class="form-control" name="testimonial_profession[]" placeholder="Profession" required>
        <textarea class="form-control" name="testimonial_text[]" placeholder="Testimonial" required></textarea>
        <input type="number" class="form-control" name="testimonial_rating[]" placeholder="Rating (1-5)" required min="1" max="5">
    `;
    testimonialsContainer.appendChild(newTestimonial);
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
