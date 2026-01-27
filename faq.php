<?php
include './admin/inc/db.php';

/* ========= SEO META ========= */
$title = "FAQ & Support | Worldwide Events and Conference";
$meta_desc = "Find answers to frequently asked questions about Worldwide Events and Conference, including event bookings, weddings, corporate events, and support.";

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

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ul class="bread-crumb clearfix mb_20">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li>FAQ</li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1>Support & Frequently Asked Questions</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- faq-page-section -->
<section class="faq-page-section pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- FAQ CONTENT -->
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="content-box">
                    <div class="sec-title mb_60">
                        <span class="sub-title">FAQ</span>
                        <h2>Popular Questions</h2>
                    </div>

                    <ul class="accordion-box" itemscope itemtype="https://schema.org/FAQPage">

                        <?php
                        $faqs = [
                            [
                                "q" => "What services does Worldwide Events and Conference provide?",
                                "a" => "We specialize in wedding planning, corporate events, conferences, exhibitions, and party bookings across India."
                            ],
                            [
                                "q" => "Do you organize corporate and private events?",
                                "a" => "Yes, we handle corporate conferences, exhibitions, weddings, private parties, and large-scale events."
                            ],
                            [
                                "q" => "How can I book an event with your team?",
                                "a" => "You can book an event by contacting us through our website or calling our support team for personalized assistance."
                            ],
                            [
                                "q" => "Do you offer customized event planning?",
                                "a" => "Absolutely. Every event is tailored to match your vision, budget, and requirements."
                            ],
                            [
                                "q" => "Do you follow an anti-harassment and safety policy?",
                                "a" => "Yes, we maintain a strict anti-harassment policy to ensure a safe and respectful environment for all attendees."
                            ]
                        ];

                        foreach ($faqs as $index => $faq) {
                        ?>
                        <li class="accordion block <?= $index === 0 ? 'active-block' : '' ?>"
                            itemprop="mainEntity"
                            itemscope
                            itemtype="https://schema.org/Question">

                            <div class="acc-btn <?= $index === 0 ? 'active' : '' ?>">
                                <div class="icon-box"><i class="icon-20"></i></div>
                                <span itemprop="name"><?= $faq['q'] ?></span>
                            </div>

                            <div class="acc-content <?= $index === 0 ? 'current' : '' ?>"
                                 itemprop="acceptedAnswer"
                                 itemscope
                                 itemtype="https://schema.org/Answer">
                                <div class="text">
                                    <p itemprop="text"><?= $faq['a'] ?></p>
                                </div>
                            </div>
                        </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="faq-sidebar default-sidebar">

                    <!-- Recent Posts -->
                    <div class="sidebar-widget post-widget mb_40">
                        <div class="widget-title mb_30">
                            <h3>Recent Blog Posts</h3>
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
                                        <a href="<?= $baseUrl ?>/blog/<?= $row['slug']; ?>">
                                            <img src="<?= $baseUrl ?>/admin/<?= $row['bg_image']; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                                        </a>
                                    </figure>
                                    <h6>
                                        <a href="<?= $baseUrl ?>/blog/<?= $row['slug']; ?>">
                                            <?= htmlspecialchars($row['title']); ?>
                                        </a>
                                    </h6>
                                    <span class="post-date">
                                        <?= date('F d, Y', strtotime($row['created_at'])); ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget category-widget mb_40">
                        <div class="widget-title mb_30">
                            <h3>Categories</h3>
                        </div>
                        <ul class="category-list clearfix">
                            <?php
                            $cats = mysqli_query($conn, "SELECT * FROM blog_categories ORDER BY name ASC");
                            while ($cat = mysqli_fetch_assoc($cats)) {
                            ?>
                                <li>
                                    <a href="<?= $baseUrl ?>/blogs/category/<?= $cat['id']; ?>">
                                        <?= htmlspecialchars($cat['name']); ?>
                                        <i class="icon-25"></i>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar-widget tags-widget">
                        <div class="widget-title mb_30">
                            <h3>Tags</h3>
                        </div>
                        <ul class="tags-list clearfix">
                            <?php
                            $tagResult = mysqli_query($conn, "SELECT tags FROM blogs ORDER BY created_at DESC LIMIT 10");
                            $tagsArray = [];

                            while ($row = mysqli_fetch_assoc($tagResult)) {
                                foreach (explode(',', $row['tags']) as $tag) {
                                    $tag = trim($tag);
                                    if ($tag) $tagsArray[] = $tag;
                                }
                            }

                            foreach (array_slice(array_unique($tagsArray), 0, 10) as $tag) {
                            ?>
                                <li>
                                    <a href="<?= $baseUrl ?>/blogs/tag/<?= urlencode($tag); ?>">
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
</section>
<!-- faq-page-section end -->

<?php include 'inc/footer.php'; ?>