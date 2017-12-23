<?php
$app = JFactory::getApplication();
$template_path   = JURI::base(true).'/templates/'.$app->getTemplate().'/';
?>
<!DOCTYPE html>
<html lang="<?php echo $this['config']->get('language'); ?>">
<head>
    <?php echo $this['template']->render('head'); ?>
    <!-- All Stylesheets -->
    <link href="<?php echo $template_path; ?>/css/all-stylesheets.css" rel="stylesheet">
    <!-- Header & Nav Center Align -->
    <link href="<?php echo $template_path; ?>/css/header-center-align.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- /. TO TOP ENDS
        ========================================================================= -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $template_path; ?>js/jquery-1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $template_path; ?>js/bootstrap/bootstrap.min.js"></script>
    <!-- Hover Dropdown Menu -->
    <script src="<?php echo $template_path; ?>js/bootstrap-hover/twitter-bootstrap-hover-dropdown.min.js"></script>
    <!-- Sidr JS Menu -->
    <script src="<?php echo $template_path; ?>js/sidr/jquery.sidr.min.js"></script>
    <!-- Owl Carousel -->
    <script type="text/javascript" src="<?php echo $template_path; ?>owl-carousel/owl-carousel/owl.carousel.js"></script>
    <!-- AJAX Contact Form -->
    <script type="text/javascript" src="<?php echo $template_path; ?>js/contact/contact-form.js"></script>
    <!-- Retina -->
    <script type="text/javascript" src="<?php echo $template_path; ?>js/retina/retina.js"></script>
    <!-- FitVids -->
    <script type="text/javascript" src="<?php echo $template_path; ?>js/fitvids/jquery.fitvids.js"></script>
    <!-- Custom -->
    <script type="text/javascript" src="<?php echo $template_path; ?>js/custom/custom.js"></script>
