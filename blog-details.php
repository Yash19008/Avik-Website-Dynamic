<?php
include './admin/inc/db.php';
include 'inc/header2.php';

// 1. Get ID and fetch the specific blog post
$id = (int)($_GET['id'] ?? 0);
$query = "SELECT * FROM blogs WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    die("Blog post not found.");
}

// 2. Fetch Recent Posts for Sidebar
$recent_query = "SELECT id, title, created_at, bg_image FROM blogs ORDER BY created_at DESC LIMIT 3";
$recent_result = mysqli_query($conn, $recent_query);

// 3. Fetch Categories for Sidebar (Assuming you have a categories table)
// If you don't have a table, we'll fetch unique cat_ids from the blogs table
$cat_query = "SELECT DISTINCT cat_id FROM blogs";
$cat_result = mysqli_query($conn, $cat_query);

// Helper for image path
function blog_image($file) {
    return 'admin/uploads/blogs/' . basename($file);
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
                                    <li>by <?php echo $blog['added_by']; ?></li>
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
                                $tags = explode(',', $blog['tags']); 
                                foreach($tags as $tag): 
                                ?>
                                    <li><a href="#"><?php echo trim($tag); ?></a></li>
                                <?php endforeach; ?>
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
                            <?php while($recent = mysqli_fetch_assoc($recent_result)): ?>
                            <div class="post">
                                <figure class="post-thumb">
                                    <a href="blog-details.php?id=<?php echo $recent['id']; ?>">
                                        <img src="<?php echo blog_image($recent['bg_image']); ?>" alt="">
                                    </a>
                                </figure>
                                <h6><a href="blog-details.php?id=<?php echo $recent['id']; ?>"><?php echo $recent['title']; ?></a></h6>
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
                                <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                                    <li><a href="#"><?php echo $cat['cat_id']; ?><i class="icon-25"></i></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>