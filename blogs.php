<?php
include './admin/inc/db.php';

/* ================= SEO META ================= */
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

$title = "Blogs & News | Worldwide Events and Conference";
$meta_desc = "Read the latest blogs, news, and insights on corporate events, weddings, conferences, and event planning by Worldwide Events and Conference.";

if (!empty($_GET['tag'])) {
    $title = "Blogs tagged '" . htmlspecialchars($_GET['tag']) . "' | Worldwide Events";
    $seoDescription = "Articles and insights related to " . htmlspecialchars($_GET['tag']) . ".";
}

if (!empty($_GET['category'])) {
    $title = "Blog Category | Worldwide Events";
}

if ($page > 1) {
    $title .= " – Page " . $page;
}

include 'inc/header2.php';
?>

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
                    <li>Blogs</li>
                </ul>
            </nav>

            <h1>Blogs & Latest News</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- sidebar-page-container -->
<section class="sidebar-page-container pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- BLOG LIST -->
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-grid-content">
                    <div class="row clearfix">

                        <?php
                        /* ============ Pagination ============ */
                        $limit  = 6;
                        $offset = ($page - 1) * $limit;

                        $where = [];

                        if (!empty($_GET['search'])) {
                            $search = mysqli_real_escape_string($conn, $_GET['search']);
                            $where[] = "(b.title LIKE '%$search%' OR b.content LIKE '%$search%')";
                        }

                        if (!empty($_GET['tag'])) {
                            $tag = mysqli_real_escape_string($conn, $_GET['tag']);
                            $where[] = "b.tags LIKE '%$tag%'";
                        }

                        if (!empty($_GET['category'])) {
                            $category = (int)$_GET['category'];
                            $where[] = "b.cat_id = $category";
                        }

                        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

                        $blogQuery = "
                            SELECT b.slug, b.title, b.content, b.bg_image, b.created_at,
                                   users.name AS author_name
                            FROM blogs b
                            LEFT JOIN users ON users.id = b.added_by
                            $whereSQL
                            ORDER BY b.created_at DESC
                            LIMIT $limit OFFSET $offset
                        ";

                        $blogs = mysqli_query($conn, $blogQuery);

                        while ($blog = mysqli_fetch_assoc($blogs)) {
                        ?>
                        <article class="col-lg-6 col-md-6 col-sm-12 news-block"
                                 itemscope itemtype="https://schema.org/BlogPosting">

                            <div class="news-block-one">
                                <div class="inner-box">

                                    <figure class="image-box">
                                        <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>" itemprop="url">
                                            <img src="<?= $baseUrl ?>/admin/<?= $blog['bg_image']; ?>"
                                                 alt="<?= htmlspecialchars($blog['title']); ?>"
                                                 itemprop="image">
                                        </a>
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
                                            <li itemprop="author"><?= htmlspecialchars($blog['author_name'] ?? 'Admin'); ?></li>
                                        </ul>

                                        <h2 itemprop="headline">
                                            <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>">
                                                <?= htmlspecialchars($blog['title']); ?>
                                            </a>
                                        </h2>

                                        <p itemprop="description">
                                            <?= substr(strip_tags($blog['content']), 0, 140); ?>…
                                        </p>
                                        <div class="link">
                                            <a href="<?= $baseUrl ?>/blog/<?= $blog['slug']; ?>" class="read-more">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php } ?>
                    </div>

                    <!-- Pagination -->
                    <?php
                    $countQuery = "SELECT COUNT(*) FROM blogs b $whereSQL";
                    $totalBlogs = mysqli_fetch_row(mysqli_query($conn, $countQuery))[0];
                    $totalPages = ceil($totalBlogs / $limit);
                    ?>

                    <?php if ($totalPages > 1): ?>
                    <nav class="pagination-wrapper pt_20" aria-label="Pagination">
                        <ul class="pagination clearfix">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li>
                                    <a href="<?= $baseUrl ?>/blogs/page/<?= $i; ?>"
                                       class="<?= ($page == $i) ? 'current' : ''; ?>">
                                        <?= $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>

                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar default-sidebar">

                    <!-- Search -->
                    <div class="sidebar-widget search-widget mb_40">
                        <h3>Search Blogs</h3>
                        
                        <form method="get" action="<?= $baseUrl ?>/blogs" class="search-form">
                            <div class="form-group">
                                <input type="search" name="search" placeholder="Search articles">
                                <button type="submit">
                                    <img src="<?= $baseUrl ?>/assets/images/icons/icon-17.png" alt="">
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
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
                                        <a href="<?= $baseUrl ?>/blogs/category/<?= $cat['id']; ?>">
                                            <?= htmlspecialchars($cat['name']); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar-widget tags-widget">
                        <div class="widget-title mb_30">
                            <h3>Tags</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="tags-list clearfix">
                                <?php foreach ($tagsArray ?? [] as $tag): ?>
                                    <li>
                                        <a href="<?= $baseUrl ?>/blogs/tag/<?= urlencode($tag); ?>">
                                            <?= htmlspecialchars($tag); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>