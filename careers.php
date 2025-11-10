<?php
include("config/connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'config/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile_number'];
    $job_profile = $_POST['job_profile'];
    $address = $_POST['address'];
    $cvPath = "";

    // Handle CV upload
    if (isset($_FILES['cv']) && $_FILES['cv']['size'] > 0) {
        $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
        $cvName = uniqid('cv_') . "." . $ext;
        $uploadDir = "uploads/cvs/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        move_uploaded_file($_FILES['cv']['tmp_name'], $uploadDir . $cvName);
        $cvPath = $uploadDir . $cvName;
    }

    // Insert data into the database
    $sql = "INSERT INTO Job_applications (Full_name, Email, Mobile_number, Job_profile, Address, CV, Time) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $full_name, $email, $mobile, $job_profile, $address, $cvPath);

    if ($stmt->execute()) {
        // Database insertion successful, now send the email

        $mail = new PHPMailer(true); // Passing true enables exceptions
        try {
            $mail->isSMTP();
            $mail->Host = 'company.in'; 
            $mail->SMTPAuth = true; 
            $mail->Username = 'noreply@company.in';
            $mail->Password = 'randompassword'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 
            $mail->setFrom('noreply@company.in', 'Company');
            $mail->addAddress($email);
            $mail->isHTML(true); 
            $mail->Subject = "Thank You for Your Application - " . htmlspecialchars($job_profile) . " at Our Company"; 
            
            $mail->Body = "
                <p>Dear " . htmlspecialchars($full_name) . ",</p>
                <p>Thank you for your application for the position of <strong>" . htmlspecialchars($job_profile) . "</strong> at Your Company. We have received your application and appreciate your interest in joining our team.</p>
                <p>Our recruitment team will review your application and contact you if your qualifications and experience match our requirements.</p>
                <p>In the meantime, you can learn more about us on our website: <a href='https://localhost/piyushbigproject'>www.company.in</a></p>
                <p>We wish you the best in your job search!</p>
                <p>Regards,</p>
                <p>Company Recruitment Team</p>
            ";
            $mail->AltBody = "Dear " . htmlspecialchars($full_name) . ",\n\nThank you for your application for the position of " . htmlspecialchars($job_profile) . " at Our Company. We have received your application and appreciate your interest in joining our team.\n\nOur recruitment team will review your application and contact you if your qualifications and experience match our requirements.\n\nIn the meantime, you can learn more about us on our website: https://localhost/piyushbigproject\n\nWe wish you the best in your job search!\n\nSincerely,\nCompany Recruitment Team"; 

            $mail->send();
            // Email sent successfully
            echo "<script>alert('Thank You for Applying, We'll Connect sooner. An email confirmation has been sent.'); window.location='careers.php';</script>";
        } catch (Exception $e) {
            // Error sending email
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "<script>alert('Thank You for Applying, but there was an issue sending the confirmation email. We\\'ll Connect sooner.'); window.location='careers.php';</script>";
        }
    } else {
        // Database insertion failed
        echo "<script>alert('Error: " . $conn->error . "'); window.location='careers.php';</script>";
    }
}

    $sql = "SELECT * FROM career_page WHERE id ='1'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $serviced = $result->fetch_assoc();

