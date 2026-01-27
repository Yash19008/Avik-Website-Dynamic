<?php
include 'admin/inc/db.php';
include 'inc/header.php';
?>
<link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/partners.css">
<!-- banner-section -->
<section class="banner-section p_relative centred">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/banner/banner-1.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-1.png);"></div>
        <div class="pattern-2 rotate-me" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-2.png);"></div>
        <div class="pattern-3" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-3.png);"></div>
        <div class="pattern-4" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-4.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <h2>Worldwide Events and <span>Conferences</span></h2>
            <a href="<?= $baseUrl ?>/events" class="theme-btn btn-one">Explore Events</a>
        </div>
    </div>
    <ul class="social-links">
        <li><a href="#"><i class="fab fa-facebook-f"></i>facebook</a></li>
        <li><a href="https://www.instagram.com/worldwideventsconference/"><i class="fab fa-instagram"></i>instagram</a></li>
    </ul>
</section>
<!-- banner-section end -->


<!-- conference-section -->
<section class="conference-section">
    <div class="outer-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12 content-column">
                <div class="content-box">
                    <h3>Head Offoce Location:</h3>
                    <div class="inner-box">
                        <div class="single-item">
                            <div class="icon-box"><i class="icon-3"></i></div>
                            <h4>Timing :</h4>
                            <p>Monday to Saturday - 10 AM to 6:30 PM</p>
                        </div>
                        <div class="single-item">
                            <div class="icon-box"><i class="icon-4"></i></div>
                            <h4>Location :</h4>
                            <p>Flat no 2102, k tower, Ajnara homes, Sector 16B, Greater Noida 201318</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 carousel-column">
                <div class="carousel-content">
                    <span class="title-text">Advancing Craft Connect People</span>
                    <div class="conference-carousel owl-carousel owl-theme owl-nav-none dots-style-one">
                        <?php
                        $blogs = mysqli_query(
                            $conn,
                            "SELECT *, users.name AS author_name FROM blogs LEFT JOIN users ON users.id = blogs.added_by ORDER BY blogs.created_at DESC LIMIT 9"
                        );

                        while ($blog = mysqli_fetch_assoc($blogs)) {
                        ?>
                            <div class="conference-block-one">
                                <div class="inner-box">
                                    <figure class="image-box">
                                        <img src="<?= $baseUrl ?>/admin/<?= $blog['bg_image']; ?>" alt="">
                                    </figure>
                                    <div class="lower-content">
                                        <h3>
                                            <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">
                                                <?= $blog['title']; ?>
                                            </a>
                                        </h3>
                                        <p>
                                            <?= substr(strip_tags($blog['content']), 0, 120); ?>...
                                        </p>
                                        <div class="link">
                                            <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- conference-section end -->


<!-- about-section -->
<section class="about-section pt_140 pb_140">
    <div class="pattern-layer">
        <div class="pattern-1 float-bob-y" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-5.png);"></div>
        <div class="pattern-2" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-6.png);"></div>
        <div class="pattern-3" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-7.png);"></div>
    </div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-7 col-md-12 col-sm-12 content-column">
                <div class="content-box">
                    <div class="inner-box mb_40">
                        <div class="icon-box"><i class="icon-5"></i></div>
                        <div class="sec-title mb_20">
                            <span class="sub-title"># About Us</span>
                            <h2>Worldwide Events and Conference</h2>
                        </div>
                        <div class="text-box">
                            <p>Worldwide Events and Conference is a Professional Corporate event, Exhibition stall design, fabrication work, party booking and wedding planning Platform. Here we will only provide you with interesting content that you will enjoy very much. We are committed to providing you the best of Corporate event party booking wedding planning, with a focus on reliability and Corporate event party booking wedding planning. we strive to turn our passion for Corporate event party booking wedding planning into a thriving website.</p>
                            <a href="<?= $baseUrl ?>/about-us">Read More</a>
                        </div>
                    </div>
                    <div class="image-inner">
                        <figure class="image image-1"><img src="<?= $baseUrl ?>/assets/images/resource/about-1.jpg" alt=""></figure>
                        <figure class="image image-2"><img src="<?= $baseUrl ?>/assets/images/resource/about-2.jpg" alt=""></figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 image-column">
                <figure class="image-box"><img src="<?= $baseUrl ?>/assets/images/resource/about-3.jpg" alt=""></figure>
            </div>
        </div>
    </div>
