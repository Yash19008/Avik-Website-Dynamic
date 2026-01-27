<?php
$currentPage = basename($_SERVER['PHP_SELF']);
function isActive($page)
{
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="index.php" class="brand-link text-center">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?= isActive('index.php') ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Events -->
                <li class="nav-item">
                    <a href="manage-events.php" class="nav-link <?= isActive('manage-events.php') ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Events</p>
                    </a>
                </li>

                <!-- Works -->
                <li class="nav-item">
                    <a href="manage-works.php" class="nav-link <?= isActive('manage-works.php') ?>">
                        <i class="nav-icon fas fa-video"></i>
                        <p>Works</p>
                    </a>
                </li>

                <!-- Gallery -->
                <li class="nav-item">
                    <a href="manage-gallery.php" class="nav-link <?= isActive('manage-gallery.php') ?>">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Gallery</p>
                    </a>
                </li>

                <!-- Blog Categories -->
                <li class="nav-item">
                    <a href="manage-blog-categories.php" class="nav-link <?= isActive('manage-blog-categories.php') ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Blog Categories</p>
                    </a>
                </li>

                <!-- Blogs -->
                <li class="nav-item">
                    <a href="manage-blogs.php" class="nav-link <?= isActive('manage-blogs.php') ?>">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>Blogs</p>
                    </a>
                </li>

                <!-- Partners -->
                <li class="nav-item">
                    <a href="manage-partners.php" class="nav-link <?= isActive('manage-partners.php') ?>">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>Partners</p>
                    </a>
                </li>

                <!-- Contacts -->
                <li class="nav-item">
                    <a href="manage-contacts.php" class="nav-link <?= isActive('manage-contacts.php') ?>">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Contacts</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link"
                        onclick="return confirm('Are you sure you want to logout?')">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>