</head>
<body>
<div class="container content-bg">
    <!-- HEADER STARTS
        ========================================================================= -->
    <header>
        <!-- TOP ROW STARTS -->
        <div class="top-nav hidden-sm hidden-xs">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div id="date"></div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <ul class="small-nav">
                        <li><a href="/about-us.html">우리 소개</a></li>
                        <li><a href="/donation.html">Donation</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- TOP ROW ENDS -->
        <!-- LOGO STARTS -->
        <div class="row">
            <div class="col-lg-12 logo">
                <?php if ($this['modules']->count('logo')) : ?>
                    <?php echo $this['modules']->render('logo'); ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- LOGO ENDS -->
    </header>
    <!-- /. HEADER ENDS
        ========================================================================= -->
    <!-- MOBILE MENU BUTTON STARTS
        ========================================================================= -->
    <div id="mobile-header">
        <a id="responsive-menu-button" href="#sidr-main"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></a>
    </div>
    <!-- /. MOBILE MENU BUTTON ENDS
        ========================================================================= -->
    <!-- NAVIGATION STARTS
        ========================================================================= -->
    <nav id="navigation">
        <div class="navbar yamm navbar-inverse" role="navigation">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" > <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                    <div class="collapse navbar-collapse">
                        <?php  if ($this['modules']->count('menu')) : ?>
                            <?php echo $this['modules']->render('menu'); ?>
                        <?php endif; ?>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
    </nav>
    <!-- /. NAVIGATION ENDS
    <!-- PAGE CONTENTS STARTS
        ========================================================================= -->
    <?php if ($this['modules']->count('main-slide1')) : ?>
    <section>
        <div class="row slider">
            <div>
                <?php echo $this['modules']->render('main-slide1', array('layout'=>$this['config']->get('main-slide1'))); ?>
                <!-- Column 2 Starts -->
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pic-with-overlay-2">
                                <a href="about.html"><img src="/images/newsite/aboutus.jpg" class="img-responsive" alt="" ></a>
                            </div>
                        </div>
                        <div class="col-lg-12"><a href="index.php/mag/2010-05-25-14-59-33/survivors201-250.html">
                            <div class="pic-with-overlay-2">
                                <img src="/images/newsite/featured_magazine.jpg" class="img-responsive" alt="" >
                                <div class="bg">&nbsp;</div>
                                <div><span class="category">SOSTV 매거진</span></div>
                                <h1><a href=index.php/mag/2010-05-25-14-59-33/survivors201-250.html">SOSTV 매거진</a></h1>
                                <div class="author">Truth for Today </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="inner-page-contents">
        <section class="category">
            <div class="row category-caption">
                <div class="col-lg-12">
                </div>
            </div>
            <div class="row">
                <!-- ARTICLE STARTS -->
                <?php echo $this['modules']->render('front-left-module'); ?>
                <?php echo $this['modules']->render('front-right-module'); ?>
                <!-- ARTICLE ENDS -->
            </div>
        </section>
    <?php endif; ?>
    <?php
        $has_sides = false;
        if ( $this['modules']->count('responsive-side-a-video') > 0 ) {
            $has_sides = true;
        }
    ?>
    <?php if ($this['config']->get('system_output')) : ?>

            <div class="row">
                <div class="col-lg-<?php echo ($has_sides)? 8: 12; ?>">
                    <section>
                        <div class="row">
                            <article class="col-lg-12 col-md-12">
                                <?php echo $this['template']->render('content'); ?>
                            </article>
                        </div>
                    </section>
                </div>
                <?php if ( $has_sides ) : ?>
                    <div class="col-lg-4">
                        <?php echo $this['modules']->render('responsive-side-a-video'); ?>
                    </div>
                <?php endif; ?>
            </div>

    <?php endif; ?>
    </section>
    <!-- /. PAGE CONTENTS ENDS
        ========================================================================= -->
    <!-- FOOTER STARTS
        ========================================================================= -->
    <section class="footer">
        <!-- 3RD ROW STARTS -->
        <div class="row3 container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h3>SOSTV 네트워크</h3>
                    <ul class="social-icons">
                        <li>
                            <a href="https://www.facebook.com/soslive.tv" target="_blank"><img src="<?php echo $template_path; ?>images/socialicons/facebook.png" class="icon"></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/sostvusa/" target="_blank"><img src="<?php echo $template_path; ?>images/socialicons/instagram.png" class="icon"></a>
                        </li>
                        <li>
                            <a href="https://story.kakao.com/sostvus" target="_blank"><img src="<?php echo $template_path; ?>images/socialicons/kakao.png" class="icon"></a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/channel/UCXtFSRtDJUhOywGJmSYAQTg" target="_blank">
                                <img src="<?php echo $template_path; ?>images/socialicons/youtube.png" class="icon"></a>
                        </li>
                        <li>
                            <a href="http://finalg.sostvnetwork.com" target="_blank">
                                <img src="<?php echo $template_path; ?>images/socialicons/finalg.png" class="icon" >
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <h3>SOSTV Ministry</h3>
                    <ul class="contactus">
                        <li><i class="fa fa-building-o"></i> 미국: P. O. Box 787 Commerce, GA 30529 U.S.A</li>
                        <li><i class="fa fa-phone"></i><a href="tel:(320) 500-1004">(888) 439-4301</a></li>
                        <li><i class="fa fa-envelope-o"></i>sostvus@hotmail.com</li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="row3 container-fluid" style="background-color: #292929;">
            <div class="row">
                <div class="col-lg-12 copyright">© Copyright <?php echo date('Y') ?> - SOSTV All Rights Reserved</div>
            </div>
        </div>

        <!-- 3RD ROW ENDS -->
    </section>
    <!-- /. FOOTER ENDS
        ========================================================================= -->
</div>
<!-- TO TOP STARTS
    ========================================================================= -->
<a href="#" class="scrollup">Scroll</a>

</body>
</html>