</section>
<!-- about-section end -->


<!-- video-section -->
<section class="video-section pb_120">
    <div class="pattern-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-10.png);"></div>
    <span class="big-text">Event Program</span>
    <div class="auto-container">
        <div class="inner-container">
            <div class="content-box">
                <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/video-bg.jpg);"></div>
                <div class="shape">
                    <div class="shape-1" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-8.png);"></div>
                    <div class="shape-2" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-9.png);"></div>
                </div>
                <div class="inner-box">
                    <div class="icon-box"><span>e</span></div>
                    <h3><a href="/">Welcome To Worldwide Events and Conference</a></h3>
                    <p>Worldwide Events and Conference is a Professional Corporate event party booking wedding planning Platform.
                    <p>Here we will only provide you with interesting content that you will enjoy very much.</p>
                    <p>We are committed to providing you the best of Corporate event party booking wedding planning, with a focus on reliability and Corporate event party booking wedding planning.</p>
                    <p>we strive to turn our passion for Corporate event party booking wedding planning into a thriving website.</p>
                    <p>We hope you enjoy our Corporate event party booking wedding planning as much as we enjoy giving them to you.</p><br>
                    <p>I will keep on posting such valuable anf knowledgeable information on my Website for all of you. Your love and support matters a lot.</p>

                </div>
                <div class="video-btn">
                    <a href="#" class="lightbox-image" data-caption=""><i class="icon-6"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- video-section end -->

<?php
$works = mysqli_query($conn, "SELECT * FROM works ORDER BY created_at DESC LIMIT 8");
?>
<!-- works-section -->
<section class="team-section">
    <div class="outer-container clearfix">

        <?php while ($work = mysqli_fetch_assoc($works)): ?>
            <div class="team-block-one">
                <div class="inner-box">

                    <!-- Background Image -->
                    <div class="bg-layer"
                         style="background-image: url(<?php echo htmlspecialchars($work['image']); ?>);">
                    </div>

                    <!-- Content -->
                    <div class="content-box">
                        <h3 class="text-white">
                            <?php echo htmlspecialchars($work['name']); ?>
                        </h3>
                        <span class="designation">
                            <?php echo htmlspecialchars($work['location']); ?>
                        </span>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>

    </div>
</section>
<!-- works-section end -->

<!-- mission-section -->
<section class="mission-section pt_140 pb_110 centred">
    <div class="pattern-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-11.png);"></div>
    <div class="auto-container">
        <div class="title-inner mb_60">
            <div class="sec-title centred mb_20">
                <span class="sub-title"># Event Target</span>
                <h2>Our Mission</h2>
            </div>
            <p>"At Worldwide Events and Conference, our mission is to create unforgettable experiences by providing exceptional wedding planning,<br> corporate event booking, and party organizing services across India. We are dedicated to making your celebration seamless and memorable, no matter the occasion."</p>
        </div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><img src="<?= $baseUrl ?>/assets/images/icons/icon-2.png" alt=""></div>
                        <h3><a href="/">Day Long Meetup</a></h3>
                        <p>At QOKO Events, we know that your lighting choices can make or break your event.</p>
                        <div class="link"><a href="<?= $baseUrl ?>">Read More</a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one wow fadeInUp animated" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><img src="<?= $baseUrl ?>/assets/images/icons/icon-3.png" alt=""></div>
                        <h3><a href="/">Meet The Leaders</a></h3>
                        <p>At QOKO Events, we know that your lighting choices can make or break your event.</p>
                        <div class="link"><a href="<?= $baseUrl ?>">Read More</a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mission-block">
                <div class="mission-block-one wow fadeInUp animated" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><img src="<?= $baseUrl ?>/assets/images/icons/icon-4.png" alt=""></div>
                        <h3><a href="/">Ask Questions</a></h3>
                        <p>At QOKO Events, we know that your lighting choices can make or break your event.</p>
                        <div class="link"><a href="<?= $baseUrl ?>">Read More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- mission-section end -->

