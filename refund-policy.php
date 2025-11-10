<?php
include("config/connection.php");
    $sql = "SELECT * FROM other_pages WHERE id ='4'";
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
            <meta name="keywords" content="<?php echo htmlspecialchars($serviced['meta_Keywords']); ?>">
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
            content: '●';        /* Unicode black circle */
  color: black;        /* Ensures it's black */
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
        <!-- Breadcrumb Area  -->
 <div class="breadcrumb-area services section-padding light-bg-1 pb-0 pt-20">
        <div class="container">
            <div class="row mt-20">
                <div class="col-12">
                    <div class="bread-bg">
                        <?php  $correctedPath = removeFirstThreeChars($serviced['page_banner']); ?>
                        <img src="<?php echo $correctedPath; ?>" alt="Terms & Conditions Banner">
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
                    <p class="text-white">Whether you need tax filing, legal consulting, or business registration services, we are here to help. Our expert team offers tailored solutions for individuals and businesses across India. Take the first step toward hassle-free legal and tax services today</p>
                </div>
                
                <div class="explore-btn">
                   <a href="contact.php">Contact Us Now<i class="las la-arrow-right"></i></a>
                </div>
                
            </div>
        </div>
    </div>




<?php

include("includes/footer.php");

?>
<?php
    } else {
        // Service not found
        echo "Service not found!";
    }
?>