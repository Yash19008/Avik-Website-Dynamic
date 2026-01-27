<?php
include './admin/inc/db.php';

$title = "About Us | Worldwide Events and Conference";
$meta_desc = "Learn about Worldwide Events and Conference – a professional event management company specializing in corporate events, weddings, exhibitions, and party planning across India.";

include 'inc/header2.php';
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-4.jpg);"></div>

    <div class="auto-container">
        <div class="content-box">

            <!-- SEO Breadcrumbs -->
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="<?= $baseUrl ?>/">Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>About Us</li>
            </ul>

            <!-- H1 (ONLY ONE H1 PER PAGE) -->
            <h1>About Us - Worldwide Events and Conference</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- about-style-two -->
<section class="about-style-two pt_200 pb_120">
    <div class="auto-container">
        <div class="row align-items-center">

            <!-- Content -->
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content-box">

                    <!-- H2 -->
                    <div class="sec-title mb_20">
                        <span class="sub-title">About Our Company</span>
                        <h2>Creating Memorable Corporate Events, Weddings & Celebrations</h2>
                    </div>

                    <div class="text-box">
                        <p>
                            Worldwide Events and Conference is a professional event management company offering
                            corporate events, wedding planning, exhibitions, and party bookings across India.
                            With creative vision, expert planning, and flawless execution, we turn ideas into
                            unforgettable experiences.
                        </p>
                        <p>
                            From concept to completion, our dedicated team ensures every detail is handled with
                            precision, creativity, and care.
                        </p>
                    </div>

                </div>
            </div>

            <!-- Images with ALT tags -->
            <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                <div class="image-box">
                    <figure class="image image-1">
                        <img src="assets/images/resource/about-4.jpg" alt="Corporate event planning by Worldwide Events and Conference">
                    </figure>
                    <figure class="image image-2">
                        <img src="assets/images/resource/about-1.png" alt="Wedding and party planning services">
                    </figure>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- about-style-two end -->


<!-- mission-section -->
<section class="mission-section pt_140 pb_110 centred">
    <div class="auto-container">

        <div class="title-inner mb_60">
            <div class="sec-title centred mb_20">
                <span class="sub-title">Our Purpose</span>
                <h2>Our Mission</h2>
            </div>

            <p>
                Our mission is to deliver seamless, innovative, and memorable event experiences
                through creativity, precision, and personalized service.
            </p>
        </div>

        <div class="row clearfix">

            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <img src="assets/images/icons/icon-2.png" alt="Corporate event meetups">
                        </div>
                        <h3>Day-Long Meetups</h3>
                        <p>Well-planned corporate meetups designed for engagement and impact.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <img src="assets/images/icons/icon-3.png" alt="Leadership conferences">
                        </div>
                        <h3>Meet the Leaders</h3>
                        <p>Professional conferences connecting industry leaders worldwide.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <img src="assets/images/icons/icon-4.png" alt="Event Q&A sessions">
                        </div>
                        <h3>Interactive Sessions</h3>
                        <p>Engaging discussions and Q&A sessions to inspire innovation.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- mission-section end -->

<?php
include 'inc/footer.php';
?>