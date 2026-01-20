<?php
include './admin/inc/db.php';
include 'inc/header2.php';

// Fetch all gallery items
$query = "SELECT `id`, `type`, `link`, `created_at` FROM `gallery` ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-3.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.php"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Event Gallery</li>
            </ul>
            <h1>Event Gallery</h1>
        </div>
    </div>
</section>

<section class="gallery-style-two pt_140 pb_110">
    <div class="auto-container">
        <div class="sortable-masonry">
            <div class="items-container row clearfix">

                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        // We use the 'type' from DB as a CSS class for the filtering system
                        $filter_class = strtolower($row['type']); 
                        
                        // Handle the image path - assuming images are in admin/uploads/gallery/
                        // If 'link' is just the filename, we append the path.
                        $image_url = 'admin/uploads/gallery/' . basename($row['link']);
                ?>
                
                <div class="col-lg-4 col-md-6 col-sm-12 masonry-item small-column all <?php echo $filter_class; ?>">
                    <div class="gallery-block-two">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="<?php echo $image_url; ?>" alt="Gallery Image">
                            </figure>
                            <div class="link">
                                <a href="<?php echo $image_url; ?>" class="lightbox-image" data-fancybox="gallery">
                                    <i class="icon-25"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                    }
                } else {
                    echo "<div class='col-12 text-center'><h3>No images found in gallery.</h3></div>";
                }
                ?>

            </div>
        </div>
    </div>
</section>

<?php
include 'inc/footer.php';
?>