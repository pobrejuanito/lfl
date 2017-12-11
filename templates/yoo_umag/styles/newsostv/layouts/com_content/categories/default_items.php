<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;
/* Per request, disable ebook & pdf link to avoid font copyright issues in korea
$my_params->ebooklink
$my_params->pdflink
*/
?>
<div class="row category-caption">
    <div class="col-lg-12">
        <h2 class="pull-left">SOSTV 매거진</h2>
    </div>
</div>
<?php if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) : ?>
    <div class="tabs">
        <div role="tabpanel">
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- POPULAR STARTS -->
                <div role="tabpanel" class="tab-pane active" id="popular">
                    <ul class="tabs-posts">
                        <?php foreach($this->items[$this->parent->id] as $id => $item) : ?>
                            <?php

                                $params = json_decode($item->params);
                                if ( $params->image == '' ) {
                                    $params->image = 'images/missing_45x55.png';
                                }
                            ?>
                        <li>
                            <div class="pic"><img src="<?php echo $params->image; ?>" class="img-responsive" style="width: 45px; height: 55px"></div>
                            <div class="info">
                                <?php  if ( $params->publishdate != '') : ?>
                                    <span class="date"><i class="fa fa-calendar-o"></i><?php echo $params->publishdate; ?></span>
                                <?php endif; ?>
                                <span class="comments pull-right"><i class="fa fa-file-o"></i> 아이템: <?php echo $item->numitems; ?> 개</span>
                            </div>
                            <div class="caption">
                                <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id));?>"><?php echo $this->escape($item->title); ?></a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- POPULAR ENDS -->
            </div>
        </div>
    </div>
<?php endif; ?>
