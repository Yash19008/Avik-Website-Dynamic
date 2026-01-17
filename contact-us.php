<?php
include './admin/inc/db.php';
include 'inc/header2.php';
?>
<link href="assets/css/module-css/page-title.css" rel="stylesheet">
<link href="assets/css/module-css/contact.css" rel="stylesheet">

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-7.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.html"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Contact</li>
            </ul>
            <h1>Contact Us</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- contact-section -->
<section class="contact-section pt_140 pb_140">
    <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-49.png);"></div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-9 col-md-12 col-sm-12 form-column">
                <div class="form-inner">
                    <form method="post" action="" id="contact-form" class="default-form">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="username" placeholder="Name*" required="">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="email" name="email" placeholder="Email*" required="">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="phone" required="" placeholder="Your Phone*">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="subject" required="" placeholder="Subject">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <textarea name="message" placeholder="Enter your comment here"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button class="theme-btn btn-one" type="submit" name="submit-form">Send Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 info-column">
                <div class="info-inner">
                    <div class="single-item mb_60">
                        <h6>Be Creative Our Team</h6>
                        <ul class="info-list clearfix">
                            <li><i class="icon-27"></i><a href="mailto:example@templatepath.com">example@templatepath.com</a></li>
                            <li><i class="icon-28"></i><a href="tel:7045550127">(704) 555-0127</a></li>
                        </ul>
                    </div>
                    <div class="single-item mb_60">
                        <h6>Let's Call or Email</h6>
                        <ul class="info-list clearfix">
                            <li><i class="icon-27"></i><a href="mailto:example@info.com">example@info.com</a></li>
                            <li><i class="icon-28"></i><a href="tel:4065550120">(406) 555-0120</a></li>
                        </ul>
                    </div>
                    <div class="single-item">
                        <h6>Let's Call or Email </h6>
                        <ul class="info-list clearfix">
                            <li><i class="icon-29"></i><a href="contact.html">@templathPath</a></li>
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
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55945.16225505631!2d-73.90847969206546!3d40.66490264739892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1601263396347!5m2!1sen!2sbd" width="600" height="535" frameborder="0" style="border:0; width: 100%" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
</section>
<!-- google-map-section end -->


<?php
include 'inc/footer.php';
?>