<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config/connection.php");

// Check if `slug` and `id` are provided in the URL
if (isset($_GET['slug']) && isset($_GET['id'])) {
    $slug = $conn->real_escape_string($_GET['slug']);
    $blog_id = intval($_GET['id']); // Ensure `id` is an integer

    // Fetch the service details
    $sql = "SELECT * FROM blogs WHERE blog_slug = '$slug' AND id = $blog_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $servicedata = $result->fetch_assoc();

?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="<?php echo htmlspecialchars($servicedata['meta_description']); ?>">
            <meta name="keywords" content="<?php echo htmlspecialchars($servicedata['meta_keywords']); ?>">
            <title><?php echo htmlspecialchars($servicedata['meta_title']); ?></title>
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
        
        
        
        .breadcrumb-area.services .section-title p:before{
            display:none !important;
        }
        .service-page-content h3 {
    font-size: 25px;
    padding-top: 5px;
    padding-bottom: 5px; }
    
    .service-page ul li{
        padding-top: 6px;
    padding-bottom: 6px;
    }
    </style>
        </head>
        <body>
            <?php include("includes/navbar.php"); ?>

                <div class="breadcrumb-area services section-padding light-bg-1 pb-0" style="padding-top:40px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-sm-12 text-center">
                    <div class="section-title">
                        <h2><?php echo htmlspecialchars($servicedata['blog_name']); ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row mt-90">
                <div class="col-12">
                    <div class="bread-bg">
                        <?php  $correctedPath = removeFirstThreeChars($servicedata['blog_image']); ?>
                        <img src="<?php echo $correctedPath; ?>" alt="Blog Banner">
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
                    <?php echo $servicedata['blog_content']; ?>
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
                    <p class="text-white">Whether you need tax filing, legal consulting, or business registration services, we are here to help. Our expert team at our Company offers tailored solutions for individuals and businesses across India. Take the first step toward hassle-free legal and tax services today</p>
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
        echo "Blog not found!";
    }
} else {
    // Missing required parameters

// You have made no changes to save.
    echo "Invalid request!";
}
?>
