<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
// no direct access
defined('_JEXEC') or die;
//Load the class
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
?>
<div class="aboutus">
	<div style="overflow: auto; width: 100%; padding-bottom: 30px;"><img src="/templates/yoo_nano/styles/newsostv/images/aboutus/aboutus_title.gif" />
	</div>
	<div style="margin-left: 60px; overflow: auto;"><a href="/about-us.html">
<div class="aboutus_aboutus">
<div class="whois">&nbsp;</div>
</div>
</a><a href="/about-us-must-watch.html">
<div class="aboutus_mustsee">
<div class="mustsee">&nbsp;</div>
</div>
</a><a href="/about-us-must-read.html">
<div class="aboutus_mustread">
<div class="mustread">&nbsp;</div>
</div>
</a><a href="/about-us-faq.html">
<div class="aboutus_faq">
<div class="faq">&nbsp;</div>
</div>
</a>
	</div>
</div>
<?php
if ( $this->params->get('about_us_page') === 'about-us-must-read') :
?>
<div style="padding: 65px 0px 10px 0px;"><img src="/templates/yoo_nano/styles/newsostv/images/aboutus/aboutus_mustsee_title.gif" ></div>
<div style="height: 4px; background-color: #ceaa5d; width:100%"></div>
<?php
$item = 1;
$j = 0;
foreach ( $this->items as $i=>$article) :
?>
<!-- iterate over this -->
<?php
if ( $j === 0 ) :
?>
<div style="overflow:auto; width:100%; border-bottom: 1px #c9c9c9 solid;">
<?php
endif;

if ( $j === 0):
?>
<div style="font-size: 11px; float:left; height:20px;padding: 10px 0px 0px 0px; width: 320px;"><img src="http://www.sostv.net/templates/yoo_nano/styles/newsostv/images/list-style-bulet.png" style="padding: 0px 10px 0px 10px;"></img><a href="<?php echo JURI::current(); ?>?contentid=<?php echo $article->id; ?>"><?php echo $item. '.' .$this->escape($article->title); ?></a>
</div>
<?php
elseif ( $j === 1):
?>
<div style="font-size: 11px; float:left; height:20px;padding: 10px 0px 0px 0px; width: 310px;"><img src="http://www.sostv.net/templates/yoo_nano/styles/newsostv/images/list-style-bulet.png" style="padding: 0px 10px 0px 10px;"></img><a href="<?php echo JURI::current(); ?>?contentid=<?php echo $article->id; ?>"><?php echo $item. '.' .$this->escape($article->title); ?></a>
</div>
<?php
elseif( $j === 2):
?>
<div style="font-size: 11px; float:left; height:20px;padding: 10px 0px 0px 0px; width: 300px;"><img src="http://www.sostv.net/templates/yoo_nano/styles/newsostv/images/list-style-bulet.png" style="padding: 0px 10px 0px 10px;"></img><a href="<?php echo JURI::current(); ?>?contentid=<?php echo $article->id; ?>"><?php echo $item. '.' .$this->escape($article->title); ?></a>
</div>
<?php
endif;
if ( $j === 2) {
  $j = 0;
?>
</div>
<?php
} else {
	$j++;
}
?>
<!-- end iterate over this -->
<?php
$item++;
endforeach;
?>


<?php elseif ($this->params->get('about_us_page') === 'about-us-faq'): ?>
<div style="padding: 65px 0px 10px 0px;"><img src="/templates/yoo_nano/styles/newsostv/images/aboutus/aboutus_faq_title.gif" ></div>
<div style="height: 4px; background-color: #c9c9c9; width:100%;"></div>
<div style="height: 1px; padding: 25px"></div>
<?php endif; ?>
<div style="width: 670px; display: block; margin-left: auto; margin-right: auto;">
<p>
	<?php 
		if ( isset($_GET['contentid']) ) {
			foreach($this->items as $index => $article ) {
				if ( $article->id == $_GET['contentid'] ) {
					echo $this->items[$index]->introtext;
					break;
				}
			}
		} else {
			echo $this->items[0]->introtext;

		}
	?>
</p>
<?php
if ( $this->params->get('about_us_page') !== 'about-us-must-read') :
?>
<div style="padding-bottom: 20px">&nbsp;</div>
<table class="zebra" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<?php $isfirst=0;?>
		<?php foreach ($this->items as $i => $article) : ?>
		<tr class="<?php if ($i % 2 == '0') { echo 'odd'; } else { echo 'even'; } ?>">
			<td><img src="http://www.sostv.net/templates/yoo_nano/styles/newsostv/images/list-style-bulet.png" style="padding: 0px 10px 0px 10px;"></img>
				<a href="<?php echo JURI::current(); ?>?contentid=<?php echo $article->id; ?>">
					<?php echo $this->escape($article->title); ?>
				</a>
				<?php //if ($article->params->get('access-edit')) echo JHtml::_('icon.edit', $article, $params); ?>
			</td>
		</tr>
		<?php $isfirst++; ?>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
<?php
endif;
?>