?>

  <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="<?php echo htmlspecialchars($serviced['meta_description']); ?>">
            <meta name="keywords" content="<?php echo htmlspecialchars($serviced['meta_keywords']); ?>">
            <title><?php echo htmlspecialchars($serviced['meta_title']); ?></title>
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
        .service-page-content h1{
            font-size:45px;
        }
        .service-page-content h2{
            font-size:40px;
        }
        .service-page-content h3{
            font-size:35px;
        }
        .service-page-content h4{
            font-size:30px;
        }
        .service-page-content h5{
            font-size:25px;
        }
        .service-page-content h6{
            font-size:20px;
        }
        
        .service-page-content img{
            width:100%;
            position:relative;
        }
        
        .service-page-content ul{
            list-style:normal;
            display:grid;
            padding-left:25px;
        }
        .service-page-content ul li{
            padding-top:10px;
            padding-bottom:10px;
            padding-left:20px;
        }
        .service-page-content ul li::before{
            content: '●'; 
  color: black;
  position: absolute;
  left:50px;
  padding-right:12px;
        }
        
        .breadcrumb-area.services .section-title p:before{
            display:none !important;
        }
        
        .breadcrumb-area.services .section-title p:before{
            display:none !important;
        }
    .process-section.process-two .single-process-item{
        justify-content:flex-start;
    }
    
    </style>
        </head>
        <body>
            <?php include("includes/navbar.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T6fN/SQ8UlZCb4gTgOSN8v+UvhU0xUThpKf96D6K5XeJ6aRaNKl/3xEyhWnYVD+E" crossorigin="anonymous">


    
        <!-- Breadcrumb Area  -->
 <div class="breadcrumb-area services section-padding light-bg-1 pb-0">
        <div class="container">
            <div class="row mt-20">
                <div class="col-12">
                    <div class="bread-bg">
                        <?php  $correctedPath = removeFirstThreeChars($serviced['page_banner']); ?>
                        <img src="<?php echo $correctedPath; ?>" alt="Privacy Policy Banner">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Page  -->

               <div class="service-page pb-60">
       <div class="container">
            <div class="col-xl-12">
                <div class="service-page-content">
                    <?php echo $serviced['page_content']; ?>
                </div>
            </div>
       </div> 
    </div>
    
    <div class="solution-section section-padding pb-0 pt-0">
    <div class="row">
        <div class="offset-xl-2 col-xl-8 text-center">
            <div class="section-title">
                <h2>Current Job Openings</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="accordion faqs" id="jobAccordion">
                <?php
                $jobs = $conn->query("SELECT * FROM job_openings ORDER BY created_at DESC");
                $jobIndex = 1;
                while ($job = $jobs->fetch_assoc()) {
                    $jobId = htmlspecialchars($job['id']);
                    $collapseId = "collapse" . $jobId;
                    $headingId = "heading" . $jobId;
                    $isFirst = $jobIndex === 1;
                ?>
                <div class="card">
                    <div class="card-header" id="<?= $headingId ?>">
                        <h5 class="mb-0 subtitle">
                            <button class="btn btn-link <?= $isFirst ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $isFirst ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                                <?= htmlspecialchars($job['job_title']) ?>
                            </button>
                        </h5>
                        <?php
                        $date = new DateTime($job['created_at']);
$formattedDate = $date->format('F j, Y \a\t g:i A');
                        ?>
                        <h6 style="font-family:sans-serif;">Posted By <strong>Admin</strong> on <?php echo htmlspecialchars($formattedDate); ?></h6>
                    </div>

                    <div id="<?= $collapseId ?>" class="collapse <?= $isFirst ? 'show' : '' ?>" aria-labelledby="<?= $headingId ?>" data-parent="#jobAccordion">
                        <div class="card-body">
                            <div class="content">
                                <strong>Who Can Apply:</strong>
                                <p><?= nl2br(htmlspecialchars($job['who_can_apply'])) ?></p>
                                <strong>About the Job:</strong>
                                <p><?= $job['about_job'] ?></p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal<?= $jobId ?>">Apply Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="applyModal<?= $jobId ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="" method="POST" enctype="multipart/form-data" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Apply for <?= htmlspecialchars($job['job_title']) ?></h5>
                                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="job_profile" value="<?= htmlspecialchars($job['job_title']) ?>">

                                <label style="padding-bottom: 5px;padding-top: 5px;">Full Name</label>
                                <input type="text" name="full_name" class="form-control" required>

                                <label style="padding-bottom: 5px;padding-top: 5px;">Email</label>
                                <input type="email" name="email" class="form-control" required>

                                <label style="padding-bottom: 5px;padding-top: 5px;">Mobile Number (WhatsApp)</label>
                                <input type="text" name="mobile_number" class="form-control" required>

                                <label style="padding-bottom: 5px;padding-top: 5px;">Address</label>
                                <textarea style="max-height:60px;" name="address" class="form-control" required></textarea>

                                <label style="padding-bottom: 5px;padding-top: 5px;">Upload CV</label>
                                <input type="file" name="cv" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php $jobIndex++; } ?>
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
                    <p class="text-white">Whether you need tax filing, legal consulting, or business registration services, we are here to help. Our expert team at Company offers tailored solutions for individuals and businesses across India. Take the first step toward hassle-free legal and tax services today</p>
                </div>
                
                <div class="explore-btn">
                   <a href="contact.php">Contact Us Now<i class="las la-arrow-right"></i></a>
                </div>
                
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-bmrfJm7H1oYfHd/YTOX3phmlV1U7CtEBJYmwZDAa9U5gqdcE/6L2uM6ctA1r3rHg" crossorigin="anonymous"></script>




<?php

include("includes/footer.php");

?>
<?php
    } else {
        // Service not found
        echo "Page not found!";
    }
?>