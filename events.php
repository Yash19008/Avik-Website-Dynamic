<?php
include './admin/inc/db.php';
include 'inc/header2.php';

function event_image($json_images) {
    $images = json_decode($json_images, true) ?: [];
    $first_image = !empty($images) ? basename($images[0]) : 'default.jpg';
    return 'admin/uploads/events/' . $first_image;
}

$query = "SELECT * FROM events ORDER BY date ASC, time ASC";
$result = mysqli_query($conn, $query);
?>
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.php"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Events Schedule</li>
            </ul>
            <h1>Events Schedule</h1>
        </div>
    </div>
</section>

<section class="event-section event-page-section pt_140 pb_110">
    <div class="auto-container">
        <div class="tabs-box">
            <div class="tabs-content">
                <div class="tab active-tab" id="tab-1">
                    <div class="event-content">
                        
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                
                                <div class="event-block-one mb_30">
                                    <div class="inner-box">
                                        <figure class="image-box">
                                            <a href="event-details.php?id=<?php echo $row['id']; ?>">
                                                <img src="<?php echo event_image($row['images']); ?>" alt="">
                                            </a>
                                        </figure>
                                        <div class="inner">
                                            <h5>
                                                <a href="event-details.php?id=<?php echo $row['id']; ?>">
                                                    <?php echo $row['title']; ?>
                                                </a>
                                            </h5>
                                            <p><?php echo substr(strip_tags($row['content']), 0, 150); ?>...</p>
                                            <ul class="info-list">
                                                <li><i class="icon-16"></i><?php echo $row['time']; ?></li>
                                                <li><i class="icon-4"></i><?php echo $row['info']; ?></li>
                                                <li><i class="far fa-calendar-alt"></i> <?php echo $row['date']; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                        <?php else: ?>
                            <p>No events found.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'inc/footer.php';
?>