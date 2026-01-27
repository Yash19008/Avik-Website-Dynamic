<?php
include './admin/inc/db.php';

$successMsg = '';
$errorMsg   = '';

if (isset($_POST['submit-form'])) {
    $name    = trim($_POST['username']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($phone) || empty($subject)) {
        $errorMsg = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Please enter a valid email address.";
    } elseif (empty($_POST['g-recaptcha-response'])) {
        $errorMsg = "Captcha verification failed. Please try again.";
    } else {

        $recaptchaSecret = "6Lc2_1csAAAAADRdpXzYDnYCuRhkpuRutE2qpMk6";
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $verifyResponse = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}"
        );

        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $errorMsg = "Captcha verification failed. Please refresh and try again.";
        } else {

            $stmt = $conn->prepare(
                "INSERT INTO contacts (name, email, phone, subject, message) 
                 VALUES (?, ?, ?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param(
                    "sssss",
                    $name,
                    $email,
                    $phone,
                    $subject,
                    $message
                );

                if ($stmt->execute()) {
                    $successMsg = "Thank you! Your message has been sent successfully.";
                } else {
                    $errorMsg = "Something went wrong. Please try again later.";
                }

                $stmt->close();
            } else {
                $errorMsg = "Database error. Please contact administrator.";
            }
        }
    }
}

/* ================= SEO META ================= */
$title = "Contact Us | Worldwide Events and Conference";
$meta_desc = "Get in touch with Worldwide Events and Conference for event planning, weddings, corporate events, and conferences. Call, email, or send us a message today.";

include 'inc/header2.php';
?>

<link href="<?= $baseUrl ?>/assets/css/module-css/contact.css" rel="stylesheet">

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/page-title-7.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ul class="bread-crumb clearfix mb_20">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li>Contact</li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1>Contact Worldwide Events and Conference</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- contact-section -->
<section class="contact-section pt_140 pb_140"
    itemscope
    itemtype="https://schema.org/ContactPage">

    <div class="pattern-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-49.png);"></div>

    <div class="auto-container">
        <div class="row clearfix">

            <!-- CONTACT FORM -->
            <div class="col-lg-9 col-md-12 col-sm-12 form-column">
                <div class="form-inner">
                    <?php if (!empty($successMsg)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($successMsg) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errorMsg)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errorMsg) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post"
                        action=""
                        id="contact-form"
                        class="default-form"
                        aria-label="Contact form">

                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="username" placeholder="Your Name*" required aria-required="true">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="email" name="email" placeholder="Your Email*" required aria-required="true">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="phone" placeholder="Phone Number*" required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="subject" placeholder="Subject*" required>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <textarea name="message" placeholder="How can we help you?"></textarea>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <div class="g-recaptcha"
                                    data-sitekey="6Lc2_1csAAAAAEoEW4v9akou7eL74LN1Z5faYmxi"></div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button class="theme-btn btn-one" type="submit" name="submit-form">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <!-- CONTACT INFO -->
            <div class="col-lg-3 col-md-12 col-sm-12 info-column"
                itemscope
                itemtype="https://schema.org/LocalBusiness">

                <meta itemprop="name" content="Worldwide Events and Conference">

                <div class="info-inner">

                    <div class="single-item mb_60">
                        <h2>Contact Details</h2>
                        <ul class="info-list clearfix">
                            <li>
                                <i class="icon-27"></i>
                                <a href="mailto:example@templatepath.com" itemprop="email">
                                    example@templatepath.com
                                </a>
                            </li>
                            <li>
                                <i class="icon-28"></i>
                                <a href="tel:7045550127" itemprop="telephone">
                                    (704) 555-0127
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="single-item mb_60">
                        <h2>Business Enquiries</h2>
                        <ul class="info-list clearfix">
                            <li>
                                <i class="icon-27"></i>
                                <a href="mailto:example@info.com">example@info.com</a>
                            </li>
                            <li>
                                <i class="icon-28"></i>
                                <a href="tel:4065550120">(406) 555-0120</a>
                            </li>
                        </ul>
                    </div>

                    <div class="single-item">
                        <h2>Social</h2>
                        <ul class="info-list clearfix">
                            <li>
                                <i class="icon-29"></i>
                                <a href="<?= $baseUrl ?>/contact">@WorldwideEvents</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- contact-section end -->


<!-- google-map-section -->
<section class="google-map-section">
    <div class="map-inner">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.726375674068!2d77.4436929752998!3d28.607984375678125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cee5d3506faf1%3A0xf1b789fb5f1d64c1!2sAjnara%20Homes!5e0!3m2!1sen!2sin!4v1767855199734!5m2!1sen!2sin"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<?php include 'inc/footer.php'; ?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>