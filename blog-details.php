<?php
include './admin/inc/db.php';
include 'inc/header2.php';

$slug = $_GET['slug'] ?? '';

$query = "
    SELECT 
        blogs.*, 
        users.name AS author_name
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
    echo '<script>location.href="404.php"</script>';
    exit;
}

$recent_query = "SELECT slug, title, created_at, bg_image FROM blogs ORDER BY created_at DESC LIMIT 4";
$recent_result = mysqli_query($conn, $recent_query);

// Helper for image path
function blog_image($file)
{
    return './admin/uploads/blogs/' . basename($file);
}
?>

<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-7.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1><?php echo $blog['title']; ?></h1>
        </div>
    </div>
</section>

<section class="sidebar-page-container pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-details-content">
                    <div class="news-block-one">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="<?php echo blog_image($blog['bg_image']); ?>" alt="">
                            </figure>
                            <div class="lower-content">
                                <ul class="info-list mb_15">
                                    <li><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></li>
                                    <li>|</li>
                                    <li>by <?php echo htmlspecialchars($blog['author_name'] ?? 'Unknown'); ?></li>
                                </ul>

                                <div class="text">
                                    <?php echo $blog['content']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post-share-option mb_60">
                        <div class="post-tags">
                            <h2>Related Tags:</h2>
                            <ul class="tags-list clearfix">
                                <?php
                                if (!empty($blog['tags'])) {
                                    $tags = explode(',', $blog['tags']);
                                    foreach ($tags as $tag):
                                ?>
                                        <li><a href="#"><?php echo trim($tag); ?></a></li>
                                <?php endforeach;
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar default-sidebar">

                    <div class="sidebar-widget post-widget mb_40">
                        <div class="widget-title mb_30">
                            <h3>Recent Posts</h3>
                        </div>
                        <div class="post-inner">
                            <?php while ($recent = mysqli_fetch_assoc($recent_result)): ?>
                                <div class="post">
                                    <figure class="post-thumb">
                                        <a href="blog-details.php?slug=<?php echo $recent['slug']; ?>">
                                            <img src="<?php echo blog_image($recent['bg_image']); ?>" alt="">
                                        </a>
                                    </figure>
                                    <h6><a href="blog-details.php?slug=<?php echo $recent['slug']; ?>"><?php echo $recent['title']; ?></a></h6>
                                    <span class="post-date"><?php echo date('M d, Y', strtotime($recent['created_at'])); ?></span>
                                </div>
                            <?php endwhile; ?>
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

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>