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

function event_image($file) {
    $filename = basename($file);
    return 'admin/uploads/events/' . $filename;
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
                <li><a href="index.html"># Home</a></li>
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
                    <div class="btn-box">
                        <a href="#" class="theme-btn btn-one">Purchase Ticket</a>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-9 col-md-12 col-sm-12 text-column">
                        <div class="text-box">
                            <?php echo $data['content']; ?>
                        </div>

                        <hr>
                        <h3 class="mt_20"><?php echo $data['speaker_name']; ?></h3>
                        <p><em><?php echo $data['speaker_desg']; ?></em></p>
                        <p><?php echo $data['speaker_desc']; ?></p>

                        <?php if($data['speaker_image']): ?>
                            <img src="<?php echo event_image($data['speaker_image']); ?>" width="200" class="mt_20 mb_20">
                        <?php endif; ?>

                        <?php if ($socials): ?>
                            <h4>Follow Speaker:</h4>
                            <ul>
                                <?php foreach($socials as $s): ?>
                                    <li><a href="<?php echo $s['link']; ?>" target="_blank"><?php echo $s['name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 info-column">
                        <div class="info-inner">
                            <div class="single-info-box">
                                <h3>Event Info :</h3>
                                <span><?php echo $data['info']; ?></span>
                            </div>
                            <div class="single-info-box">
                                <h3>Event Date :</h3>
                                <span><?php echo $data['date']; ?></span>
                            </div>
                            <div class="single-info-box">
                                <h3>Event Time :</h3>
                                <span><?php echo $data['time']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- event-details end -->
<?php
include 'inc/footer.php';
?>
