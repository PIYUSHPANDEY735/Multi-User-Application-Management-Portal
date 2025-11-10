<?php
include("includes/header.php");
include("includes/navbar.php");

$query = "SELECT * FROM mca_services ORDER BY id ASC LIMIT 5";
$result = $conn->query($query);

// / Fetch 6 random popular services (or you can customize this logic)
$popularQuery = "SELECT id,service_name, slug FROM mca_services ORDER BY RAND() LIMIT 6";
$popularResult = $conn->query($popularQuery);

?>

<style>
    .hero-section {
        background: url('assets/img/hero-backgroundd.webp') center center/cover no-repeat;
        color: white;
        text-align: center;
        padding: 80px 20px;
    }

    .search-box {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 14px 20px;
        font-size: 18px;
        border-radius: 8px;
        border: none;
        color: #fff !important;
    }

    .search-box input::placeholder {
        color: #fff !important;
    }

    .search-box .suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        color: black;
        border-radius: 0 0 8px 8px;
        z-index: 10;
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #ddd;
    }

    .suggestions div {
        padding: 10px;
        cursor: pointer;
    }

    .suggestions div:hover {
        background-color: #f0f0f0;
    }

    .popular-searches {
        margin-top: 30px;
    }

    .popular-searches .btn {
        margin: 6px;
        background-color: #00aabb;
        border: none;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
    }

    @media (max-width:767px) {
        .heading-font {
            font-size: 35px;
        }
    }

    .heading-font {
        font-size: 55px;
    }
</style>

<div class="hero-section">
    <h2 style="color:#fff" class="heading-font">One Stop Solutions<br> for all taxation and Legal Needs</h2>
    <div class="search-box mt-4">
        <input type="text" id="serviceSearch" placeholder="Explore our Range of Services..." style="border:3px solid #fff;">
        <div id="suggestions" class="suggestions" style="display: none;"></div>
    </div>

    <!--<div class="popular-searches">-->
    <!--    <h4 class="mt-4">Popular Searches</h4>-->
    <!--    <?php while ($row = $popularResult->fetch_assoc()) { ?>-->
    <!--        <a href="mca-service.php?slug=<?= urlencode($row['slug']) ?>&id=<?= $row['id'] ?>" class="btn"><?= htmlspecialchars($row['service_name']) ?></a>-->
    <!--    <?php } ?>-->
    <!--</div>-->

    <div class="popular-searches">
        <h4 class="mt-4 mb-2">Popular Searches</h4>
        <a href="mca-service.php?slug=accounting-and-job-works&id=40" class="btn" style="background-color:darkblue !important">Accounting Job Work</a>
        <a href="mca-service.php?slug=auditing-work&id=61" class="btn" style="background-color:darkblue !important">Auditing Work</a>
        <a href="mca-service.php?slug=income-tax-return-(itr)&id=35" class="btn" style="background-color:darkblue !important">Income Tax Return (ITR)</a>
        <a href="mca-service.php?slug=tds-return-filing&id=46" class="btn" style="background-color:darkblue !important">TDS Return</a>
        <a href="mca-service.php?slug=trademark-registration&id=33" class="btn" style="background-color:darkblue !important">Trademark Registration</a>

        <a href="mca-service.php?slug=msme%2Fudhyam-aadhar-registration&id=22" class="btn" style="background-color:darkblue !important">MSME/Udyam Aadhar Registration</a>


        <a href="mca-service.php?slug=private-limited-company&id=19" class="btn" style="background-color:darkblue !important">Company Registration</a>

        <a href="mca-service.php?slug=basic-partnership-firm&id=20" class="btn" style="background-color:darkblue !important">Firm Registration</a>

        <a href="mca-service.php?slug=startup-india-registration&id=25" class="btn" style="background-color:darkblue !important">Start Up Registration</a>

        <a href="mca-service.php?slug=gst-registration-and-filing&id=34" class="btn" style="background-color:darkblue !important">GST Registration</a>
        <a href="mca-service.php?slug=iso-registration&id=28" class="btn" style="background-color:darkblue !important">ISO Registration</a>
    </div>

</div>

<!-- Feature Section  -->