<!-- gallery-section -->
<?php
$gallery = mysqli_query(
    $conn,
    "SELECT * FROM gallery WHERE type='image' AND featured = 1 ORDER BY created_at DESC LIMIT 4"
);

$galleryData = [];
while ($row = mysqli_fetch_assoc($gallery)) {
    $galleryData[] = $row;
}
?>
<section class="gallery-section pt_140">
    <div class="pattern-layer">
        <div class="pattern-1 float-bob-y" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-15.png);"></div>
        <div class="pattern-2 float-bob-y" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-16.png);"></div>
    </div>

    <div class="outer-container">
        <div class="row align-items-center">

            <!-- Title -->
            <div class="col-lg-5 col-md-12 col-sm-12 title-column">
                <div class="title-inner mb_30">
                    <div class="sec-title mb_20">
                        <span class="sub-title"># Photo Gallery</span>
                        <h2>Memories of Last Year</h2>
                    </div>
                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping.</p>
                </div>
            </div>

            <!-- FIRST IMAGE (LARGE BLOCK) -->
            <?php if (!empty($galleryData[0])) { ?>
                <div class="col-lg-7 col-md-12 col-sm-12 gallery-block">
                    <div class="gallery-block-one ml_40">
                        <div class="inner-box">
                            <div class="bg-layer"
                                style="background-image:url('<?= $galleryData[0]['link']; ?>');">
                            </div>
                            <div class="link">
                                <a href="<?= $galleryData[0]['link']; ?>" class="lightbox-image">
                                    <i class="icon-25"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- REST IMAGES (SMALL BLOCKS) -->
            <?php
            for ($i = 1; $i < count($galleryData); $i++) {
            ?>
                <div class="col-lg-4 col-md-6 col-sm-12 gallery-block">
                    <div class="gallery-block-one">
                        <div class="inner-box">
                            <div class="bg-layer"
                                style="background-image:url('<?= $galleryData[$i]['link']; ?>');">
                            </div>
                            <div class="link">
                                <a href="<?= $galleryData[$i]['link']; ?>" class="lightbox-image">
                                    <i class="icon-25"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
<!-- gallery-section end -->


<!-- testimonial-section -->
<section class="testimonial-section pt_110 pb_140">
    <div class="pattern-layer">
        <div class="pattern-1 float-bob-x" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-17.png);"></div>
        <div class="pattern-2" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-18.png);"></div>
    </div>
    <div class="auto-container">
        <div class="title-inner mb_60">
            <div class="sec-title mb_20">
                <span class="sub-title"># Testimonial</span>
                <h2>What Members Are Saying</h2>
            </div>
            <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping.</p>
        </div>
        <div class="testimonial-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
            <div class="testimonial-block-one">
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image"><img src="<?= $baseUrl ?>/assets/images/resource/testimonial-1.jpg" alt=""></figure>
                        <div class="icon-box"><i class="icon-8"></i></div>
                    </div>
                    <div class="text-box">
                        <p>"Highly professional services, the team is very proactive. It meets the expectations. We had a well organised event. Thanks to Mr. Avik Das and his entire team."</p>
                        <h3>Manoj Mishra</h3>

                    </div>
                </div>
            </div>
            <div class="testimonial-block-one">
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image"><img src="<?= $baseUrl ?>/assets/images/resource/testimonial-2.jpg" alt=""></figure>
                        <div class="icon-box"><i class="icon-8"></i></div>
                    </div>
                    <div class="text-box">
                        <p>"They made it So amazing for us on my sister's wedding. One of the best wedding planners in Noida, I've ever met. Their staff is very well trained, organized, on time …"</p>
                        <h3>Rajat Nigam</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial-section end -->


