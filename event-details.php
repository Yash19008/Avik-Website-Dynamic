<?php
include './admin/inc/db.php';
include 'inc/header2.php';
?>

<?php
$id = (int)($_GET['id'] ?? 0);
$event = mysqli_query($conn, "SELECT * FROM events WHERE id=$id LIMIT 1");
$data = mysqli_fetch_assoc($event);

if (!$data) die("Event not found");

// Decode JSON
$images = json_decode($data['images'], true) ?: [];
$socials = json_decode($data['speaker_socials'], true) ?: [];

function event_image($file)
{
    if (!$file) return 'assets/images/placeholder.jpg';
    return 'admin/uploads/events/' . basename($file);
}

?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.php"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Event Details</li>
            </ul>
            <h1>Event Details</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- event-details -->
<section class="event-details pt_100 pb_80">
    <div class="auto-container">
        <div class="event-details-content">

            <!-- Event Images Carousel -->
            <div class="carousel-content">
                <div class="single-item-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
                    <?php foreach ($images as $img): ?>
                        <figure class="image-box">
                            <img src="<?php echo event_image($img); ?>" alt="">
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="content-box pt_40 p_relative">
                <div class="title-box">
                    <div class="title-text">
                        <h2><?php echo $data['title']; ?></h2>
                        <div class="time"><i class="icon-16"></i><?php echo $data['time']; ?></div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-9 col-md-12 col-sm-12 text-column">
                        <div class="text-box">
                            <?php echo $data['content']; ?>
                        </div>
                        <hr>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 info-column">
                        <div class="info-inner">
                            <div class="single-info-box">
                                <div class="light-icon"><img src="assets/images/icons/icon-12.png" alt=""></div>
                                <h3>Event Info :</h3>
                                <span><img src="assets/images/icons/icon-11.png" alt=""><?php echo $data['info']; ?></span>
                            </div>
                            <div class="single-info-box">
                                <div class="light-icon"><img src="assets/images/icons/icon-14.png" alt=""></div>
                                <h3>Event Date :</h3>
                                <span><img src="assets/images/icons/icon-13.png" alt=""><?php echo $data['date']; ?></span>
                            </div>
                            <div class="single-info-box">
                                <div class="light-icon"><img src="assets/images/icons/icon-14.png" alt=""></div>
                                <h3>Event Time :</h3>
                                <span><img src="assets/images/icons/icon-13.png" alt=""><?php echo $data['time']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- event-details end -->

<!-- team-details -->
<section class="team-details pb_140">
    <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-48.png);"></div>
    <div class="auto-container">
        <div class="sec-title mb_40">
            <span class="sub-title"># Speaker Info</span>
            <h2>About The Speaker</h2>
        </div>

        <div class="team-details-content">
            <div class="row align-items-center">

                <!-- Speaker Image -->
                <div class="col-lg-5 col-md-12 col-sm-12 image-column">
                    <figure class="image-box">
                        <?php if (!empty($data['speaker_image'])): ?>
                            <img src="<?php echo event_image($data['speaker_image']); ?>" alt="">
                        <?php else: ?>
                            <img src="assets/images/team/default-speaker.jpg" alt="">
                        <?php endif; ?>
                    </figure>
                </div>

                <!-- Speaker Content -->
                <div class="col-lg-7 col-md-12 col-sm-12 content-column">
                    <div class="content-box">

                        <h3><?php echo htmlspecialchars($data['speaker_name']); ?></h3>
                        <span class="designation">
                            <?php echo htmlspecialchars($data['speaker_desg']); ?>
                        </span>

                        <p>
                            <?php echo nl2br(htmlspecialchars($data['speaker_desc'])); ?>
                        </p>

                        <?php if (!empty($socials)): ?>
                            <ul class="list-item clearfix">
                                <?php foreach ($socials as $s): ?>
                                    <?php if (!empty($s['name']) && !empty($s['link'])): ?>
                                        <li>
                                            <span><?php echo htmlspecialchars($s['name']); ?> :</span>
                                            &nbsp;
                                            <a href="<?php echo htmlspecialchars($s['link']); ?>" target="_blank" rel="noopener">
                                                <?php echo htmlspecialchars($s['link']); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- team-details end -->

<?php
include 'inc/footer.php';
?>