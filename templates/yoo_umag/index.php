<?php
/**
* @package   yoo_nano
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// include config  
include_once(dirname(__FILE__).'/config.php');
unset($this->_scripts[JURI::root(true).'/media/system/js/caption.js']);
unset($this->_scripts[JURI::root(true).'/media/system/js/mootools-core.js']);
unset($this->_scripts[JURI::root(true).'/media/system/js/mootools-more.js']);
// get warp
$warp = Warp::getInstance();

// load main template file, located in /layouts/template.php
echo $warp['template']->render('template');