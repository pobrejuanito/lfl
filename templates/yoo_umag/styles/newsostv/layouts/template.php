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
    <script src="<?php echo $template_path; ?>owl-carousel/owl-carousel/owl.carousel.js"></script>
    <!-- Retina -->
    <script src="<?php echo $template_path; ?>js/retina/retina.js"></script>
    <!-- FitVids -->
    <script src="<?php echo $template_path; ?>js/fitvids/jquery.fitvids.js"></script>
    <!-- Custom -->
    <script src="<?php echo $template_path; ?>js/custom/custom.js"></script>
    <script src="<?php echo $template_path; ?>js/jscookie.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111650938-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-111650938-1');

        jQuery(document).ready(function($) {
            if (typeof Cookies.get('hide-div') !== 'undefined') {
                $("#notice").remove();
            }

            $(".close").click(function() {
                $("#notice").remove();
                Cookies.set('hide-div', true);
            });
        });
    </script>
</head>
<body>
<div class="container content-bg">
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div id="notice" class="alert alert-warning fade in"  style="margin-top: 15px;">
                <strong>공지사항</strong><a href="#" class="close" data-dismiss="alert">&times;</a>
                <p>새롭게 개편된 생애의 빛 웹사이트를 찾아오신 여러분을 환영합니다. 중요한 공지사항을 한 가지 알려드립니다.
                생애의 빛은 지난 몇 년간 생애의 빛 한국 지부를 맡아 일하던 손계문 목사가 새롭게 시작한 11시 교회(11th hour network) 와 공식적으로 분리 되었음을 공지 합니다.
                공식적인 분리의 이유는, 손계문 목사의 가르침과 성경의 해석 및 적용이 그동안 생애의 빛이 가르치고 전해오던 기존의 가르침과 달라졌기 때문입니다.
                또한 손계문 목사의 11시 교회의 선교의 방향과 목적이 생애의 빛 독립 선교기관의 설립 취지와 목적에 일치하지 않으므로 분리하게 되었음을 알려드립니다.
                    </p>
                </div>
            </div>
        </div>
    </section>
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
                <div class="col-lg-12 copyright">© Copyright <?php echo date('Y') ?> - 생애의 빛 - Light for Life Ministry All Rights Reserved</div>
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