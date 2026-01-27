<?php
include './admin/inc/db.php';

/* ================= SEO META ================= */
$title = "Event Gallery | Worldwide Events and Conference";
$meta_desc = "Browse photos from our past corporate events, weddings, conferences, and exhibitions organized by Worldwide Events and Conference.";

/* ================= FETCH IMAGES ONLY ================= */
$query = "
    SELECT id, link, created_at 
    FROM gallery 
    WHERE type = 'image'
    ORDER BY created_at DESC
";
$result = mysqli_query($conn, $query);

include 'inc/header2.php';
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/page-title-3.jpg);"></div>
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
                    <li>Gallery</li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1>Event Gallery</h1>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-style-two pt_140 pb_110"
         itemscope
         itemtype="https://schema.org/ImageGallery">

    <div class="auto-container">
        <div class="sortable-masonry">
            <div class="items-container row clearfix">

                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 masonry-item small-column"
                             itemprop="associatedMedia"
                             itemscope
                             itemtype="https://schema.org/ImageObject">

                            <div class="gallery-block-two">
                                <div class="inner-box">

                                    <figure class="image-box">
                                        <img
                                            src="<?= htmlspecialchars($row['link']); ?>"
                                            alt="Event Gallery Image"
                                            loading="lazy"
                                            itemprop="contentUrl">
                                    </figure>

                                    <div class="link">
                                        <a href="<?= htmlspecialchars($row['link']); ?>"
                                           class="lightbox-image"
                                           data-fancybox="gallery"
                                           itemprop="url">
                                            <i class="icon-25"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <h2>No images found in the gallery.</h2>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
