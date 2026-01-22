<?php
include './admin/inc/db.php';
include 'inc/header2.php';
?>

<!-- page-title -->
<section class="page-title">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title-7.jpg);"></div>
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url(assets/images/shape/shape-36.png);"></div>
        <div class="pattern-2" style="background-image: url(assets/images/shape/shape-47.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb clearfix mb_20">
                <li><a href="index.php"># Home</a></li>
                <li>&nbsp;-&nbsp;</li>
                <li>Blogs</li>
            </ul>
            <h1>All Blogs</h1>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- sidebar-page-container -->
<section class="sidebar-page-container pt_140 pb_140">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-grid-content">
                    <div class="row clearfix">
                        <?php
                        // pagination
                        $limit  = 6;
                        $page   = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        // filters
                        $where = [];
                        $params = [];

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

                        // build WHERE clause
                        $whereSQL = '';
                        if (!empty($where)) {
                            $whereSQL = 'WHERE ' . implode(' AND ', $where);
                        }

                        // main blog query
                        $blogQuery = "
                                    SELECT 
                                        b.id,
                                        b.slug,
                                        b.title,
                                        b.content,
                                        b.bg_image,
                                        b.tags,
                                        b.added_by,
                                        b.created_at,
                                        c.name AS category_name,
                                        users.name AS author_name
                                    FROM blogs b
                                    LEFT JOIN blog_categories c ON c.id = b.cat_id
                                    LEFT JOIN users ON users.id = b.added_by
                                    $whereSQL
                                    ORDER BY b.created_at DESC
                                    LIMIT $limit OFFSET $offset
                                ";

                        $blogs = mysqli_query($conn, $blogQuery);

                        // total count (for pagination)
                        $countQuery = "
                            SELECT COUNT(*) 
                            FROM blogs b
                            $whereSQL
                        ";
                        $totalBlogs = mysqli_fetch_row(mysqli_query($conn, $countQuery))[0];
                        $totalPages = ceil($totalBlogs / $limit);

                        while ($blog = mysqli_fetch_assoc($blogs)) {
                        ?>

                            <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                                <div class="news-block-one">
                                    <div class="inner-box">
                                        <figure class="image-box">
                                            <a href="blog-details.php?slug=<?= $blog['slug']; ?>">
                                                <img src="./admin/<?= $blog['bg_image']; ?>" alt="">
                                            </a>
                                        </figure>
                                        <div class="lower-content">
                                            <ul class="info-list mb_15">
                                                <li><?= date('F d, Y', strtotime($blog['created_at'])); ?></li>
                                                <li>|</li>
                                                <li>by <?= htmlspecialchars($blog['author_name'] ?? 'Unknown'); ?></li>
                                            </ul>
                                            <h3>
                                                <a href="blog-details.php?slug=<?= $blog['slug']; ?>">
                                                    <?= $blog['title']; ?>
                                                </a>
                                            </h3>
                                            <p><?= substr(strip_tags($blog['content']), 0, 120); ?>...</p>
                                            <div class="link">
                                                <a href="blog-details.php?slug=<?= $blog['slug']; ?>">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="pagination-wrapper pt_20">
                        <ul class="pagination clearfix">
                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <li>
                                    <a href="?page=<?= $i; ?><?php
                                                                if (!empty($_GET['search'])) echo '&search=' . urlencode($_GET['search']);
                                                                if (!empty($_GET['tag'])) echo '&tag=' . urlencode($_GET['tag']);
                                                                if (!empty($_GET['category'])) echo '&category=' . (int)$_GET['category'];
                                                                ?>" class="<?= ($page == $i) ? 'current' : ''; ?>">
                                        <?= $i; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar default-sidebar">
                    <div class="sidebar-widget search-widget mb_40">
                        <h3>Recent Posts</h3>
                        <form method="get" action="" class="search-form">
                            <div class="form-group">
                                <input type="search" name="search" placeholder="Search"
                                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button type="submit">
                                    <img src="assets/images/icons/icon-17.png" alt="">
                                </button>
                            </div>
                        </form>
                    </div>
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
                    <div class="sidebar-widget tags-widget mb_40">
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
<!-- sidebar-page-container end -->


<?php
include 'inc/footer.php';
?>