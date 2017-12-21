<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

// Create a shortcut for params.
$params		= &$this->item->params;
$images		= json_decode($this->item->images);
$canEdit	= $this->item->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::core();

?>

<article class="wallpaper item" data-permalink="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid), true, -1); ?>">
<div class="wallpaper_box">
	<?php
	
		if (!$params->get('show_intro')) {
			echo $this->item->event->afterDisplayTitle;
		}
	
		echo $this->item->event->beforeDisplayContent;

	?>

	<div class="content clearfix">
		<?php
		
			if (isset($images->image_intro) and !empty($images->image_intro)) {
				$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro;
				$class = (htmlspecialchars($imgfloat) != 'none') ? ' class="size-auto align-'.htmlspecialchars($imgfloat).'"' : ' class="size-auto"';
				$title = ($images->image_intro_caption) ? ' title="'.htmlspecialchars($images->image_intro_caption).'"' : '';
				echo '<img'.$class.$title.' src="'.htmlspecialchars($images->image_intro).'" alt="'.htmlspecialchars($images->image_intro_alt).'" />';
			}
			
		echo $this->item->introtext;
		
		?>
	</div>

	<?php if ($params->get('show_readmore') && $this->item->readmore) : ?>
	<p class="links">
	
		<?php
		
			if ($params->get('access-view')) {
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
			} else {
				$menu = JFactory::getApplication()->getMenu();
				$active = $menu->getActive();
				$itemId = $active->id;
				$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
				$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
				$link = new JURI($link1);
				$link->setVar('return', base64_encode($returnURL));
			}
			
		?>

		<a href="<?php echo $link; ?>" title="<?php echo $this->escape($this->item->title); ?>">
			<?php
				
				if (!$params->get('access-view')) {
					echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
				} elseif ($readmore = $this->item->alternative_readmore) {
					echo $readmore;
				} else {
					echo JText::_('TPL_WARP_CONTINUE_READING');
				}
				
			?>
		</a>
		
	</p>
	<?php endif; ?>

	<?php if ($canEdit) : ?>
	<p class="edit"><?php echo JHtml::_('icon.edit', $this->item, $params); ?> <?php echo JText::_('TPL_WARP_EDIT_ARTICLE'); ?></p>
	<?php endif; ?>
	<?php if ($params->get('show_title')) : ?>
	<header>

		<?php if ($params->get('show_email_icon')) : ?>
		<div class="icon email"><?php echo JHtml::_('icon.email', $this->item, $params); ?></div>
		<?php endif; ?>
	
		<?php if ($params->get('show_print_icon')) : ?>
		<div class="icon print"><?php echo JHtml::_('icon.print_popup', $this->item, $params); ?></div>
		<?php endif; ?>
	<div class="wallpaper_title">
		<span class="wallpaper_title">
			<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title="<?php echo $this->escape($this->item->title); ?>"><?php echo $this->escape($this->item->title); ?></a>
			<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
			<?php endif; ?>
		</span>
	</div>
	
		<?php if ($params->get('show_create_date') || ($params->get('show_author') && !empty($this->item->author)) || $params->get('show_category')) : ?>
		<p class="meta">
	
			<?php
				
				if ($params->get('show_author') && !empty($this->item->author )) {
					
					$author =  $this->item->author;
					$author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);
					
					if (!empty($this->item->contactid ) &&  $params->get('link_author') == true) {
						echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author));
					} else {
						echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author);
					}
	
				}
		
				if ($params->get('show_create_date')) {
					echo ' '.JText::_('TPL_WARP_ON').' <time datetime="'.substr($this->item->created, 0,10).'" pubdate>'.JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3')).'</time>';
				}
	
				if (($params->get('show_author') && !empty($this->item->author )) || $params->get('show_create_date')) {
					echo '. ';
				}
	
				if ($params->get('show_category')) {
					echo JText::_('TPL_WARP_POSTED_IN').' ';
					$title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)).'">'.$title.'</a>';
					if ($params->get('link_category')) {
						echo $url;
					} else {
						echo $title;
					}
				}
	
			?>	
		
		</p>
		<?php endif; ?>

	</header>
	
	<?php
		$background_link = json_decode($this->item->urls);
	
		$background_img = $background_link->backgrounds_link;
		$background_path = "http://media.sostvnetwork.com/background/";
		
		$background_1024x768 = $background_path."1024x768/".$background_img;
		$background_1280x800 = $background_path."1280x800/".$background_img;
		$background_1280x1024 = $background_path."1280x1024/".$background_img;
		$background_1600x1200 = $background_path."1600x1200/".$background_img;
		$background_1920x1080 = $background_path."1920x1080/".$background_img;
		$background_1920x1200 = $background_path."1920x1200/".$background_img;

	?>
		
	
	<div class="wallpaper_title">
		<span class="download_title">다운로드</span>
	</div>
		<div class="wallpaper_download" id="<?php echo $this->item->id; ?>">
		<ul style="float:left; list-style:none; margin-right:10px;">
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1024x768"; ?>" href="javascript:void(0)" dim_width="1024" dim_height="768" title="<?php echo $this->item->title ?>" link="<?php echo $background_1024x768;?>">1024x768</a></li>
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1280x800"; ?>"href="javascript:void(0)" dim_width="1280" dim_height="800" title="<?php echo $this->item->title ?>" link="<?php echo $background_1280x800;?>">1280x800</a></li>
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1280x1024"; ?>" href="javascript:void(0)" dim_width="1280" dim_height="1024" title="<?php echo $this->item->title ?>" link="<?php  echo $background_1280x1024;?>">1280x1024</a></li>
		</ul>
		<ul style="list-style:none; clear:right;">
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1600x1200"; ?>" href="javascript:void(0)" dim_width="1600" dim_height="1200" title="<?php echo $this->item->title ?>" link = "<?php echo $background_1600x1200; ?>">1600x1200</a></li>
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1920x1080"; ?>" href="javascript:void(0)"dim_width="1920" dim_height="1080" title="<?php echo $this->item->title ?>" link = "<?php echo $background_1920x1080; ?>">1920x1080</a></li>
			<li> <a class="wallpaper" id="wallpaper_<?php echo $this->item->id."_1920x1200"; ?>" href="javascript:void(0)"dim_width="1920" dim_height="1200" title="<?php echo $this->item->title ?>" link = "<?php echo $background_1920x1200; ?>">1920x1200</a></li>
	</ul>
	</div>
	<div class="social_button">
	<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>  
<a class="addthis_button_preferred_2"></a>  
<a class="addthis_button_preferred_3"></a>  
<a class="addthis_button_preferred_4"></a> 
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<!-- AddThis Button END -->
	</div>
	<?php endif; ?>
		</div>
</article>