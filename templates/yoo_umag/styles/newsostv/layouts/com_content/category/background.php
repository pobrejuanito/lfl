<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

?>

	<script>
			jQuery(document).ready(function($) 
			{
			
			
				$('a[id^="wallpaper"]').click(function(event) { 
					//console.info(this);
					var title = $(this).attr('title');
					var dim_width =$(this).attr('dim_width');
					var dim_height = $(this).attr('dim_height');
					var img_url = $(this).attr('link');
					
					var box_width = parseInt(dim_width)/2;
					var box_height = parseInt( dim_height)/2;
					
					var img_width = parseInt(dim_width)/2;
					var img_height = parseInt(dim_height)/2;
													
					$('.background-box').css('width',box_width);
					$('.background-box').css('height', box_height);
					
					$('.background-box').center();
					
					
					$('.background-box').html('<div class="box-header"><div><a href="#" class="background-home" > </a></div><span class="background-title">'+ title+ '</span><br />바탕화면 설정방법 : <span class="background-font-yellow">그림위에 마우스 오른쪽 버튼 클릭 > 배경으로 지정 (맥OS : 이미지를 데스크탑 사진으로 사용)</span> <br /> 실제사이즈 :<span class="background-font-yellow">'+dim_width+ ' x ' +dim_height +'</span></div>'+'<div class="background-img"><img src="'+ img_url+ '" title="'+ title+'" width="'+img_width+'" height="'+img_height+'" /></div>');
									 $('.background-home').click(function() 
				 { 
				 	//console.info('click');
					close_box(); 
				 });


					
					
								$('.backdrop, .background-box').animate({'opacity': '.50'}, 300, 'linear');
								$('.background-box').animate({'opacity' : '1.00'}, 300, 'linear');
								$('.backdrop, .background-box').css('display', 'block');				
				 });
				 
				 $('.close').click(function(){
				 		close_box();
				 });
				 $('.backdrop').click(function() { 
				 		close_box();
				  });
			function close_box()
			{
				$('.backdrop, .background-box').animate({'opacity' : '0'}, 300, 'linear', function() { 
				 			$('.backdrop, .background-box').css('display', 'none');
				 	 });
			}
			
			jQuery.fn.center = function () 
			{
				this.css("position", "absolute");
				this.css("top", (($(window).height() - this.outerHeight()) /2) + $(window).scrollTop() + "px");
				this.css("left", (($(window).width() - this.outerWidth()) / 2) +  $(window).scrollLeft() + "px");
				
				return this;
			
			}
			});
	

	</script>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4fcfcc0c7b57665d"></script>

<div id="system">

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>

	<?php if ($this->params->get('page_subheading')) : ?>
	<h2 class="subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?></h2>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1)) : ?>
	<h1 class="title"><?php echo $this->category->title;?></h1>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) :?>
	<div class="description">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo $this->category->getParams()->get('image'); ?>" class="size-auto align-right" />
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
	</div>
	<?php endif; ?>

	<?php
	
	// init vars
	$articles = '';
	
	// leading articles
	foreach ($this->lead_items as $item) {
		$this->item = $item;
		$articles  .= '<div class="grid-box width100 leading">'.$this->loadTemplate('item').'</div>';
	}
	
	// intro articles
	$columns = array();
	$i       = 0;

	foreach ($this->intro_items as $item) {
		$column = $i++ % $this->params->get('num_columns', 2);

		if (!isset($columns[$column])) {
			$columns[$column] = '';
		}

		$this->item = $item;
		$columns[$column] .= $this->loadTemplate('item');
	}
	
	// render intro columns
	if ($count = count($columns)) {
		for ($i = 0; $i < $count; $i++) {
			$articles .= '<div class="grid-box width'.intval(100 / $count).'">'.$columns[$i].'</div>';
		}
	}

	if ($articles) {
	echo '<div class="items items-col-'.$count.' grid-block">'.$articles.'</div>';
	}
	
	?>

	<?php if (!empty($this->link_items)) : ?>
	<div class="item-list">
		<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
		<ul>
			<?php foreach ($this->link_items as &$item) : ?>
			<li>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>"><?php echo $item->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<?php echo $this->pagination->getPagesLinks(); ?>
	<?php endif; ?>

</div>

<div class="backdrop"></div>
<div class="background-box"><div class="close">X</div></div>