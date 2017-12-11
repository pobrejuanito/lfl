<?php
/**
 * @package   Widgetkit
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$widget_id = $widget->id.'-'.uniqid();
$settings  = $widget->settings;
$content   = array();
$nav       = ($settings['navigation']) ? 'nav-'.$settings['navigation'] : '';
?>
<div class="col-lg-8">
<div class="slider">
<?php foreach ($widget->items as $key => $item) : ?>
    <div class="pic-with-overlay">
        <?php echo $item['content']; ?>
    </div>
<?php endforeach; ?>
</div>
</div>