<div class="feature-section section-padding pb-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">
                <div class="section-title">
                    <h2>Over <a href="about.php">10 Years of Experience</a> in <br>Tax Advisory & Financial Consulting<br>
                    </h2>
                </div>
            </div>
        </div>
        <div class="row mt-60">
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="100ms">
                <div class="feature-item-wrap">
                    <div class="feature-icon">
                        <i class="flaticon-quality"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Quality Services</h4>
                        <p>Providing high-quality, affordable tax and legal services tailored to meet diverse client needs across India.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                <div class="feature-item-wrap">
                    <div class="feature-icon">
                        <i class="flaticon-group"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Professional Team</h4>
                        <p>Expert team of CAs, CSs, CMAs, MBAs, and Advocates delivering exceptional tax and legal services nationwide.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp animated" data-wow-delay="300ms">
                <div class="feature-item-wrap">
                    <div class="feature-icon">
                        <i class="flaticon-customer-service"></i>
                    </div>
                    <div class="feature-content">
                        <h4>24/7 Full Support</h4>
                        <p>Round-the-clock support available to assist with all your tax, legal, and financial service needs anytime.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Section -->

<div class="service-section white-bg section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
                <div class="single-service-wrap">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="single-service-inner">
                            <h5>
                                <a href="mca-service.php?slug=<?= urlencode($row['slug']) ?>&id=<?= $row['id'] ?>">
                                    <?= htmlspecialchars($row['service_name']) ?>
                                </a>
                            </h5>
                            <p><?= htmlspecialchars($row['page_heading']) ?></p>
                            <a href="mca-service.php?slug=<?= urlencode($row['slug']) ?>&id=<?= $row['id'] ?>" class="details-link">
                                <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                <div class="service-content-wrap">
                    <div class="section-title" style="margin-bottom:15px;">
                        <h6>WHAT WE PROVIDE</h6>
                        <h2>Comprehensive Solutions We Offer</h2>
                    </div>
                    <p style="margin-bottom:10px;margin-top:0px;">Our Company is your one-stop platform for all tax, registration, and legal compliance needs. We offer a wide range of services, including business registrations, such as Private Limited and Public Company incorporation, as well as licenses and certifications, including Trade Licenses and FSSAI Registration. Our expert team also assists with taxation, legal matters, and compliance requirements, ensuring that your business operates smoothly. With our affordable solutions and professional guidance, Our Company makes managing your tax and legal responsibilities effortless and hassle-free.</p>

                    <div class="service-bg">
                        <img src="assets/img/service/service-bg.png" alt="">
                        <a href="about.php" class="more-service-btn">Explore More About</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Counter Section -->
<div class="counter-area bg-cover">
    <div class="overlay-2"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter-box">
                    <p class="counter-number" style="text-align:center !important;"><span>15</span>k+</p>
                    <h6>Project Completed</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter-box">
                    <p class="counter-number" style="text-align:center !important;"><span>10</span>+</p>
                    <h6>Years Experience</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter-box">
                    <p class="counter-number" style="text-align:center !important;"><span>4273</span></p>
                    <h6>Happy Customers</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter-box">
                    <p class="counter-number" style="text-align:center !important;"><span>406</span></p>
                    <h6>Total Staff & Associates</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section  -->

