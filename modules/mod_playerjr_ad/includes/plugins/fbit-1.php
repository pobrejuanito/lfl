<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage fbit-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_Facebook_enabled = $params->get('FacePluginEnabled');

if($is_modplayer_Facebook_enabled == '1') {
	$is_modplayer_plugin_array[] = 'fbit-1';
	$is_modplayer_flashvars["dock"] = "true";
	$is_modplayer_Facebook_altlink = $params->get('FacePluginfbitlink');
	if($is_modplayer_Facebook_altlink != '') {
		$is_modplayer_flashvars['fbit.link'] = $is_modplayer_Facebook_altlink;
	}
	//set thumbnail facebook sharing
	$is_modplayer_Facebook_thumbnail = $params->get('FacePluginfbitthumbnail');
}