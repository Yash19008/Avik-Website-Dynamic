<?php
include './admin/inc/db.php';

$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header("Location: /404");
    exit;
}

$query = "
    SELECT blogs.*, users.name AS author_name
    FROM blogs
    LEFT JOIN users ON users.id = blogs.added_by
    WHERE blogs.slug = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    header("Location: /404");
    exit;
}

/* ================= SEO META ================= */
$title = $blog['title'] . " | Worldwide Events and Conference";
$meta_desc = substr(strip_tags($blog['content']), 0, 160);

$recent_query = "SELECT slug, title, created_at, bg_image FROM blogs ORDER BY created_at DESC LIMIT 4";
$recent_result = mysqli_query($conn, $recent_query);

// Image helper
function blog_image($file)
{
    global $baseUrl;
    return $baseUrl . '/admin/uploads/blogs/' . basename($file);
}

include 'inc/header2.php';
?>

<!-- BlogPosting Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": <?= json_encode($blog['title']); ?>,
  "image": <?= json_encode(blog_image($blog['bg_image'])); ?>,
  "author": {
    "@type": "Person",
    "name": <?= json_encode($blog['author_name'] ?? 'Admin'); ?>
  },
  "publisher": {
    "@type": "Organization",
    "name": "Worldwide Events and Conference",
    "logo": {
      "@type": "ImageObject",
      "url": "<?= $baseUrl ?>/assets/images/logopp.png"
    }
  },
  "datePublished": "<?= date('Y-m-d', strtotime($blog['created_at'])); ?>",
  "dateModified": "<?= date('Y-m-d', strtotime($blog['updated_at'] ?? $blog['created_at'])); ?>",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?= $canonicalUrl ?>"
  }
}
</script>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(<?= $baseUrl ?>/assets/images/background/page-title-7.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ul class="bread-crumb clearfix mb_20">
                    <li><a href="<?= $baseUrl ?>/">Home</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li><a href="<?= $baseUrl ?>/blogs">Blogs</a></li>
                    <li>&nbsp;-&nbsp;</li>
                    <li><?= htmlspecialchars($blog['title']); ?></li>
                </ul>
            </nav>

            <!-- H1 -->
            <h1><?= htmlspecialchars($blog['title']); ?></h1>
        </div>
    </div>
</section>

<!-- Blog content -->
<section class="sidebar-page-container pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- MAIN CONTENT -->
            <article class="col-lg-8 col-md-12 col-sm-12 content-side"
                     itemscope itemtype="https://schema.org/BlogPosting">

                <div class="blog-details-content">
                    <div class="news-block-one">
                        <div class="inner-box">

                            <figure class="image-box">
                                <img src="<?= blog_image($blog['bg_image']); ?>"
                                     alt="<?= htmlspecialchars($blog['title']); ?>"
                                     itemprop="image">
                            </figure>

                            <div class="lower-content">
                                <ul class="info-list mb_15">
                                    <li>
                                        <time itemprop="datePublished"
                                              datetime="<?= date('Y-m-d', strtotime($blog['created_at'])); ?>">
                                            <?= date('F d, Y', strtotime($blog['created_at'])); ?>
                                        </time>
                                    </li>
                                    <li>|</li>
                                    <li itemprop="author">
                                        <?= htmlspecialchars($blog['author_name'] ?? 'Admin'); ?>
                                    </li>
                                </ul>

                                <div class="text" itemprop="articleBody">
                                    <?= $blog['content']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($blog['tags'])): ?>
                    <div class="post-share-option mb_60">
                        <div class="post-tags">
                            <h2>Related Tags</h2>
                            <ul class="tags-list clearfix">
                                <?php foreach (explode(',', $blog['tags']) as $tag): ?>
                                    <li>
                                        <a href="<?= $baseUrl ?>/blogs/tag/<?= urlencode(trim($tag)); ?>">
                                            <?= htmlspecialchars(trim($tag)); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- SIDEBAR -->
            <aside class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar default-sidebar">

                    <!-- Recent Posts -->
                    <div class="sidebar-widget post-widget mb_40">
                        <h3>Recent Posts</h3>
                        <div class="post-inner">
                            <?php while ($recent = mysqli_fetch_assoc($recent_result)): ?>
                                <div class="post">
                                    <figure class="post-thumb">
                                        <a href="<?= $baseUrl ?>/blog/<?= $recent['slug']; ?>">
                                            <img src="<?= blog_image($recent['bg_image']); ?>"
                                                 alt="<?= htmlspecialchars($recent['title']); ?>">
                                        </a>
                                    </figure>
                                    <h6>
                                        <a href="<?= $baseUrl ?>/blog/<?= $recent['slug']; ?>">
                                            <?= htmlspecialchars($recent['title']); ?>
                                        </a>
                                    </h6>
                                    <span class="post-date">
                                        <?= date('F d, Y', strtotime($recent['created_at'])); ?>
                                    </span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>