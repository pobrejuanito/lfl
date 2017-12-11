<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die; 

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<form class="box style" id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search');?>" method="post" name="searchForm">

		<div class="search_input_box">
			<input type="text" name="searchword" id="search_searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="inputbox" />
			<button name="Search" id="search_button" onclick="this.form.submit()" class="button"><?php echo JText::_('COM_SEARCH_SEARCH'); ?></button>
		</div>
		<div class="seperator"></div>
		<ul class="search_phrase">
			<li>
			<?php echo $this->lists['searchphrase']; ?>
			</li>
		</ul>
		
		<?php if ($this->params->get('search_areas', 1)) : ?>
		<ul class="search_active">
		<div><?php echo JText::_('COM_SEARCH_SEARCH_ONLY'); ?></div>
			<?php foreach ($this->searchareas['search'] as $val => $txt) : ?>
				<?php  $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : ''; ?>
				<li>
				<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area_<?php echo $val;?>" <?php echo $checked;?> />
				<label for="area_<?php echo $val;?>">
					<?php echo JText::_($txt); ?>
				</label>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<ul class="search_ordering">
			<li>
			<label for="ordering"><?php echo JText::_('COM_SEARCH_ORDERING'); ?></label>
			<?php echo $this->lists['ordering'];?>
			</li>
		</ul>

		<div class="search_result_head">
			<?php if (!empty($this->searchword)): ?>
			<div>
				<?php echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', $this->total);?>
			</div>
			<?php endif;?>
				
	
			<?php if ($this->total > 0) : ?>
			<div class="filter">
		<!--	<label for="limit"><?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?></label> -->
				<?php echo $this->pagination->getPagesCounter(); ?>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<?php endif; ?>
		</div>

	<input type="hidden" name="task" value="search" />
</form>