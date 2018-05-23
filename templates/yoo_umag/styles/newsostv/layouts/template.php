<?php
$app = JFactory::getApplication();
$template_path   = JURI::base(true).'/templates/'.$app->getTemplate().'/';
?>
<!DOCTYPE html>
<html lang="<?php echo $this['config']->get('language'); ?>">
<head>
    <?php echo $this['template']->render('head'); ?>
    <!-- All Stylesheets -->
    <link href="<?php echo $template_path; ?>css/all-stylesheets.css" rel="stylesheet">
    <!-- Header & Nav Center Align -->
    <link href="<?php echo $template_path; ?>css/header-center-align.css" rel="stylesheet">
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
            if (typeof Cookies.get('hide-notice') !== 'undefined') {
                $("#notice").remove();
            } else {
                $('#noticeModal').modal("show");
            }

            $(".ok").click(function() {
                Cookies.set('hide-notice', true);
            });
        });
    </script>
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
    <!-- /. PAGE CONTENTS ENDS ========================================================================= -->
    <!-- FOOTER STARTS  ========================================================================= -->
    <section class="footer">
        <div class="container-fluid">
            <div class="row" style="background-color: #F9F9F9;">
                <!-- FEATURED POSTS STARTS -->
                <div class="col-lg-6">
                    <h2><i class="fa fa-paper-plane-o" aria-hidden="true" style="color: #e4545b;"></i> SOSTV 메일링서비스</h2>
                    <p style="font-size: larger">여러분의 EMAIL로 생애의 빛이 찾아갑니다!</p>
                    <p style="font-size: larger">
                        생애의 빛에서 발송되는 EMAIL 수신을 원하거나 주변 분들에게 보내기를 원하신다면 newsletter@sostv.net 으로 연락주세요!
                    </p>
                </div>
                <div class="col-lg-6">
                    <!-- Begin MailChimp Signup Form -->
                    <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
                    <style type="text/css">
                        #mc_embed_signup{ clear:left; }
                        #mc_embed_signup h2 {
                            font-size: 28px;
                            font-weight: normal;
                        }
                        #mc_embed_signup .button {
                            color: #e4545b;
                            background-color: #fff;
                            border: 2px solid #e4545b;
                            line-height: 10px;
                        }
                        #mc_embed_signup .button:hover {
                            background-color: #e4545b;
                            color: #FFFFFF;
                            line-height: 10px;
                        }
                        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                    </style>
                    <div id="mc_embed_signup">
                        <form action="https://sostv.us17.list-manage.com/subscribe/post?u=d2506594c35f43c6050854095&amp;id=5f352fac06" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">

                                <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                                <div class="mc-field-group">
                                    <label for="mce-EMAIL">EMAIL 주소  <span class="asterisk">*</span>
                                    </label>
                                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                                </div>
                                <div id="mce-responses" class="clear">
                                    <div class="response" id="mce-error-response" style="display:none"></div>
                                    <div class="response" id="mce-success-response" style="display:none"></div>
                                </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d2506594c35f43c6050854095_5f352fac06" tabindex="-1" value=""></div>
                                <div class="clear"><input type="submit" value="구독신청" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                            </div>
                        </form>
                    </div>
                    <!--End mc_embed_signup-->
                </div>
                <!-- FEATURED POSTS ENDS -->
            </div>
        </div>
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
                        <li><i class="fa fa-building-o"></i>
                           미국: P.O. Box 787 Commerce, GA 30529 U.S.A <br />
                           전화: <a href="tel:(320) 500-1004">(888) 439-4301</a> Email: sostvus@hotmail.com
                        </li>
                        <li><i class="fa fa-building-o"></i>
                           한국: 전화 1670-9974 <br/>Email: sostv119@naver.com
                        </li>
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
<!-- Modal -->
<?php echo $this['modules']->render('bootstrap-modal-alert'); ?>
</body>
</html>