<?php

include("includes/header.php");
include("includes/navbar.php");

$query = "SELECT * FROM mca_services ORDER BY id ASC LIMIT 10";
$result = $conn->query($query);

?>

<style>
    .edited-heading {
        text-align: left !important;
    }

    .edited-heading .new-context {
        width: 100%;
        height: auto;
        padding-bottom: 10px;
    }

    .edited-heading .new-context p {
        font-weight: normal;
        text-align: left !important;
        padding-left: 0px !important;
        text-transform: none;
        font-weight: normal;
        font-size: 18px !important;
        font-style: normal !important;
    }

    .edited-heading .new-context ul {
        display: grid;
    }

    .edited-heading .new-context ul li {
        font-size: 18px !important;
        padding-top: 4px;
        padding-bottom: 4px;
    }

    .edited-heading h3 {
        text-align: left !important;
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #3b6afc;
    }
</style>
<!-- Breadcrumb Area  -->

<div class="breadcrumb-area section-padding light-bg-1 pb-0" style="padding-top:40px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-bg">
                    <img src="assets/img/breadcrumb/about-banner.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-30">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="section-title edited-heading">
                    <div class="new-context">
                        <h4>ABOUT US</h4>
                        <h3>WHO WE ARE</h3>
                        <p>Company is a registered trademark of Company India Private Limited who is a leading provider of Tax, Legal and Financial Services in India. Their expertise lies in
                            providing comprehensive tax, financial and compliance services to individuals, business and
                            organisations across India</p>
                    </div>

                    <div class="new-context">
                        <h4>OUR MANTRA</h4>
                        <h3>MISSION</h3>
                        <p>Our Company aims to provide expert tax and legal guidance, ensuing compliance and optimizing financial
                            outcomes for our clients.
                        </p>
                    </div>
                    <div class="new-context">
                        <h4>OUR ASPIRATION</h4>
                        <h3> VISION</h3>
                        <p>To be a leader in the field of taxation and legal services, recognized for our expertise, innovation, and
                            commitment to exceptional client service.
                        </p>
                    </div>
                    <div class="new-context">
                        <h4>OUR ETHICS</h4>
                        <h3>VALUES</h3>
                        <p>To be a leader in the field of taxation and legal services, recognized for our expertise, innovation, and
                            commitment to exceptional client service
                        </p>
                        <ul>
                            <li> 1. Expertise : Our team consists of experience tax and legal professional.</li>
                            <li>2. Personalized Service : We provide tailored solutions to meet each client’s unique needs.</li>
                            <li>3. Integrity : We maintain the highest standards of ethics and integrity.</li>
                            <li>4. Innovation : We stay updated with the latest tax and legal developments to provide innovative
                                solutions.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feature Section  -->

<div class="feature-section section-padding pb-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">
                <div class="section-title">
                    <h2>Over <a href="javascript:;">10 Years of Experience</a> in <br>Tax Advisory & Financial Consulting<br>
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
            <div class="col-xl-12 text-center">
                <div class="section-title">
                    <h2>Our Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-xl-6 col-lg-6 col-12 wow fadeInLeft animated" data-wow-delay="200ms">
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
                </div>
            <?php } ?>
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
                                    What services does our company offer ?

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
                                    How can I register my business with our company ?
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
                                    How does our company ensure the security of my documents ?
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
                                    What are the fees for our companies services ?
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

<!-- Testimonial Section  -->

<div class="testimonial-section section-padding">
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

            <div class="explore-btn">
                <a href="contact.php">Contact Us Now<i class="las la-arrow-right"></i></a>
            </div>

        </div>
    </div>
</div>


<?php

include("includes/footer.php");

?>