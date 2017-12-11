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
<div id="system">

	<div id="frame_box">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h3 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h3>
	<?php endif; ?>

	<?php if ($this->params->get('show_base_description') && ($this->params->get('categories_description') || $this->parent->description)) : ?>
	<div class="description">
		<?php
			if($this->params->get('categories_description')) {
				echo JHtml::_('content.prepare', $this->params->get('categories_description'), '', 'com_content.categories');
			} elseif ($this->parent->description) {
				echo JHtml::_('content.prepare', $this->parent->description, '', 'com_content.categories');
			}
		?>
	</div>
	<?php endif; ?>

	<?php echo $this->loadTemplate('items'); ?>
	</div>
</div>