<!-- cta-section -->
<section class="cta-section centred pt_140 pb_140">
    <div class="bg-layer parallax-bg" data-parallax='{"y": 100}' style="background-image: url(<?= $baseUrl ?>/assets/images/background/cta-bg.jpg);"></div>
    <div class="auto-container">
        <div class="inner-box">
            <span># Bookings</span>
            <h2>Corporate Event And Party Booking <br /> Wedding Planning</h2>
            <a href="<?= $baseUrl ?>/events" class="theme-btn btn-one">Explore Events</a>
        </div>
    </div>
</section>
<!-- cta-section end -->


<!-- clients-section -->
<section class="clients-section pt_140">
    <div class="pattern-layer float-bob-y" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-19.png);"></div>
    <div class="auto-container">
        <div class="clients-inner mb_60">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12 title-column">
                    <div class="title-inner">
                        <div class="sec-title mb_20">
                            <span class="sub-title"># Sponsored by</span>
                            <h2>Amazing Partners & Sponsors </h2>
                        </div>
                        <p>With our passion, knowledge, creative flair and inspiration, we are <br />dedicated in helping.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 clients-column">
                    <div class="clients-inner">
                        <div class="clients-marquee">
                            <div class="marquee-track">
                                <?php
                                $partners = mysqli_query($conn, "SELECT * FROM partners");
                                while ($partner = mysqli_fetch_assoc($partners)) {
                                ?>
                                    <div class="marquee-item">
                                        <img src="<?= $baseUrl ?>/admin/uploads/partners/<?= $partner['image']; ?>" alt="">
                                    </div>
                                <?php } ?>

                                <?php
                                mysqli_data_seek($partners, 0);
                                while ($partner = mysqli_fetch_assoc($partners)) {
                                ?>
                                    <div class="marquee-item">
                                        <img src="<?= $baseUrl ?>/admin/uploads/partners/<?= $partner['image']; ?>" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- 
                        <ul class="clients-logo-list">
                                <li>
                                    <a href="#">
                                        <img src="./admin/uploads/partners/?= $partner['image']; ?>" alt="">
                                    </a>
                                </li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="map-inner">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.726375674068!2d77.4436929752998!3d28.607984375678125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cee5d3506faf1%3A0xf1b789fb5f1d64c1!2sAjnara%20Homes!5e0!3m2!1sen!2sin!4v1767855199734!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<!-- clients-section end -->


<!-- news-section -->
<section class="news-section pt_140 pb_110">
    <div class="pattern-layer">
        <div class="pattern-1 rotate-me" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-20.png);"></div>
        <div class="pattern-2" style="background-image: url(<?= $baseUrl ?>/assets/images/shape/shape-21.png);"></div>
    </div>
    <div class="auto-container">
        <div class="title-inner mb_60 centred">
            <div class="sec-title centred mb_20">
                <span class="sub-title"># Blogs</span>
                <h2>Latest Blog & News Event</h2>
            </div>
            <p>With our passion, knowledge, creative flair and inspiration, <br />we are dedicated in helping.</p>
        </div>
        <div class="row clearfix">
            <?php
            $blogs = mysqli_query(
                $conn,
                "SELECT *, users.name AS author_name FROM blogs LEFT JOIN users ON users.id = blogs.added_by ORDER BY blogs.created_at DESC LIMIT 3"
            );
            while ($blog = mysqli_fetch_assoc($blogs)) {
            ?>
                <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                    <div class="news-block-one">
                        <div class="inner-box">
                            <figure class="image-box">
                                <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">
                                    <img src="<?= $baseUrl ?>/admin/<?= $blog['bg_image']; ?>" alt="">
                                </a>
                            </figure>
                            <div class="lower-content">
                                <ul class="info-list mb_15">
                                    <li><?= date('F d, Y', strtotime($blog['created_at'])); ?></li>
                                    <li>|</li>
                                    <li>by <?php echo htmlspecialchars($blog['author_name'] ?? 'Unknown'); ?></li>
                                </ul>
                                <h3>
                                    <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">
                                        <?= $blog['title']; ?>
                                    </a>
                                </h3>
                                <p><?= substr(strip_tags($blog['content']), 0, 100); ?>...</p>
                                <div class="link">
                                    <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- news-section end -->


<?php
include 'inc/footer.php';
?>