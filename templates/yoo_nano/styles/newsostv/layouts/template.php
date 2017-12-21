<?php
// get template configuration
include($this['path']->path('layouts:template.config.php'));
$app = JFactory::getApplication();
$menu = $app->getMenu();
?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

<head>
<?php echo $this['template']->render('head'); ?>
<script src="http://cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js"></script>
<script src="<?php echo JURI::base() ?>templates/yoo_nano/js/jquery-ui-1.8.20.custom.min.js"></script>
<script src="<?php echo JURI::base() ?>templates/yoo_nano/js/jquery.ThreeDots.min.js"></script>
<link rel="stylesheet" href="<?php echo JURI::base() ?>templates/yoo_nano/css/ui-lightness/jquery-ui-1.8.20.custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo JURI::base() ?>templates/yoo_nano/css/tabs.css" type="text/css" />
<!-- <link href='http://api.mobilis.co.kr/webfonts/css/?fontface=NanumGothicWeb' rel='stylesheet' type='text/css' /> -->
<script src="http://www.google.com/jsapi"></script>
<!--
<script>
 google.load( "webfont", "1" );
 google.setOnLoadCallback(function() {
  WebFont.load({ custom: {
   families: [ "NanumGothic" ],
   urls: [ "http://fontface.kr/NanumGothic/css" ]
  }});
 });
</script>
-->
<?php if ($menu->getActive() == $menu->getDefault()) : ?>
<script>
 jQuery(document).ready(function($) {
    $('#top-b').css("position","relative");
    $('#top-b').css("top","-20px");
 	$('#innertop').css("position","relative");
 	$('#innertop').css("top","-50px");
 	$('#bottom-b').css("position","relative");
 	$('#bottom-b').css("top","-110px");
 });
</script>
<?php endif; ?>
</head>

<body id="page" class="page <?php echo $this['config']->get('body_classes'); ?>" data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>
<div id="page-background"></div>

	<?php if ($this['modules']->count('absolute')) : ?>
	<div id="absolute">
		<?php echo $this['modules']->render('absolute'); ?>
	</div>
	<?php endif; ?>
	
	<div class="wrapper grid-block">

		<header id="header">

			<div id="headerbar" class="grid-block">
			
				<?php if ($this['modules']->count('logo')) : ?>	
				<a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
				<?php endif; ?>
				
				<?php if($this['modules']->count('headerbar')) : ?>
				<div class="left"><?php echo $this['modules']->render('headerbar'); ?></div>
				<?php endif; ?>
				
			</div>
<div id="toolbar" class="grid-block">

				<?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
				<div class="float-left">
				
				
					<?php echo $this['modules']->render('toolbar-l'); ?>
					
				</div>
				<?php endif; ?>
					
				<?php if ($this['modules']->count('toolbar-r') || $this['config']->get('date')) : ?>
				<div class="float-right">
									<?php if ($this['config']->get('date')) : ?>
					<time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
					<?php endif; ?><br />

				
				<?php echo $this['modules']->render('toolbar-r'); ?></div>
				<?php endif; ?>
				
			</div>
			<div id="menubar" class="grid-block">
				
				<?php  if ($this['modules']->count('menu')) : ?>
				<nav id="menu"><?php echo $this['modules']->render('menu'); ?></nav>
				<?php endif; ?>

				<?php if ($this['modules']->count('search')) : ?>
				<div id="search"><?php echo $this['modules']->render('search'); ?></div>
				<?php endif; ?>
				
			</div>
		
			<?php if ($this['modules']->count('banner')) : ?>
			<div id="banner"><?php echo $this['modules']->render('banner'); ?></div>
			<?php endif;  ?>
		
		</header>

		<?php if ($this['modules']->count('top-a')) : ?>
		<section id="top-a"><div class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></div></section>
		<?php endif; ?>
		
		<?php if ($this['modules']->count('top-b')) : ?>
		<section id="top-b"><div class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></div></section>
		<?php endif; ?>
		
		<?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
		<div id="main" class="grid-block">

			<div id="maininner" class="grid-box">

				<?php if ($this['modules']->count('innertop')) : ?>
				<section id="innertop"><div class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></div>
				    <!-- Quick way to position this special case -->
					<div style="position:absolute; top:69px; right: 1px; width: 268px">
				<?php echo $this['modules']->render('innertop-split', array('layout'=>$this['config']->get('innertop-split'))); ?>
				</div>
				</section>
				<?php endif; ?>

				<?php if ($this['modules']->count('breadcrumbs')) : ?>
				<section id="breadcrumbs"><?php echo $this['modules']->render('breadcrumbs'); ?></section>
				<?php endif; ?>

				<?php if ($this['config']->get('system_output')) : ?>
				<section id="content" class="grid-block"><?php echo $this['template']->render('content'); ?></section>
				<?php endif; ?>

				<?php if ($this['modules']->count('innerbottom')) : ?>
				<section id="innerbottom"><div class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></div></section>
				<?php endif; ?>

			</div>
			<!-- maininner end -->
			
			<?php if ($this['modules']->count('sidebar-a')) : ?>
			<aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?><div class="sidebar-bg"></div></aside>
			<?php endif; ?>
			
			<?php if ($this['modules']->count('sidebar-b')) : ?>
			<aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?><div class="sidebar-bg"></div></aside>
			<?php endif; ?>

		</div>
		<?php endif; ?>
		<!-- main end -->

		<?php if ($this['modules']->count('bottom-a')) : ?>
		<section id="bottom-a"><div class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></div></section>
		<?php endif; ?>
		
		<?php if ($this['modules']->count('bottom-b')) : ?>
		<section id="bottom-b"><div class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></div></section>
		<?php endif; ?>
		
		<?php if ($this['modules']->count('footer + debug') || $this['config']->get('warp_branding')) : ?>
		<footer id="footer" class="grid-block">

			<?php if ($this['config']->get('totop_scroller')) : ?>
			<a id="totop-scroller" href="#page"></a>
			<?php endif; ?>
			
			<?php
				echo $this['modules']->render('footer');
				$this->output('warp_branding');
				echo $this['modules']->render('debug');
			?>

		</footer>
		<?php endif; ?>

	</div>
	
	<?php echo $this->render('footer'); ?>
	
</body>
</html>
