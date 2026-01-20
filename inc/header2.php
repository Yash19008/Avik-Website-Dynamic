<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title><?= $title ?? 'Worldwide Events and Conference' ?></title>

    <!-- Fav Icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="assets/css/font-awesome-all.css" rel="stylesheet">
    <link href="assets/css/flaticon.css" rel="stylesheet">
    <link href="assets/css/owl.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/nice-select.css" rel="stylesheet">
    <link href="assets/css/elpath.css" rel="stylesheet">
    <link href="assets/css/color.css" id="jssDefault" rel="stylesheet">
    <link href="assets/css/rtl.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/module-css/page-title.css" rel="stylesheet">
    <link href="assets/css/module-css/about.css" rel="stylesheet">
    <link href="assets/css/module-css/mission.css" rel="stylesheet">
    <link href="assets/css/module-css/team.css" rel="stylesheet">
    <link href="assets/css/module-css/pricing.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="assets/css/module-css/page-title.css" rel="stylesheet">
<link href="assets/css/module-css/event.css" rel="stylesheet">
<link href="assets/css/module-css/cta.css" rel="stylesheet">
<link href="assets/css/module-css/news.css" rel="stylesheet">
<link href="assets/css/module-css/blog-details.css" rel="stylesheet">
<link href="assets/css/module-css/sidebar.css" rel="stylesheet">

</head>


<!-- page wrapper -->

<body>

    <div class="boxed_wrapper ltr">


        <!-- preloader -->
          <div class="loader-wrap">
            <div class="preloader">
                <div class="preloader-close">close</div>
                <div id="handle-preloader" class="handle-preloader">
                    <div class="animation-preloader">
                        <div class="spinner"></div>
                        <div class="txt-loading">
                            <span data-text-preloader="W" class="letters-loading">
                                W
                            </span>
                            <span data-text-preloader="W" class="letters-loading">
                                W
                            </span>
                            <span data-text-preloader="E" class="letters-loading">
                                E
                            </span>
                            <span data-text-preloader="&" class="letters-loading">
                                &
                            </span>
                            <span data-text-preloader="C" class="letters-loading">
                                C
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- preloader end -->
        <!-- main header -->
        <header class="main-header header-style-two">
            <!-- header-lower -->
            <div class="header-lower">
                <div class="auto-container">
                    <div class="outer-box">
                        <figure class="logo-box"><a href="index.php"><img src="assets/images/logopp.png" alt=""></a></figure>
                        <div class="menu-area">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler">
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                            </div>
                            <nav class="main-menu navbar-expand-md navbar-light clearfix">
                               <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li class="current"><a href="index.php">Home</a></li>
                                        <li><a href="about-us.php">About Us</a></li>
                                        <li><a href="events.php">Events</a></li>
                                        <li><a href="gallery.php">Gallery</a></li>
                                        <li><a href="blogs.php">Blogs</a></li>
                                        <li><a href="contact-us.php">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="support-box">
                                <div class="icon-box"><i class="icon-1"></i></div>
                                <a href="tel:+917583936109">75839 36109</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--sticky Header-->
            <div class="sticky-header">
                <div class="auto-container">
                    <div class="outer-box">
                        <div class="logo-box">
                            <figure class="logo"><a href="index.php"><img src="assets/images/logopp.png" alt=""></a></figure>
                        </div>
                        <div class="menu-area">
                            <nav class="main-menu clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="support-box">
                                <div class="icon-box"><i class="icon-1"></i></div>
                                <a href="tel:+917583936109">75839 36109</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- main-header end -->


        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><i class="fas fa-times"></i></div>

            <nav class="menu-box">
                <div class="nav-logo"><a href="index.php"><img src="assets/images/logo-2.png" alt="" title=""></a></div>
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <div class="contact-info">
                    <h4>Contact Info</h4>
                    <ul>
                        <li>Chicago 12, Melborne City, USA</li>
                        <li><a href="tel:+8801682648101">+88 01682648101</a></li>
                        <li><a href="mailto:info@example.com">info@example.com</a></li>
                    </ul>
                </div>
                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="index.php"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="index.php"><span class="fab fa-facebook-square"></span></a></li>
                        <li><a href="index.php"><span class="fab fa-pinterest-p"></span></a></li>
                        <li><a href="index.php"><span class="fab fa-instagram"></span></a></li>
                        <li><a href="index.php"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </nav>
        </div><!-- End Mobile Menu -->