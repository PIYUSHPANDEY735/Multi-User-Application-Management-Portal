<?php

include("includes/header.php");
include("includes/navbar.php");

$limit = 6; // blogs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$sql = "SELECT * FROM blogs ORDER BY blog_posted_date DESC";
$result = $conn->query($sql);

// Count total blogs for pagination
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM blogs");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

?>

<!-- Breadcrumb Area  -->

<div class="breadcrumb-area services section-padding light-bg-1" style="padding-top:40px;padding-bottom:40px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 col-md-8 col-12 text-center">
                <div class="section-title">
                    <!--<p>Blog & News</p>-->
                    <h2>Business & Tax Insights <br>
                        by Our Company</h2>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Blog Page  -->
<div class="blog-page pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="blog-slider-item">
                    <img src="assets/img/blog/blog-page-banner.webp" alt="">
                </div>
            </div>
        </div>
        <div class="row mt-60">
            <?php while ($row = $result->fetch_assoc()) { ?>

                <div class="col-md-6 col-12 text-center wow fadeInLeft animated" data-wow-delay="200ms">
                    <div class="single-blog-item">
                        <div class="blog-meta">
                            <span><?php echo htmlspecialchars($row['blog_written_by']); ?></span> . <span><?php echo date('d M Y', strtotime($row['blog_posted_date'])); ?></span>
                        </div>
                        <h3> <a href="blogs.php?slug=<?php echo urlencode($row['blog_slug']); ?>&id=<?php echo $row['id'] ?>"> <?php echo htmlspecialchars($row['blog_name']); ?> </a> </h3>
                        <p><?php echo htmlspecialchars($row['short_description']); ?></p>
                        <div class="blog-thumb"> <img src="<?php echo htmlspecialchars($row['blog_image']); ?>" alt=""> </div>
                    </div>
                </div>
            <?php } ?>


            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="las la-angle-left"></i></a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="las la-angle-right"></i></a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>


<!--<div class="col-md-6 col-12 text-center wow fadeInLeft animated" data-wow-delay="200ms">-->
<!--                    <div class="single-blog-item">-->
<!--                        <div class="blog-meta">-->
<!--                            <span>Taxation</span> . <span>25 March 2023</span>-->
<!--                        </div>-->
<!--                        <h3><a href="blog-details.html">If The White Whale Be Raised It -->
<!--                            Must Be In A Month</a></h3>-->
<!--                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat </p>-->
<!--                        <div class="blog-thumb">-->
<!--                            <img src="assets/img/blog/1.jpg" alt="">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->




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