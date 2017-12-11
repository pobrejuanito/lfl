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
<?php
if ( $this->params->get('about_us_page') === 'about-us-must-read') :
?>
<div class="row category-caption">
    <div class="col-lg-12">
        <h2 class="pull-left main-caption"><a href="about.html">우리 소개</a></h2>
        <h2 class="pull-left">꼭 읽어야 하는 글</h2>
    </div>
</div>
<!-- TABS STARTS -->
<div class="tabs">
    <div role="tabpanel">
        <div class="row">
            <div class="col-lg-4">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-stacked" role="tablist">
                    <?php foreach ( $this->items as $i=>$article) : ?>
                        <li role="presentation" <?php echo ($i == 0)? 'class="active"' : '' ?>><a role="tab" data-toggle="tab" href="#sp-<?php echo $article->id; ?>"><?php echo ($i + 1). '.' .$this->escape($article->title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-8">
                <!-- Tab panes -->
                <div class="tab-content">
                    <?php foreach ( $this->items as $i=>$article) : ?>
                        <div role="tabpanel" class="tab-pane <?php echo ($i == 0)? 'active' : '' ?>" id="sp-<?php echo $article->id; ?>">
                            <div><?php echo $article->introtext; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TABS ENDS -->

<?php elseif ($this->params->get('about_us_page') === 'about-us-faq'): ?>
<div class="row category-caption">
    <div class="col-lg-12">
        <h2 class="pull-left main-caption"><a href="about.html">우리 소개</a></h2>
        <h2 class="pull-left">SOSTV FAQ</h2>
    </div>
</div>
    <!-- TABS STARTS -->
    <div class="tabs">
        <div role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <?php foreach ( $this->items as $i=>$article) : ?>
                            <li role="presentation" <?php echo ($i == 0)? 'class="active"' : '' ?>><a role="tab" data-toggle="tab" href="#sp-<?php echo $article->id; ?>"><?php echo $this->escape($article->title); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php foreach ( $this->items as $i=>$article) : ?>
                            <div role="tabpanel" class="tab-pane <?php echo ($i == 0)? 'active' : '' ?>" id="sp-<?php echo $article->id; ?>">
                                <div style="padding-top: 20px;"><?php echo $article->introtext; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TABS ENDS -->
<?php endif; ?>