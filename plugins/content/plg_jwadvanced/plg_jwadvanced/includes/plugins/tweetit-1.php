<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage tweetit-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('tweetit-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_Tweeter_enabled = '1';
	$key = array_search( 'tweetit-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_Tweeter_enabled = $params->get('TweetPluginEnabled', "0");
}
if($is_plgplayer_Tweeter_enabled == '1'){
	$is_plgplayer_plugin_array[] = 'tweetit-1';
	$is_plgplayer_flashvars["dock"] = "true";
}