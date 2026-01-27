<?php
include './admin/inc/db.php';

/* ================= SEO META ================= */
$title = "Video Gallery | Worldwide Events and Conference";
$meta_desc = "Watch highlights, event videos, conferences, weddings, and corporate event moments by Worldwide Events and Conference.";

/* ================= FETCH VIDEOS ONLY ================= */
$query = "
    SELECT id, link, created_at
    FROM gallery
    WHERE type = 'video'
    ORDER BY created_at DESC
";
$result = mysqli_query($conn, $query);

/* ================= HELPERS ================= */
function getVideoEmbed($url)
{
    // YouTube
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        preg_match('/(youtu\.be\/|v=)([^&]+)/', $url, $matches);
        return isset($matches[2])
            ? "https://www.youtube.com/embed/" . $matches[2]
            : null;
    }

    // Vimeo
    if (strpos($url, 'vimeo.com') !== false) {
        preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches);
        return isset($matches[1])
            ? "https://player.vimeo.com/video/" . $matches[1]
            : null;
    }

    // MP4
    if (preg_match('/\.mp4$/', $url)) {
        return $url;
    }

    return null;
}

include 'inc/header2.php';
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/page-title-3.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ul class="bread-crumb clearfix mb_20">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li>Video Gallery</li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1>Event Video Gallery</h1>
        </div>
    </div>
</section>

<!-- video-gallery -->
<section class="gallery-style-two pt_140 pb_110"
         itemscope
         itemtype="https://schema.org/VideoGallery">

    <div class="auto-container">
        <div class="row clearfix">

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        $embedUrl = getVideoEmbed($row['link']);
                        if (!$embedUrl) continue;
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb_40"
                         itemprop="associatedMedia"
                         itemscope
                         itemtype="https://schema.org/VideoObject">

                        <div class="video-block-one">

                            <div class="video-wrapper">

                                <?php if (str_ends_with($embedUrl, '.mp4')): ?>
                                    <!-- MP4 -->
                                    <video controls preload="metadata" width="100%" itemprop="contentUrl">
                                        <source src="<?= htmlspecialchars($embedUrl); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else: ?>
                                    <!-- YouTube / Vimeo -->
                                    <iframe
                                        src="<?= htmlspecialchars($embedUrl); ?>"
                                        loading="lazy"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                        itemprop="embedUrl">
                                    </iframe>
                                <?php endif; ?>

                            </div>

                            <!-- Schema metadata -->
                            <meta itemprop="uploadDate"
                                  content="<?= date('Y-m-d', strtotime($row['created_at'])); ?>">
                            <meta itemprop="name" content="Event Video">
                            <meta itemprop="description"
                                  content="Event highlights by Worldwide Events and Conference">

                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <h2>No videos available right now.</h2>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>