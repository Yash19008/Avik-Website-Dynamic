<?php
include './admin/inc/db.php';
include 'inc/header2.php';
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-5.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.php"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Faq</li>
            </ul>
            <h1>Support & FAQ</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- faq-page-section -->
<section class="faq-page-section pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="content-box">
                    <div class="sec-title mb_60">
                        <span class="sub-title"># FAQ</span>
                        <h2>Popular Questions</h2>
                    </div>
                    <ul class="accordion-box">
                        <li class="accordion block active-block">
                            <div class="acc-btn active">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                Things are not the most important thing. As a result, we will create exciting experiences.
                            </div>
                            <div class="acc-content current">
                                <div class="text">
                                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping you to achieve your dream wedding day. Psum volutpat in aliquam donec elit ac. Sed at aliquet mauris proin. Porttitor pellentesque id eu congue vitae mauris auctor sit varius. Et aliquam sed lorem vitae suspendisse. Posuere sollicitudin volutpat enim convallis donec nulla at. Tortor ut varius cum tellus ut amet arcu ac</p>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                Do you host any other events?
                            </div>
                            <div class="acc-content">
                                <div class="text">
                                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping you to achieve your dream wedding day. Psum volutpat in aliquam donec elit ac. Sed at aliquet mauris proin. Porttitor pellentesque id eu congue vitae mauris auctor sit varius. Et aliquam sed lorem vitae suspendisse. Posuere sollicitudin volutpat enim convallis donec nulla at. Tortor ut varius cum tellus ut amet arcu ac</p>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                How do I get to and from Wire Summit?
                            </div>
                            <div class="acc-content">
                                <div class="text">
                                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping you to achieve your dream wedding day. Psum volutpat in aliquam donec elit ac. Sed at aliquet mauris proin. Porttitor pellentesque id eu congue vitae mauris auctor sit varius. Et aliquam sed lorem vitae suspendisse. Posuere sollicitudin volutpat enim convallis donec nulla at. Tortor ut varius cum tellus ut amet arcu ac</p>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                How can I involve this programm?
                            </div>
                            <div class="acc-content">
                                <div class="text">
                                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping you to achieve your dream wedding day. Psum volutpat in aliquam donec elit ac. Sed at aliquet mauris proin. Porttitor pellentesque id eu congue vitae mauris auctor sit varius. Et aliquam sed lorem vitae suspendisse. Posuere sollicitudin volutpat enim convallis donec nulla at. Tortor ut varius cum tellus ut amet arcu ac</p>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                Do you have an anti-harassment policy?
                            </div>
                            <div class="acc-content">
                                <div class="text">
                                    <p>With our passion, knowledge, creative flair and inspiration, we are dedicated in helping you to achieve your dream wedding day. Psum volutpat in aliquam donec elit ac. Sed at aliquet mauris proin. Porttitor pellentesque id eu congue vitae mauris auctor sit varius. Et aliquam sed lorem vitae suspendisse. Posuere sollicitudin volutpat enim convallis donec nulla at. Tortor ut varius cum tellus ut amet arcu ac</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="faq-sidebar default-sidebar">
                    <div class="sidebar-widget post-widget mb_40">
                        <div class="widget-title mb_30">
                            <h3>Recent Posts</h3>
                        </div>
                        <div class="post-inner">
                            <?php
                            $recent = mysqli_query(
                                $conn,
                                "SELECT slug,title,bg_image,created_at FROM blogs ORDER BY created_at DESC LIMIT 3"
                            );

                            while ($row = mysqli_fetch_assoc($recent)) {
                            ?>
                                <div class="post">
                                    <figure class="post-thumb">
                                        <a href="blog-details.php?slug=<?= $row['slug']; ?>">
                                            <img src="./admin/<?= $row['bg_image']; ?>" alt="">
                                        </a>
                                    </figure>
                                    <h6>
                                        <a href="blog-details.php?slug=<?= $row['slug']; ?>">
                                            <?= $row['title']; ?>
                                        </a>
                                    </h6>
                                    <span class="post-date">
                                        <?= date('F d, Y', strtotime($row['created_at'])); ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="sidebar-widget category-widget mb_40">
                        <div class="widget-title mb_30">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                <?php
                                $cats = mysqli_query($conn, "SELECT * FROM blog_categories ORDER BY name ASC");
                                while ($cat = mysqli_fetch_assoc($cats)) {
                                ?>
                                    <li>
                                        <a href="blogs.php?category=<?= $cat['id']; ?>">
                                            <?= htmlspecialchars($cat['name']); ?>
                                            <i class="icon-25"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget tags-widget">
                        <div class="widget-title mb_30">
                            <h3>Tags</h3>
                        </div>
                        <div class="widget-content">
                            <?php
                            $tagResult = mysqli_query(
                                $conn,
                                "SELECT tags FROM blogs ORDER BY created_at DESC LIMIT 10"
                            );

                            $tagsArray = [];

                            while ($row = mysqli_fetch_assoc($tagResult)) {
                                $tags = explode(',', $row['tags']);
                                foreach ($tags as $tag) {
                                    $cleanTag = trim($tag);
                                    if ($cleanTag !== '') {
                                        $tagsArray[] = $cleanTag;
                                    }
                                }
                            }

                            $tagsArray = array_unique($tagsArray);
                            shuffle($tagsArray);
                            $tagsArray = array_slice($tagsArray, 0, 10);
                            ?>

                            <ul class="tags-list clearfix">
                                <?php foreach ($tagsArray as $tag) { ?>
                                    <li>
                                        <a href="blogs.php?tag=<?= urlencode($tag); ?>">
                                            <?= htmlspecialchars($tag); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq-page-section end -->

<?php
include 'inc/footer.php';
?>