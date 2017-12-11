<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage sharing-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('sharing-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_sharing_enabled = '1';
	$key = array_search( 'sharing-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
	//set version of the plugin
	$is_plgplayer_sharing_version = "sharing-1";
} else {
	$is_plgplayer_sharing_enabled = $params->get('SharingPluginEnabled', "0");
	//set version of the plugin
	$is_plgplayer_sharing_version = $params->get('SharingPluginversion', "1");
	$is_plgplayer_sharing_version = "sharing-".$is_plgplayer_sharing_version;
}
if($is_plgplayer_sharing_enabled == '1' && $is_plgplayer_sharing_version == 'sharing-1') {
	$is_plgplayer_plugin_array[] = $is_plgplayer_sharing_version;
	//set link
	if (!(empty($is_plgplayer_flashvars['sharing.link'])))	{
		$is_plgplayer_sharinglink = $is_plgplayer_flashvars['sharing.link'];
		unset($is_plgplayer_flashvars['sharing.link']);
	} else {
		$u =& JURI::getInstance();
		$is_plgplayer_sharinglink = urlencode($u->toString());
	}
	$is_plgplayer_flashvars["sharing.link"] = $is_plgplayer_sharinglink;

	//set thumb facebook
	if (!(empty($is_plgplayer_flashvars['sharing.thumb'])))	{
		$is_plgplayer_sharinglink_thumb = $is_plgplayer_flashvars['sharing.thumb'];
		unset($is_plgplayer_flashvars['sharing.thumb']);
	} else {
		$is_plgplayer_sharinglink_thumb = $params->get('SharingPluginthumbnail', "");
	}
}