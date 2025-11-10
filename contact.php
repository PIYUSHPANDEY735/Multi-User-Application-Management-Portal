<?php
include("includes/header.php");
include("includes/navbar.php");

include("./config/connection.php");
$query = "SELECT * FROM `admin` WHERE id='1'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Execute and get the result


// Check if any record is found
if ($result->num_rows == 1) {
    // Fetch the registration details
    $data = $result->fetch_assoc();
?>

    <!-- Contact Page  -->
    <div class="contact-page section-padding light-bg-1">
        <div class="container">
            <div class="contact-page-inner white-bg">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="contact-form-wrapper">
                            <h3>Send A Message</h3>
                            <form action="config/send-enquiry.php" method="POST">
                                <input type="text" name="name" placeholder="Name" required>
                                <input type="tel" name="phone" placeholder="Phone" required>
                                <input type="email" name="email" placeholder="E-mail" required>
                                <input type="text" name="services" placeholder="Service" required>
                                <textarea name="msg" id="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
                                <input type="submit" value="Send A Message" name="contact_form">
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="contact-details-wrapper">
                            <div class="section-title">
                                <p>QUICK CONTACT</p>
                                <h2>Have Questions?
                                    Get in Touch!</h2>
                            </div>
                            <p>Reach out to us for expert tax and legal services, tailored to meet your specific needs across India.</p>
                            <div class="contact-details">
                                <div class="single-contact-info">
                                    <div class="contact-icon">
                                        <i class="las la-phone-volume"></i>
                                    </div>
                                    <div class="contact-info">
                                        <p>Have any question?</p>
                                        <h5>Call : <?php echo $data['Phone_all'] ?></h5>
                                    </div>
                                </div>
                                <div class="single-contact-info">
                                    <div class="contact-icon">
                                        <i class="las la-envelope-open"></i>
                                    </div>
                                    <div class="contact-info">
                                        <p>Write email</p>
                                        <h5><?php echo $data['All_Emails'] ?></h5>
                                    </div>
                                </div>
                                <div class="single-contact-info">
                                    <div class="contact-icon">
                                        <i class="las la-building"></i>
                                    </div>
                                    <div class="contact-info">
                                        <p>Address</p>
                                        <h5><?php echo $data['Address'] ?></h5>
                                    </div>
                                </div>
                                <?php if (!empty($data['Address_second'])): ?>
                                    <div class="single-contact-info">
                                        <div class="contact-icon">
                                            <i class="las la-building"></i>
                                        </div>
                                        <div class="contact-info">
                                            <p>Second Address</p>
                                            <h5><?php echo $data['Address_second'] ?></h5>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="single-contact-info">
                                    <div class="contact-icon">
                                        <i class="las la-user-alt"></i>
                                    </div>
                                    <div class="contact-info">
                                        <p>Solve Your Query</p>
                                        <h5><?php echo $data['Display_Name'] ?> <?php echo $data['Designation'] ?> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Map Start-->
    <div class="contact-page google-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24167.437169739474!2d-74.006015!3d40.712728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316a0d1d75%3A0x6fdeb5a4f9d5e3f8!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sus!4v1730810479182!5m2!1sen!2sus"
            width="600"
            height="600"
            style="border: 1px #ccc solid;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

    </div>

<?php
} else {
    echo "No Admin details.";
}

// Close the statement and connection
$stmt->close();
$conn->close();

include("includes/footer.php");
?>