<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

?>
<?php if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) : ?>
<table class="zebra">


<tbody>
	<?php foreach($this->items[$this->parent->id] as $id => $item) : ?>
		<tr>
		<?php if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) : ?>
			<td class="list_title">
			<span class="titles">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id));?>"><?php echo $this->escape($item->title); ?></a>
			</span>
			
			<span class="article_info">

			<?php //if($this->params->get('show_pdf_categories_cat') == 1) :?>
			<?php if(1) :?>
			<?php		$my_params = json_decode($item->params);?>
			
			
			<?php
			/* Per request, disable ebook & pdf link to avoid font copyright issues in korea 
						if(isset($my_params->ebooklink) && ($my_params->ebooklink !== '')) :
			?>			
			<span class="article_ebook"><a target="_blank" href="<?php echo $my_params->ebooklink; ?>">ebook</a></span>
			<?php endif; ?>

						<?php	
						
			
						if(isset($my_params->pdflink) && ($my_params->pdflink !== '')) :
						
						?>
						
			<span class="article_pdf"><a target="_blank" href="<?php echo $my_params->pdflink; ?>">pdf</a></span> 
			<?php endif; ?>
			<?php */ ?>						
			<?php if ($this->params->get('show_cat_num_articles_cat') == 1) :?>
			<span class="articles-number">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id));?>">아이템: <?php echo $item->numitems; ?> 개</a>
			</span>
			<?php endif; ?>
			</span>
			</td>
			<?php endif; ?>
		</tr>
		<tr>
			<?php if (($this->params->get('show_subcat_desc_cat') == 1) && $item->description) : ?>
			<td class="description">

			<div><?php echo JHtml::_('content.prepare', $item->description, '', 'com_content.categories'); ?></div>
			
			</td>
			<?php endif; ?>
	
			<?php
				if (count($item->getChildren()) > 0) {
					$this->items[$item->id] = $item->getChildren();
					$this->parent = $item;
					$this->maxLevelcat--;
					echo $this->loadTemplate('items');
					$this->parent = $item->getParent();
					$this->maxLevelcat++;
				}
			?>
		</td>
		<?php endif; ?>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
