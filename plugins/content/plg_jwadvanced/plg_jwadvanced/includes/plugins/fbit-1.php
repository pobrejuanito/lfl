<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage fbit-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('fbit-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_Facebook_enabled = '1';
	$key = array_search( 'fbit-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_Facebook_enabled = $params->get('FacePluginEnabled', "0");
}
if($is_plgplayer_Facebook_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'fbit-1';
	$is_plgplayer_flashvars["dock"] = "true";
}
//set thumb facebook
if (!(empty($is_plgplayer_flashvars['fbit.thumb']))) {
	$is_plgplayer_Facebooklink_thumb = $is_plgplayer_flashvars['fbit.thumb'];
	unset($is_plgplayer_flashvars['fbit.thumb']);
} else {
	$is_plgplayer_Facebooklink_thumb = $params->get('FacePluginfbitthumbnail', "");
}