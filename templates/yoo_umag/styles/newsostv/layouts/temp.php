<?php
$app = JFactory::getApplication();
$template_path   = JURI::base(true).'/templates/'.$app->getTemplate().'/';
?>
<!DOCTYPE html>
<html lang="<?php echo $this['config']->get('language'); ?>">
<head>
    <title>SOSTV</title>
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
    <!-- Favicons -->
    <link rel="shortcut icon" href="<?php echo $template_path; ?>/images/icons/favicon/favicon.png">
    <link rel="apple-touch-icon" href="<?php echo $template_path; ?>/images/icons/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $template_path; ?>/images/icons/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $template_path; ?>/images/icons/favicon/apple-touch-icon-114x114.png">

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
                        <li><a href="login.html">우리 소개</a></li>
                        <li><a href="register.html">자료주문</a></li>
                        <li><a href="">Donation</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- TOP ROW ENDS -->
        <!-- LOGO STARTS -->
        <div class="row">
            <div class="col-lg-12 logo">
                <?php if ($this['modules']->count('logo')) : ?>
                    <a  href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
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
                        <!-- Search Starts -->
                        <!--
                        <div class="nav-icon pull-right">
                            <input type="search" value="" name="" class="s" placeholder="Search...">
                        </div>
                        -->
                        <!-- Search Ends -->
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
    </nav>
    <!-- /. NAVIGATION ENDS
        ========================================================================= -->
    <!-- NEWS STARTS
        ========================================================================= -->
    <section class="breaking-news">
        <div class="row">
            <div class="col-lg-1 col-md-1">
                <h2 class="title">News</h2>
            </div>
            <div class="col-lg-11 col-md-11">
                <div class="newsticker">
                    <div><a href="#">Senectus et netus et malesuada Pellentesque habitant morbi senectus et netus et malesuada</a></div>
                    <div><a href="#">Pellentesque habitant morbi senectus et netus et malesuada</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- /. NEWS ENDS
        ========================================================================= -->
    <!-- SLIDER STARTS
        ========================================================================= -->
    <section>
        <div class="row slider">
            <!-- Slide 1 Starts -->
            <div>
                <!-- Column 1 Starts -->
                <div class="col-lg-8">
                    <div class="pic-with-overlay">
                        <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                        <div class="bg">&nbsp;</div>
                        <div><span class="category">LIFE STYLE</span></div>
                        <h1><a href="#">Pellentesque habitant morbi senectus et netus et malesuada</a></h1>
                        <div class="author">by Janny Doe</div>
                    </div>
                </div>
                <!-- Column 1 Ends -->
                <!-- Column 2 Starts -->
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pic-with-overlay-2">
                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                                <div class="bg">&nbsp;</div>
                                <div><span class="category">PHOTOGRAPHY</span></div>
                                <h1><a href="#">Netus et malesuada</a></h1>
                                <div class="author">by Janny Doe</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="pic-with-overlay-2">
                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                                <div class="bg">&nbsp;</div>
                                <div><span class="category">SPORTS</span></div>
                                <h1><a href="#">Morbi senectus</a></h1>
                                <div class="author">by Janny Doe</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column 2 Ends -->
            </div>
            <!-- Slide 1 Ends -->
            <!-- Slide 2 Starts -->
            <div>
                <!-- Column 1 Starts -->
                <div class="col-lg-8">
                    <div class="pic-with-overlay">
                        <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                        <div class="bg">&nbsp;</div>
                        <div><span class="category">FASHION 2014</span></div>
                        <h1><a href="#">Pellentesque habitant morbi senectus et netus et malesuada</a></h1>
                        <div class="author">by Janny Doe</div>
                    </div>
                </div>
                <!-- Column 1 Ends -->
                <!-- Column 2 Starts -->
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pic-with-overlay-2">
                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                                <div class="bg">&nbsp;</div>
                                <div><span class="category">CATWALK</span></div>
                                <h1><a href="#">Netus et malesuada</a></h1>
                                <div class="author">by Janny Doe</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="pic-with-overlay-2">
                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                                <div class="bg">&nbsp;</div>
                                <div><span class="category">TECH</span></div>
                                <h1><a href="#">Morbi senectus</a></h1>
                                <div class="author">by Janny Doe</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column 2 Ends -->
            </div>
            <!-- Slide 2 Ends -->
        </div>
    </section>
    <!-- /. SLIDER ENDS
        ========================================================================= -->
    <!-- PAGE CONTENTS STARTS
        ========================================================================= -->
    <section class="page-contents">
        <!-- EDITORIAL PICKS STARTS
            ========================================================================= -->
        <section class="editor-picks">
            <div class="row category-caption">
                <div class="col-lg-12">
                    <h2 class="pull-left">EDITOR'S PICKS</h2>
                    <span class="pull-right"><a href="editors-picks.html"><i class="fa fa-plus"></i></a></span>
                </div>
            </div>
            <div class="row">
                <!-- ARTICLE STARTS -->
                <article class="col-lg-3 col-md-6">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">FASHION</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Morbi tristique senectus et netus et</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">MORE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
                <!-- ARTICLE STARTS -->
                <article class="col-lg-3 col-md-6">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">SPORTS</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Habitant morbi tristique senectus et netus et</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">MORE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
                <!-- ARTICLE STARTS -->
                <article class="col-lg-3 col-md-6">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">PHOTOGRAPHY</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Pellentesque habitant morbi tristique senectus</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">MORE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
                <!-- ARTICLE STARTS -->
                <article class="col-lg-3 col-md-6">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">FOOD</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Pellentesque habitant morbi tristique senectus</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">MORE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
            </div>
        </section>
        <!-- /. EDITORIAL PICKS ENDS
            ========================================================================= -->
        <!-- LATEST ARTICLES STARTS
            ========================================================================= -->
        <section class="latest-articles">
            <div class="row category-caption">
                <div class="col-lg-12">
                    <h2 class="pull-left">LATEST ARTICLES</h2>
                    <span class="pull-right"><a href="latest-articles.html"><i class="fa fa-plus"></i></a></span>
                </div>
            </div>
            <div class="row">
                <!-- ARTICLE STARTS -->
                <article class="col-lg-4 col-md-4">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">FASHION</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Morbi tristique senectus et netus et</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">READ ARTICLE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
                <!-- ARTICLE STARTS -->
                <article class="col-lg-4 col-md-4">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">LIFE STYLE</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Habitant morbi tristique senectus et netus et</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">READ ARTICLE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
                <!-- ARTICLE STARTS -->
                <article class="col-lg-4 col-md-4">
                    <div class="picture">
                        <div class="category-image">
                            <img src="http://placehold.it/800x550" class="img-responsive" alt="" >
                            <h2 class="overlay-category">FASHION</h2>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="info">
                            <span class="date"><i class="fa fa-calendar-o"></i> 01/01/2015</span>
                            <span class="comments pull-right"><i class="fa fa-comment-o"></i> 750</span>
                            <span class="likes pull-right"><i class="fa fa-heart-o"></i> 500</span>
                        </div>
                        <div class="caption">Pellentesque habitant morbi tristique senectus</div>
                        <div class="author">
                            <div class="pic">
                                <img src="http://placehold.it/50x50" class="img-circle" alt="" > <span class="name"><a href="">JOHN DOE</a></span>
                                <span class="read-article pull-right"><a href="">READ ARTICLE <i class="fa fa-angle-right"></i></a></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- ARTICLE ENDS -->
            </div>
            <!-- PAGGING STARTS -->
            <!-- <div class="row pagging">
                 <div class="col-lg-12 col-md-12">
                     <ul class="pagination pagination-lg">
                         <li class="active"><a href="#">1</a></li>
                         <li><a href="#">2</a></li>
                         <li><a href="#">3</a></li>
                         <li><a href="#">4</a></li>
                         <li><a href="#">5</a></li>
                         <li>
                             <a href="#" aria-label="Next">
                                 <span aria-hidden="true">&raquo;</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </div> -->
            <!-- PAGGING ENDS -->
        </section>
        <!-- /. LATEST ARTICLES ENDS
            ========================================================================= -->
    </section>
    <!-- /. PAGE CONTENTS ENDS
        ========================================================================= -->
    <!-- FOOTER STARTS
        ========================================================================= -->
    <section class="footer">
        <!-- 2ND ROW STARTS -->
        <div class="row2 container-fluid">
            <div class="row">
                <!-- ABOUT MAG STARTS -->
                <div class="col-lg-8">
                    <div class="about">
                        <h3>About the Magazine</h3>
                        <div class="footer-logo"><img src="/images/logo.png" alt="" ></div>
                        <div class="introduction">SOSTV는 모든 그리스도인들과 비 그리스도인이 하나님의 말씀인 성경에 기록된 진리대로 생애 할 수 있도록 도와 줌으로써, 행복한 가정을 이루고, 건강한 삶을 누리며, 나아가서는 구원과 영생에 이를 수 있는 진리의 빛을 전하는 일을 하고 있습니다.</div>
                    </div>
                </div>
                <!-- ABOUT MAG ENDS -->
                <!-- CONTACT US STARTS -->
                <div class="col-lg-4">
                    <h3>Contact Us</h3>
                    <ul class="contactus">
                        <li><i class="fa fa-envelope-o"></i>미국: <a href="#"> (320) 500-1004<br/> sostvus@hotmail.com</a></li>
                        <li><i class="fa fa-envelope-o"></i>한국: <a href="#"> 1544-0091 <br/>sostvkr@hotmail.com</a></li>
                        <li><i class="fa fa-envelope-o"></i>뉴질랜드: <a href="#">0800-42-3004<br/>sostvnz@gmail.com</a></li>
                    </ul>
                    <!-- SOCIAL ICONS STARTS -->
                    <h3>Follow Us</h3>
                    <ul class="social-icons">
                        <li>
                            <div class="icon facebook"><i class="fa fa-facebook"></i></div>
                        </li>
                        <li>
                            <div class="icon twitter"><i class="fa fa-twitter"></i></div>
                        </li>
                        <li>
                            <div class="icon linkedin"><i class="fa fa-linkedin"></i></div>
                        </li>
                        <li>
                            <div class="icon dribbble"><i class="fa fa-dribbble"></i></div>
                        </li>
                        <li>
                            <div class="icon youtube"><i class="fa fa-youtube"></i></div>
                        </li>
                        <li>
                            <div class="icon behance"><i class="fa fa-behance"></i></div>
                        </li>
                    </ul>
                    <!-- SOCIAL ICONS ENDS -->
                </div>
                <!-- CONTACT US ENDS -->
            </div>
        </div>
        <!-- 2ND ROW ENDS -->
        <!-- 3RD ROW STARTS -->
        <div class="row3 container-fluid">
            <div class="row">
                <div class="col-lg-12 copyright">© Copyright <?php echo date('Y') ?> - SOSTV</div>
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
</body>
</html>