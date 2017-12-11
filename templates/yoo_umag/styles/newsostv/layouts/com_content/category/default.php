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
	<?php if ( $this->params->get('show_jwplayer_listview') != 1 ) : ?>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>

		<?php if ($this->params->get('page_subheading')) : ?>
		<h2 class="subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?></h2>
		<?php endif; ?>

		<?php if ($this->params->get('show_category_title', 1)) : ?>
            <?php

                $params = json_decode($item->params);
                if ( ($image = $this->category->getParams()->get('image')) == '' ) {
                    $image = 'images/missing_45x55.png';
                }
            ?>
            <div class="tabs">
                <div role="tabpanel">
                <!-- Tab panes -->
                    <div class="tab-content">
                    <!-- POPULAR STARTS -->
                        <div role="tabpanel" class="tab-pane active" id="popular">
                            <ul class="tabs-posts">
                                <li>
                                    <div class="pic"><img src="<?php echo $image ?>" class="img-responsive" style="width: 75px; height: 95px"></div>
                                    <div class="caption">
                                        <a href="#"><h1><?php echo $this->category->title;?></h1></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php  endif; ?>

		<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) :?>
		<div class="description">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo $this->category->getParams()->get('image'); ?>" class="size-auto align-right" />
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo $this->loadTemplate('articles'); ?>
</div>