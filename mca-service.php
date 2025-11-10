<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config/connection.php");

// Check if `slug` and `id` are provided in the URL
if (isset($_GET['slug']) && isset($_GET['id'])) {
    $slug = $conn->real_escape_string($_GET['slug']);
    $service_id = intval($_GET['id']); // Ensure `id` is an integer

    // Fetch the service details
    $sql = "SELECT * FROM mca_services WHERE slug = '$slug' AND id = $service_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $servicedata = $result->fetch_assoc();

        // Fetch Benefits for this service
        $sql_benefits = "SELECT * FROM mca_service_benefits WHERE service_id = $service_id";
        $result_benefits = $conn->query($sql_benefits);

        // Fetch docuements for this service
        $sql_documents = "SELECT * FROM mca_services_documents WHERE service_id = $service_id";
        $result_documents = $conn->query($sql_documents);

        // Fetch FAQs for this service
        $sql_faqs = "SELECT * FROM mca_service_faqs WHERE service_id = $service_id";
        $result_faqs = $conn->query($sql_faqs);

        // Fetch Testimonials for this service
        $sql_testimonials = "SELECT * FROM mca_service_testimonials WHERE service_id = $service_id";
        $result_testimonials = $conn->query($sql_testimonials);
        // $testimonials = $result_testimonials->fetch_assoc();

        function safe_name($label)
        {
            return preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(trim($label)));
        }


        // $user_id = $_SESSION['userid'];
        $form_submitted = false;

        if (!isset($service_id)) {
            die("Service ID not found.");
        }

        $service_query = $conn->prepare("SELECT page_title FROM mca_services WHERE id = ?");
        $service_query->bind_param("i", $service_id);
        $service_query->execute();
        $service_result = $service_query->get_result();
        $service = $service_result->fetch_assoc();
        $service_title = $service['page_title'] ?? '';

        // Fetch form fields
        $sql_fields = "SELECT * FROM forms WHERE service_id = ?";
        $stmt_fields = $conn->prepare($sql_fields);
        $stmt_fields->bind_param("i", $service_id);
        $stmt_fields->execute();
        $result_fields = $stmt_fields->get_result();

        $form_fields = [];
        $required_fields = [];

        while ($field = $result_fields->fetch_assoc()) {
            $field['safe_name'] = safe_name($field['field_label']);
            $form_fields[] = $field;
            if ($field['is_required'] == 1) {
                $required_fields[] = $field['safe_name'];
            }
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['callback_form'])) {

            if (!isset($_SESSION['userid'])) {
                echo "<script>alert('Please log in to submit the form.'); window.location.href='config/login.php';</script>";
                exit;
            }

            $user_id = $_SESSION['userid']; // ✅ Now it's safe to use

            $missing_fields = [];

            foreach ($required_fields as $safe_name) {
                if (
                    (!isset($_POST[$safe_name]) || trim($_POST[$safe_name]) === '') &&
                    (!isset($_FILES[$safe_name]) || $_FILES[$safe_name]['error'] != 0)
                ) {
                    $missing_fields[] = $safe_name;
                }
            }

            if (!empty($missing_fields)) {
                echo "<script>alert('Missing required fields: " . implode(', ', $missing_fields) . "');</script>";
            } else {
                foreach ($form_fields as $field) {
                    $field_label = $field['field_label'];
                    $safe_name = $field['safe_name'];
                    $field_value = '';

                    if ($field['field_type'] === 'file' && isset($_FILES[$safe_name]) && $_FILES[$safe_name]['error'] === 0) {
                        $upload_dir = "userdata/";
                        $file_name = basename($_FILES[$safe_name]['name']);
                        $target_file = $upload_dir . time() . "_" . $file_name;

                        if (move_uploaded_file($_FILES[$safe_name]['tmp_name'], $target_file)) {
                            $field_value = $target_file;
                        } else {
                            $field_value = "File upload failed.";
                        }
                    } else {
                        $field_value = $conn->real_escape_string($_POST[$safe_name] ?? '');
                    }

                    $sql_insert = "INSERT INTO form_submissions (user_id, service_id, field_label, field_value, current_status)
                           VALUES (?, ?, ?, ?, 'On Process')";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("iiss", $user_id, $service_id, $field_label, $field_value);
                    $stmt_insert->execute();
                }

                $form_submitted = true;
                echo "<script>alert('Form submitted successfully!'); window.location.href='index.php';</script>";
            }
        }

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="<?php echo htmlspecialchars($servicedata['page_description']); ?>">
            <meta name="keywords" content="<?php echo htmlspecialchars($servicedata['page_keywords']); ?>">
            <title><?php echo htmlspecialchars($servicedata['page_title']); ?></title>
            <!--Favicon-->
            <link rel="icon" href="assets/img/favicon.png">
            <!-- Bootstrap CSS -->
            <link href="assets/css/bootstrap.min.css" rel="stylesheet">
            <!-- Line Awesome CSS -->
            <link href="assets/css/line-awesome.min.css" rel="stylesheet">
            <!-- Font Awesome CSS -->
            <link href="assets/css/fontAwesomePro.css" rel="stylesheet">
            <!-- Animate CSS-->
            <link href="assets/css/animate.css" rel="stylesheet">
            <!-- Bar Filler CSS -->
            <link href="assets/css/barfiller.css" rel="stylesheet">
            <!-- Magnific Popup Video -->
            <link href="assets/css/magnific-popup.css" rel="stylesheet">
            <!-- Flaticon CSS -->
            <link href="assets/css/flaticon.css" rel="stylesheet">
            <!-- Owl Carousel CSS -->
            <link href="assets/css/owl.carousel.css" rel="stylesheet">
            <!-- Slick Slider CSS -->
            <link href="assets/css/slick.css" rel="stylesheet">
            <!-- Nice Select  -->
            <link href="assets/css/nice-select.css" rel="stylesheet">
            <!-- Back to Top -->
            <link href="assets/css/backToTop.css" rel="stylesheet">
            <!-- Style CSS -->
            <link href="assets/css/style.css" rel="stylesheet">
            <!-- Responsive CSS -->
            <link href="assets/css/responsive.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


            <!-- jquery -->
            <script src="assets/js/jquery-1.12.4.min.js"></script>
            <style>
                .service-page-content h1 {
                    font-size: 45px;
                }

                .service-page-content h2 {
                    font-size: 40px;
                }

                .service-page-content h3 {
                    font-size: 35px;
                }

                .service-page-content h4 {
                    font-size: 30px;
                }

                .service-page-content h5 {
                    font-size: 25px;
                }

                .service-page-content h6 {
                    font-size: 20px;
                }

                .service-page-content img {
                    width: 100%;
                    position: relative;
                }

                .service-page-content ul {
                    list-style: normal;
                    display: grid;
                    padding-left: 25px;
                }

                .service-page-content ul li {
                    padding-top: 10px;
                    padding-bottom: 10px;
                    padding-left: 20px;
                }

                .service-page-content ul li::before {
                    content: '●';
                    /* Unicode black circle */
                    color: black;
                    /* Ensures it's black */
                    position: absolute;
                    left: 50px;
                    padding-right: 12px;
                }

                .breadcrumb-area.services .section-title p:before {
                    display: none !important;
                }
            </style>
        </head>

        <body>
            <?php include("includes/navbar.php"); ?>

            <div class="breadcrumb-area services section-padding light-bg-1 pb-0">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-sm-12 text-center">
                            <div class="section-title">
                                <p><?php echo htmlspecialchars($servicedata['service_name']); ?></p>
                                <h2><?php echo htmlspecialchars($servicedata['page_heading']); ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-90">
                        <div class="col-12">
                            <div class="bread-bg">
                                <?php $correctedPath = removeFirstThreeChars($servicedata['page_banner']); ?>
                                <img src="<?php echo $correctedPath; ?>" alt="MCA Service Banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Page  -->

            <div class="service-page pb-20">
                <div class="container">
                    <div class="col-xl-12">
                        <div class="service-page-content">
                            <?php echo $servicedata['page_content']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($result_benefits->num_rows > 0) { ?>
                <!-- Why Choose Us  -->
                <div class="choose-us-section section-padding light-bg-1" style="padding-top:0px;padding-bottom:0px;">
                    <div class="container">
                        <div class="row">
                            <div class="offset-xl-1 col-xl-10 text-center">
                                <div class="section-title">
                                    <h6><?php echo htmlspecialchars($servicedata['benefits_section_subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h6>
                                    <h2><?php echo htmlspecialchars($servicedata['benefits_section_heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-30">

                            <?php while ($benefit = $result_benefits->fetch_assoc()) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-12">

                                    <div class="single-feature-item mt-60">
                                        <div class="feature-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="feature-title">
                                            <h4><?php echo htmlspecialchars($benefit['benefit_heading']); ?></h4>
                                        </div>
                                        <p class="text-black"><?php echo nl2br(htmlspecialchars($benefit['benefit_content'])); ?></p>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } else {
            } ?>

            <?php if ($result_documents->num_rows > 0) { ?>
                <!-- Why Choose Us  -->
                <div class="process-section process-two section-padding" style="padding-bottom:0px;padding-top:10px;">
                    <div class="container">
                        <div class="row">
                            <div class="offset-xl-1 col-xl-10 text-center">
                                <div class="section-title">
                                    <h6><?php echo htmlspecialchars($servicedata['documents_section_subheading']); ?></h6>
                                    <h2><?php echo htmlspecialchars($servicedata['documents_section_heading']); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <?php while ($document = $result_documents->fetch_assoc()) { ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                    <div class="single-process-item" style="justify-content:normal !important;">
                                        <div class="process-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="process-content">
                                            <h4><?php echo htmlspecialchars($document['required_heading']); ?></h4>
                                            <p><?php echo nl2br(htmlspecialchars($document['required_content'])); ?></p>
                                        </div>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } else {
            } ?>

            <?php if (!empty($servicedata['service_mrp'])) { ?>
                <div class="contact-section contact-two pt-60">
                    <div class="container">
                        <div class="contact-innner green-bg d-flex align-items-center justify-content-center" style="background:#0b0562;">
                            <div class="text-left" style="width:70%;">
                                <h3 style="font-family:roboto, sans-serif;padding-left:15px;">
                                    <?php echo htmlspecialchars($servicedata['service_mrp']); ?>
                                </h3>
                            </div>
                            <div class="text-right">
                                <a href="<?php echo htmlspecialchars($servicedata['service_mrp_link']); ?>" style="margin:6px; background-color:#11e2f7; border:none; color:white; padding:10px 20px;">
                                    Pay Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php if (isset($_SESSION['name']) && !empty($form_fields)): ?>
                <div class="blog-details-page light-bg-1">
                    <div class="container">
                        <div class="row mt-30">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="comments-form-wrap">
                                    <h3>Fill the Form</h3>
                                    <div class="comments-form">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <?php foreach ($form_fields as $field) {
                                                    $safe_name = $field['safe_name'];
                                                    $required_attr = ($field['is_required'] == 1) ? 'required' : '';
                                                ?>
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <label for="<?= $safe_name ?>">
                                                            <?= htmlspecialchars($field['field_label']) ?>:
                                                        </label>

                                                        <?php if (in_array($field['field_type'], ['text', 'email', 'number', 'date'])) { ?>
                                                            <input type="<?= $field['field_type'] ?>"
                                                                id="<?= $safe_name ?>"
                                                                name="<?= $safe_name ?>"
                                                                placeholder="Enter <?= htmlspecialchars($field['field_label']) ?>"
                                                                <?= $required_attr ?>>
                                                        <?php } elseif ($field['field_type'] === 'textarea') { ?>
                                                            <textarea id="<?= $safe_name ?>"
                                                                name="<?= $safe_name ?>"
                                                                placeholder="Enter <?= htmlspecialchars($field['field_label']) ?>"
                                                                rows="4"
                                                                <?= $required_attr ?>></textarea>
                                                        <?php } elseif ($field['field_type'] === 'file') { ?>
                                                            <input type="file"
                                                                id="<?= $safe_name ?>"
                                                                name="<?= $safe_name ?>"
                                                                <?= $required_attr ?>>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-12">
                                                    <input type="submit" name="callback_form" value="Submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif (!isset($_SESSION['name'])): ?>
                <div class="blog-details-page light-bg-1">
                    <div class="container">
                        <div class="row mt-30">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="comments-form-wrap">
                                    <h3>Enquiry Form</h3>
                                    <div class="comments-form">
                                        <form action="config/send-mca-callback.php" method="POST" id="enquiry-form">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-12">
                                                    <label for="name">Name :</label>
                                                    <input type="text" id="name" name="name" placeholder="Enter Your Name" required>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-12">
                                                    <label for="email">Email :</label>
                                                    <input type="email" id="email" name="email" placeholder="Enter Your Email Address" required>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-12">
                                                    <label for="phone">Phone Number :</label>
                                                    <input type="text" id="phone" name="phone" placeholder="Enter Your Phone Number" required>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <label for="message">Message :</label>
                                                    <textarea id="message" name="message" placeholder="Enter Your Message" rows="4" required></textarea>
                                                </div>

                                                <input type="hidden" value="<?php echo htmlspecialchars($servicedata['service_name']); ?>" name="purpose">

                                                <div class="col-12">
                                                    <input type="submit" name="callback_form" value="Submit Enquiry">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>



            <!-- FAQ Section -->
            <?php if ($result_faqs->num_rows > 0) { ?>
                <div class="faq-section section-padding dark-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                                <div class="section-title">
                                    <h6><?php echo htmlspecialchars($servicedata['faqs_section_subheading']); ?></h6>
                                    <h2 class="text-white"><?php echo htmlspecialchars($servicedata['faqs_section_heading']); ?>
                                    </h2>
                                </div>

                                <div class="accordion faqs" id="accordionFaq">
                                    <?php while ($faq = $result_faqs->fetch_assoc()) { ?>
                                        <div class="card">
                                            <div class="card-header" id="heading1">
                                                <h5 class="mb-0 subtitle">
                                                    <button class="btn btn-link collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                        <?php echo htmlspecialchars($faq['question']); ?>

                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionFaq">
                                                <div class="card-body">
                                                    <div class="content">
                                                        <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="faq-section-gallery">
                                    <div class="faq-img-one wow fadeInDown animated" data-wow-delay="200ms">
                                        <img src="assets/img/faq_1.jpg" alt="">
                                    </div>
                                    <div class="faq-img-two wow fadeInRight animated" data-wow-delay="300ms">
                                        <img src="assets/img/faq_3.jpg" alt="">
                                    </div>
                                    <div class="faq-img-three wow fadeInUp animated" data-wow-delay="400ms">
                                        <img src="assets/img/faq_2.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_shape_top">
                        <img src="assets/img/faq_shape_top.png" alt="">
                    </div>
                    <div class="faq_shape_bottom">
                        <img src="assets/img/faq_shape_bottom.png" alt="">
                    </div>
                </div>
            <?php } else {
            } ?>

            <?php if ($form_submitted): ?>
                <div class="alert alert-success">Form submitted successfully!</div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <div class="alert alert-danger">Form submission failed! Please try again.</div>
            <?php endif; ?>


            <div class="testimonial-section section-padding" style="padding-top:40px;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 text-center">
                            <div class="section-title">
                                <h6>Google Verified Reviews</h6>
                                <h2>Client Experiences & Reviews</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="testimonial-wrapper-one">
                                <div class="testimonial-author-wrap">

                                    <div class="single-testimonial-author d-flex align-items-center">
                                        <div class="testimonial-content">
                                            <h6>Trilok Srivastava</h6>
                                            <p>4 Months Ago</p>
                                        </div>
                                    </div>

                                    <div class="single-testimonial-author d-flex align-items-center">
                                        <div class="testimonial-content">
                                            <h6>Ashish Kumar</h6>
                                            <p>6 Months Ago</p>
                                        </div>
                                    </div>

                                    <div class="single-testimonial-author d-flex align-items-center">
                                        <div class="testimonial-content">
                                            <h6>Shishpal Singh</h6>
                                            <p>8 Months Ago</p>
                                        </div>
                                    </div>

                                    <div class="single-testimonial-author d-flex align-items-center">
                                        <div class="testimonial-content">
                                            <h6>Bhawna Ahlawat</h6>
                                            <p>11 Months Ago</p>
                                        </div>
                                    </div>

                                    <div class="single-testimonial-author d-flex align-items-center">
                                        <div class="testimonial-content">
                                            <h6>Rajesh Maheshwari</h6>
                                            <p>A Year Ago</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="testimonial-slider-wrap">

                                    <div class="testimonial-slide-inner">
                                        <div class="testimonal-slider-content">
                                            <h6>Trilok Srivastava</h6>
                                            <p class="designation">4 months ago</p>
                                            <p>Truly Professionals team always accessible & one call away whenever we need their support.
                                                And yes quite supportive,genuiene,polite & humble in communications.</p>
                                            <div class="testimonal-review-wrap">
                                                <span><img src="assets/img/google-icon.svg" alt="Google Icon" width="30" height="30"></span>
                                                <ul>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-slide-inner">
                                        <div class="testimonal-slider-content">
                                            <h6>Ashish Kumar</h6>
                                            <p class="designation">6 months ago</p>
                                            <p>Swift service, I got my DSC within 1 hrs while other committing for 2 days.
                                                Indeed Excellent and speedy service. Love to use their service in future and recommend for others.</p>
                                            <div class="testimonal-review-wrap">
                                                <span><img src="assets/img/google-icon.svg" alt="Google Icon" width="30" height="30"></span>
                                                <ul>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-slide-inner">
                                        <div class="testimonal-slider-content">
                                            <h6>Shishpal Singh</h6>
                                            <p class="designation">8 Months Ago</p>
                                            <p>I had a great experience with your company. The group offered “the best service” with a good-natured and approachable team. Their **friendly reminders** were helpful, and they maintained a high level of -professionalism- throughout. Highly recommend!
                                                Thanks, Shishpal</p>
                                            <div class="testimonal-review-wrap">
                                                <span><img src="assets/img/google-icon.svg" alt="Google Icon" width="30" height="30"></span>
                                                <ul>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-slide-inner">
                                        <div class="testimonal-slider-content">
                                            <h6>Bhawna Ahlawat</h6>
                                            <p class="designation">11 Months Ago</p>
                                            <p>The services with the prompt response is excellent work on time cooperative staff can avail their services . Keshav sir is very knowledgeable person and guides the client with patience, this is the third time i have been filing itr with this team. Good job keep going</p>
                                            <div class="testimonal-review-wrap">
                                                <span><img src="assets/img/google-icon.svg" alt="Google Icon" width="30" height="30"></span>
                                                <ul>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-slide-inner">
                                        <div class="testimonal-slider-content">
                                            <h6>Rajesh Maheshwari</h6>
                                            <p class="designation">A Year Ago</p>
                                            <p>Our Company and team is excellent and work very closely with their clients. They provide full support and possess good knowledge with huge experience. I am availing their services for IT return filing from past many years and I am highly satisfied.</p>
                                            <div class="testimonal-review-wrap">
                                                <span><img src="assets/img/google-icon.svg" alt="Google Icon" width="30" height="30"></span>
                                                <ul>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                    <li><i class="las la-star" style="color:yellow !important;"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section  -->

            <div class="cta-area bg-cover" data-background="assets/img/cta_bg.jpg">
                <div class="overlay"></div>
                <div class="cta-area-inner pt-150">
                    <div class="container">
                        <div class="offset-xl-1 col-xl-7 offset-lg-1 col-lg-7 offset-md-1 col-md-7">
                            <div class="section-title">
                                <h6>Get Assistance Today</h6>
                                <h2 class="text-white">Let’s Grow Your Business Together</h2>
                            </div>

                        </div>
                        <div class="offset-xl-5 col-xl-6">
                            <p class="text-white">Whether you need tax filing, legal consulting, or business registration services, we are here to help. Our expert team at our company offers tailored solutions for individuals and businesses across India. Take the first step toward hassle-free legal and tax services today</p>
                        </div>

                        <div class="explore-btn">
                            <a href="contact.php">Contact Us Now<i class="las la-arrow-right"></i></a>
                        </div>

                    </div>
                </div>
            </div>

            <?php include("includes/footer.php"); ?>

    <?php
    } else {
        // Service not found
        echo "Service not found!";
    }
} else {
    // Missing required parameters

    // You have made no changes to save.
    echo "Invalid request!";
}
    ?>