<?php
include './admin/inc/db.php';

/* ========= SEO META ========= */
$title = "Upcoming Events & Conferences | Worldwide Events and Conference";
$meta_desc = "Explore upcoming corporate events, conferences, weddings, and exhibitions organized by Worldwide Events and Conference across India.";

include 'inc/header2.php';

/* ========= HELPERS ========= */
function event_image($json_images) {
    $images = json_decode($json_images, true) ?: [];
    $first_image = !empty($images) ? basename($images[0]) : 'default.jpg';
    return 'admin/uploads/events/' . $first_image;
}

$query = "SELECT * FROM events ORDER BY date ASC, time ASC";
$result = mysqli_query($conn, $query);
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/page-title.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ul class="bread-crumb clearfix mb_20">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li>Events</li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1>Upcoming Events & Conferences</h1>
        </div>
    </div>
</section>

<!-- event-section -->
<section class="event-section event-page-section pt_140 pb_110">
    <div class="auto-container">

        <div class="event-content"
             itemscope
             itemtype="https://schema.org/ItemList">

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php
                $position = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <div class="event-block-one mb_30"
                     itemprop="itemListElement"
                     itemscope
                     itemtype="https://schema.org/Event">

                    <div class="inner-box">

                        <figure class="image-box">
                            <a href="<?= $baseUrl ?>/event/<?= $row['slug']; ?>" itemprop="url">
                                <img src="<?= $baseUrl ?>/<?= event_image($row['images']); ?>"
                                     alt="<?= htmlspecialchars($row['title']); ?>"
                                     itemprop="image">
                            </a>
                        </figure>

                        <div class="inner">
                            <h2 itemprop="name">
                                <a href="<?= $baseUrl ?>/event/<?= $row['slug']; ?>">
                                    <?= htmlspecialchars($row['title']); ?>
                                </a>
                            </h2>

                            <p itemprop="description">
                                <?= substr(strip_tags($row['content']), 0, 160); ?>…
                            </p>

                            <ul class="info-list">
                                <li>
                                    <i class="far fa-calendar-alt"></i>
                                    <time itemprop="startDate" datetime="<?= $row['date']; ?>">
                                        <?= date('F d, Y', strtotime($row['date'])); ?>
                                    </time>
                                </li>
                                <li>
                                    <i class="icon-16"></i>
                                    <?= htmlspecialchars($row['time']); ?>
                                </li>
                                <li itemprop="location" itemscope itemtype="https://schema.org/Place">
                                    <i class="icon-4"></i>
                                    <span itemprop="name">
                                        <?= htmlspecialchars($row['info']); ?>
                                    </span>
                                </li>
                            </ul>

                            <meta itemprop="eventAttendanceMode"
                                  content="https://schema.org/OfflineEventAttendanceMode">
                            <meta itemprop="eventStatus"
                                  content="https://schema.org/EventScheduled">
                        </div>
                    </div>
                </div>

                <?php
                $position++;
                endwhile;
                ?>
            <?php else: ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>

        </div>
    </div>
</section>
<!-- event-section end -->

<?php include 'inc/footer.php'; ?>
