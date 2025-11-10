<?php

include("./config/connection.php");
$query = "SELECT * FROM `admin` WHERE id='1'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result

$servicesquery = "SELECT * FROM mca_services ORDER BY id DESC LIMIT 10";
$servicesresult = $conn->query($servicesquery);


// Check if any record is found
if ($result->num_rows == 1) {
    // Fetch the registration details
    $data = $result->fetch_assoc();
?>
    <!-- Footer Area  -->

    <div class="footer-area" style="padding-top:35px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-5 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                    <div class="footer-widget">
                        <div class="logo">
                            <a class="navbar-brand" href="index.php"><img src="https://localhost/piyushproject/img/sitelogo.png" alt="Site Logo" style="width:130px;"></a>
                        </div>
                        <p class="company-desc">We are managing the team of professionals like CA, CS, CMA, MBA, Advocate & other professionals of tax and other legal expert where they have poses years of experience in their respective fields.</p>
                    </div>
                </div>
                <div class="offset-xl-1 col-xl-5 col-lg-5 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                    <div class="footer-widget">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="services-list">
                                    <h5>Quick Links</h5>
                                    <ul>
                                        <li><i class="las la-check-circle"></i><a href="index.php">Home</a></li>
                                        <li><i class="las la-check-circle"></i><a href="about.php">About Us</a></li>
                                        <li><i class="las la-check-circle"></i><a href="careers.php">Careers</a></li>
                                        <li><i class="las la-check-circle"></i><a href="our-offers.php">Our Offers</a></li>
                                        <li><i class="las la-check-circle"></i><a href="track-status.php">Track Status</a></li>
                                        <li><i class="las la-check-circle"></i><a href="terms-and-conditions.php">Terms & Conditions</a></li>
                                        <li><i class="las la-check-circle"></i><a href="privacy-policy.php">Privacy Policy</a></li>
                                        <li><i class="las la-check-circle"></i><a href="refund-policy.php">Refund Policy</a></li>
                                        <li><i class="las la-check-circle"></i><a href="cancellation-policy.php">Cancellation Policy</a></li>
                                        <li><i class="las la-check-circle"></i><a href="coupon-partner.php">Our Coupon Partner</a></li>
                                        <li><i class="las la-check-circle"></i><a href="frequently-asked-questions.php">Frequently Asked Questions</a></li>
                                        <li><i class="las la-check-circle"></i><a href="contact.php">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="services-list">
                                    <h5>Our Services</h5>
                                    <ul>

                                        <?php while ($row = $servicesresult->fetch_assoc()) { ?>

                                            <li><i class="las la-check-circle"></i><a href="mca-service.php?slug=<?= urlencode($row['slug']) ?>&id=<?= $row['id'] ?>"><?= htmlspecialchars($row['service_name']) ?></a></li>

                                        <?php } ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-12 wow fadeInUp animated" data-wow-delay="600ms">
                    <div class="footer-widget">
                        <div class="footer-contact-info">
                            <h5>Contact Us</h5>
                            <p class="address">Address -: <?php echo $data['Address'] ?></p>
                            <?php if (!empty($data['Address_second'])): ?>
                                <p class="address">Second Address -: <?php echo $data['Address_second']; ?></p>
                            <?php endif; ?>
                            <p class="number">Phone Number -: <?php echo $data['Phone_all'] ?></p>
                            <p class="email" style="text-align:left;">Email -: <?php echo $data['All_Emails'] ?></p>
                            <?php $correctedPathe = removeFirstChar($data['QR_Code']); ?>
                            <p>Pay Here -: <span><img src="<?php echo $correctedPathe ?>" style="width:200px;height:200px;position:relative;" alt="QR Code"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Bottom Area  -->

    <div class="footer-bottom" style="height:auto;background-color:darkblue !important;padding-top:5px;padding-bottom:5px;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12" style="text-align:center;">
                    <p style="font-family:math;font-size:19px;color:#fff;"> | Created By <strong><a href="https://piyush4.netlify" target="_blank" style="color:#fff;font-size:19px;">Piyush Pandey </a></strong></p>
                </div>
            </div>
        </div>
        <br>

    </div>

    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <div id='basic-modal' style="height:0;"> <a href='https://api.whatsapp.com/send?phone=+91<?php echo $data['Phone'] ?>&text=Want to Know More About Your Services!' class='basic'><img src="img/wp.gif" style="position:fixed; z-index:999; bottom:61px; left:0px;width:51px;" alt=""></a> </div>

    <!-- Popper JS -->
    <script src="./assets/js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Wow JS -->
    <script src="./assets/js/wow.min.js"></script>
    <!-- Way Points JS -->
    <script src="./assets/js/jquery.waypoints.min.js"></script>
    <!-- Counter Up JS -->
    <script src="./assets/js/jquery.counterup.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <!-- Slick Slider JS -->
    <script src="./assets/js/slick.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="./assets/js/magnific-popup.min.js"></script>
    <!-- Isotope JS -->
    <script src="./assets/js/isotope-3.0.6-min.js"></script>
    <!-- Sticky JS -->
    <script src="./assets/js/jquery.sticky.js"></script>
    <!-- Nice Select JS -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <!-- Back To Top JS -->
    <script src="./assets/js/backToTop.js"></script>
    <!-- Progress Bar JS -->
    <script src="./assets/js/jquery.barfiller.js"></script>
    <!-- Circle Progress Bar JS -->
    <script src="./assets/js/circle-progress.min.js"></script>
    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>
    </body>

    </html>
<?php
} else {
    echo "No Admin details.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>