<div class="about-section white-bg section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="100ms">
                <div class="about-bg-one" data-background="assets/img/about/about-1.jpg">
                    <!--<div class="about-tag-title">-->
                    <!--    <h4>We Have Than 25 Years of Experience</h4>-->
                    <!--</div>-->
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                <div class="about-content-wrap">
                    <div class="section-title">
                        <h6>About Company</h6>
                        <h2>Building Trust Through Quality Services</h2>
                    </div>
                    <p>Our Company is a dynamic organization dedicated to providing expert tax, legal, and financial services. With a team of highly skilled professionals, we strive to deliver reliable and cost-effective solutions to businesses and individuals across India. </p>
                    <div class="about-feature-list">
                        <ul>
                            <li><i class="las la-check-circle"></i> Trusted professionals</li>
                            <li><i class="las la-check-circle"></i>Wide range of services</li>
                            <li><i class="las la-check-circle"></i> Nationwide coverage</li>
                            <li><i class="las la-check-circle"></i> Client-focused approach</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-12 text-end wow fadeInUp animated" data-wow-delay="100ms">
                <div class="about-content-wrap pr-60">
                    <div class="section-title">
                        <h6>Who We Are</h6>
                        <h2>Providing Quality Tax
                            Services & Consulting</h2>
                    </div>
                    <p> Our team includes Chartered Accountants, Company Secretaries, Cost and Management Accountants, Advocates, and other experts who are committed to delivering excellence in all our services.</p>
                    <div class="circle_progress_area">
                        <div class="circle_progress_wrap">

                            <div class="circle_progress_single">
                                <div class="circle_progress_box">
                                    <div id="circle_progress"></div>
                                    <span>85%</span>
                                </div>
                                <div class="circle_progress_content">
                                    <h6>Financial Advising</h6>
                                </div>
                            </div>
                            <div class="circle_progress_single">
                                <div class="circle_progress_box">
                                    <div id="circle_progress_two"></div>
                                    <span>95%</span>
                                </div>
                                <div class="circle_progress_content">
                                    <h6>Business Consulting</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInRight animated" data-wow-delay="200ms">
                <div class="about-bg-two" data-background="assets/img/about/about-2.jpg">
                    <!--<div class="about-tag-title">-->
                    <!--    <h4>99.9% Customer Satisfaction</h4>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="faq-section section-padding dark-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-12 wow fadeInUp animated" data-wow-delay="200ms">
                <div class="section-title">
                    <h6>Helpful Faq</h6>
                    <h2 class="text-white">We Always Answer Your
                        Doubts
                    </h2>
                </div>
                <div class="accordion faqs" id="accordionFaq">
                    <div class="card">
                        <div class="card-header" id="heading1">
                            <h5 class="mb-0 subtitle">
                                <button class="btn btn-link collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    What services does our company offers ?

                                </button>
                            </h5>
                        </div>

                        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionFaq">
                            <div class="card-body">
                                <div class="content">
                                    <p>Our Company offers services like GST Registration, Income Tax Returns, Company Incorporation, FSSAI Registration, MSME Registration, and other legal matters.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading2">
                            <h5 class="mb-0 subtitle">
                                <button class="btn btn-link collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    How can I register my business with your company ?
                                </button>
                            </h5>
                        </div>

                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionFaq">
                            <div class="card-body">
                                <div class="content">
                                    <p>Simply sign up, choose your business type (Private Limited, LLP, etc.), and upload the required documents through our platform.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading3">
                            <h5 class="mb-0 subtitle">
                                <button class="btn btn-link collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    How does your company ensure the security of my documents ?
                                </button>
                            </h5>
                        </div>

                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionFaq">
                            <div class="card-body">
                                <div class="content">
                                    <p>We use encrypted systems and secure servers to keep all your documents safe and confidential.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading4">
                            <h5 class="mb-0 subtitle">
                                <button class="btn btn-link collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse2">
                                    What are the fees for your company services ?
                                </button>
                            </h5>
                        </div>

                        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionFaq">
                            <div class="card-body">
                                <div class="content">
                                    <p>Our fees vary depending on the service, but we offer competitive and transparent pricing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
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

<div class="clients-area pt-60">
    <div class="client-logo-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo1.png" alt="Clients logo" style="width:300px;">
                </div>
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo2.png" alt="Clients logo" style="width:300px;">
                </div>
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo3.png" alt="Clients logo" style="width:300px;">
                </div>
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo4.png" alt="Clients logo" style="width:300px;">
                </div>
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo5.png" alt="Clients logo" style="width:300px;">
                </div>
                <div class="col-md-4" style="margin-top:15px;margin-bottom:15px;">
                    <img src="assets/img/client/logo6.png" alt="Clients logo" style="width:300px;">
                </div>
            </div>
        </div>

    </div>
</div>

<div class="testimonial-section section-padding pt-40">
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
                                <p>I had a great experience with Tax Bucket. The group offered “the best service” with a good-natured and approachable team. Their **friendly reminders** were helpful, and they maintained a high level of -professionalism- throughout. Highly recommend!
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
                                <p>Tax Bucket and team is excellent and work very closely with their clients. They provide full support and possess good knowledge with huge experience. I am availing their services for IT return filing from past many years and I am highly satisfied.</p>
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

            <!--<div class="pop-up-video">-->
            <!--    <a href="https://www.youtube.com/watch?v=vNiRZWVNK7M" class="video-play-btn mfp-iframe">-->
            <!--        <i class="las la-play"></i> <span></span>-->
            <!--    </a>-->
            <!--</div>-->

            <div class="explore-btn">
                <a href="contact.php">Contact Us Now<i class="las la-arrow-right"></i></a>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#serviceSearch').on('input', function() {
        let query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: 'search-services.php',
                method: 'GET',
                data: {
                    q: query
                },
                success: function(data) {
                    const results = JSON.parse(data);
                    let html = '';
                    if (results.length > 0) {
                        results.forEach(function(service) {
                            html += `<div onclick="location.href='mca-service.php?slug=${service.slug}&id=${service.id}'">${service.service_name}</div>`;
                        });
                    } else {
                        html = '<div>No services found.</div>';
                    }
                    $('#suggestions').html(html).show();
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });
</script>

<?php

include("includes/footer.php");

?>