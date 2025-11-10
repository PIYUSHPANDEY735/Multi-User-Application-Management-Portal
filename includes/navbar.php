<?php

$query = "SELECT * FROM `admin` WHERE id='1'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


// Check if any record is found

if ($result->num_rows == 1) {
    // Fetch the registration details
    $data = $result->fetch_assoc();

    // Fetch all MCA services
    $sql = "SELECT page_title, slug, id FROM mca_services";
    $mcaresult = $conn->query($sql);

    // Fetch all banking services
    // $sqlbanking = "SELECT page_title, slug, id FROM banking_services"; Unneccessary query
    // $bankresult = $conn->query($sqlbanking);

    // Fetch all other services
    // $sqlother = "SELECT page_title, slug, id FROM other_services";  Unneccessary query
    // $otherresult = $conn->query($sqlother);

    // Fetch all knowledge bank
    $sqlknow = "SELECT page_title, slug, id FROM knowledge_bank";
    $knowresult = $conn->query($sqlknow);

    // Fetch all categories created by the admin
    $sqlCategories = "SELECT id, category_name, slug FROM categories";
    $categoryResult = $conn->query($sqlCategories);


    function removeFirstThreeChars($path)
    {
        // Check if the string length is greater than or equal to 3
        if (strlen($path) > 3) {
            // Return the string without the first three characters
            return substr($path, 3);
        }
        // If the string length is less than 3, return the string as is
        return $path;
    }

    function removeFirstChar($path)
    {
        // Check if the string length is at least 1
        if (strlen($path) > 0) {
            // Return the string without the first character
            return substr($path, 1);
        }
        // If the string is empty, return it as is
        return $path;
    }

?>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6808c8a8cda33a190ed81df6/1iph4vl65';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <style>
        .header-right .language-dropdown .nice-select {
            background: transparent;
            color: #000000;
            font-size: 16px;
            padding-right: 70px;

        }

        .header-right .language-dropdown .nice-select:before {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 100%;
            margin-top: 6px;
            pointer-events: none;
            position: absolute;
            left: -21px;
            top: 0%;
            -ms-transform-origin: 66% 66%;
            -ms-transform: rotate(45deg);
            transition: all 0.15s ease-in-out;
            background-image: url(../admindashboard/images/user-icon.png);
            background-position: center;
            background-size: cover;
        }

        .header-right .nice-select:after {
            border-bottom: 2px solid #000000 !important;
            border-right: 2px solid #000000 !important;
        }
    </style>

    <body>

        <!-- Header Top Area -->

        <div class="header-top-area" style="background:darkblue;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="header-info" style="margin-bottom:5px;">
                            <a href="tel:<?php echo $data['Phone']; ?>" style="border: 1px solid;background:#3b6afc;padding-right: 10px;overflow: hidden;color: #fff;"><img src="assets/img/callicon.jpg" style="width: 35px;height: 35px;position: relative;overflow: hidden;">&nbsp; Call Us : <?php echo $data['Phone']; ?></a>
                            <span>&nbsp;</span>
                            <a href="./contact.php" style="border: 1px solid;background:#3b6afc;padding-right: 10px;overflow: hidden;color: #fff;"><img src="assets/img/mailicon.jpg" style="width: 35px;height: 35px;position: relative;overflow: hidden;"> Send Your Enquiry</a>
                            <span>&nbsp;</span>
                            <a href="./become-an-associate.php" style="border: 1px solid;background:#3b6afc;padding-right: 10px;overflow: hidden;color: #fff;"><img src="assets/img/personicon.jpg" style="width: 35px;height: 35px;position: relative;overflow: hidden;"> Become An Associate</a>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-end">
                        <div class="social-icon">
                            <a href="javascript:;"><img src="assets/img/google-icon.jpg" style="width:75px;"></a>
                            <a href="javascript:;"><img src="assets/img/isoicon.jpg" style="width:75px;"></a>
                            <a href="javascript:;"><img src="assets/img/starupicon.jpg" style="width:75px;"></a>
                            <a href="<?php echo $data['Facebook']; ?>" target="_blank"><i class="lab la-facebook-f" style="color:#316FF6;background-color:#fff;"></i></a>
                            <a href="<?php echo $data['Linkedin']; ?>" target="_blank"><i class="lab la-linkedin" style="color:#0077B5;background-color:#fff;"></i></a>
                            <a href="<?php echo $data['Instagram']; ?>" target="_blank"><i class="lab la-instagram" style="color:#FCAF45;background-color:#fff;"></i></a>
                            <a href="<?php echo $data['Youtube']; ?>" target="_blank"><i class="lab la-youtube" style="color:#FF0000;background-color:#fff;"></i></a>
                            <a href="<?php echo $data['Twitter']; ?>" style="background-color: #fff;border-radius: 100%;" target="_blank"><img src="/assets/img/twitter-icon.png" style="width:42px;padding:12px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Area -->

        <div class="header-area">
            <div class="sticky-area" style="padding-top:15px;">
                <div class="navigation">
                    <div class="container">
                        <div class="header-inner-box">
                            <div class="logo">
                                <a class="navbar-brand" href="index.php"><img src="./img/sitelogo.png" alt="Site Logo" style="width:130px;"></a>
                            </div>

                            <div class="main-menu">
                                <nav class="navbar navbar-expand-lg">
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                        <span class="navbar-toggler-icon"></span>
                                        <span class="navbar-toggler-icon"></span>
                                    </button>

                                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                                        <ul class="navbar-nav m-auto">
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php">Home
                                                </a>
                                            </li>
                                            <?php
                                            if ($categoryResult->num_rows > 0) {
                                                while ($category = $categoryResult->fetch_assoc()) {
                                                    $categoryId = $category['id'];
                                                    $categoryName = $category['category_name'];

                                                    echo '<li class="nav-item">';
                                                    echo '<a class="nav-link" href="javascript:;">' . htmlspecialchars($categoryName) . '<span class="sub-nav-toggler"> </span></a>';
                                                    echo '<ul class="sub-menu">';

                                                    // Fetch subcategories under this category
                                                    $sqlSubcategories = "SELECT id, subcategory_name FROM subcategories WHERE category_id = $categoryId";
                                                    $subcatResult = $conn->query($sqlSubcategories);

                                                    if ($subcatResult->num_rows > 0) {
                                                        while ($subcat = $subcatResult->fetch_assoc()) {
                                                            $subcatId = $subcat['id'];
                                                            $subcatName = $subcat['subcategory_name'];

                                                            echo '<li class="category"><a href="javascript:;">' . htmlspecialchars($subcatName) . '</a>';
                                                            echo '<ul class="sub-menu subcategory">';

                                                            // Fetch services linked to this subcategory
                                                            $sqlSubcatServices = "SELECT service_name, slug, id FROM mca_services WHERE category_id = $categoryId AND subcategory_id = $subcatId";
                                                            $servicesResult = $conn->query($sqlSubcatServices);

                                                            while ($service = $servicesResult->fetch_assoc()) {
                                                                $serviceName = $service['service_name'];
                                                                $slug = $service['slug'];
                                                                $id = $service['id'];
                                                                echo '<li><a href="mca-service.php?slug=' . urlencode($slug) . '&id=' . $id . '">' . htmlspecialchars($serviceName) . '</a></li>';
                                                            }

                                                            echo '</ul></li>';
                                                        }
                                                    }

                                                    // Fetch services directly under category (not in any subcategory)
                                                    $sqlDirectServices = "SELECT service_name, slug, id FROM mca_services WHERE category_id = $categoryId AND (subcategory_id IS NULL OR subcategory_id = 0)";
                                                    $directServicesResult = $conn->query($sqlDirectServices);

                                                    while ($service = $directServicesResult->fetch_assoc()) {
                                                        $serviceName = $service['service_name'];
                                                        $slug = $service['slug'];
                                                        $id = $service['id'];
                                                        echo '<li><a href="mca-service.php?slug=' . urlencode($slug) . '&id=' . $id . '">' . htmlspecialchars($serviceName) . '</a></li>';
                                                    }

                                                    echo '</ul>';
                                                    echo '</li>';
                                                }
                                            }
                                            ?>

                                            <li class="nav-item">
                                                <a class="nav-link" href="blog.php">Blogs
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="knowledge-bank.php">Knowledge Bank
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>

                            <div class="header-right">

                                <?php if (isset($_SESSION['Status']) && $_SESSION['Status'] === 'User'): ?>]
                                <div class="language-dropdown" style="display:block !important;color:#000 !important;">
                                    <select name="language" style="display:block;color:#000;" onchange="location = this.value;">
                                        <option class="current" disabled selected><?php echo $_SESSION['name'] ?></option>
                                        <option value="./dashboard/index.php">Dashboard</option>
                                        <option value="./dashboard/user_profile.php">Profile</option>
                                        <option value="./dashboard/user_logout.php">Logout</option>
                                    </select>
                                </div>

                            <?php elseif (isset($_SESSION['status']) && $_SESSION['status'] === 'Admin'): ?>
                                <div class="language-dropdown" style="display:block !important;color:#000 !important;">
                                    <select name="language" style="display:block;color:#000;" onchange="location = this.value;">
                                        <option class="current" disabled selected><?php echo $_SESSION['name'] ?></option>
                                        <option value="./subadmin/index.php">Dashboard</option>
                                        <option value="./subadmin/subadmin_profile.php">Profile</option>
                                        <option value="./subadmin/subadmin_logout.php">Logout</option>
                                    </select>
                                </div>

                            <?php elseif (isset($_SESSION['Status']) && $_SESSION['Status'] === 'Super Admin'): ?>
                                <div class="language-dropdown" style="display:block !important;color:#000 !important;">
                                    <select name="language" style="display:block;color:#000;" onchange="location = this.value;">
                                        <option class="current" disabled selected><?php echo $_SESSION['name'] ?></option>
                                        <option value="./admindashboard/index.php">Dashboard</option>
                                        <option value="./admindashboard/admin_profile.php">Profile</option>
                                        <option value="./admindashboard/admin_logout.php">Logout</option>
                                    </select>
                                </div>

                            <?php else: ?>
                                <a href="./config/login.php">Log In <i class="fal fa-long-arrow-right"></i></a>
                            <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_right_bg">
                <img src="assets/img/top_right_bg.png" alt="">
            </div>
        </div>
    <?php
} else {
    echo "No Admin details found.";
}

// Close the statement and connection
// $stmt->close();
// $conn->close();
    ?>