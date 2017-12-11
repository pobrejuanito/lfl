<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage captions-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('captions-2', $is_plgplayer_plugin_array)) {
	$is_plgplayer_captions_enabled = '1';
	$key = array_search( 'captions-2' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
	//set version of the plugin
	$is_plgplayer_captions_version = "captions-2";
} else {
	$is_plgplayer_captions_enabled = $params->get('CaptionsPluginEnabled');
	//set version of the plugin
	$is_plgplayer_captions_version = $params->get('CaptionsPluginversion', "2");
	$is_plgplayer_captions_version = "captions-".$is_plgplayer_captions_version;
}
if($is_plgplayer_captions_enabled == '1' && $is_plgplayer_captions_version == 'captions-2') {
	$is_plgplayer_plugin_array[] = $is_plgplayer_captions_version;
	$count = '8';
	$index5 = 'fontsize';
	$index_defaut5 = '14';
	$index6 = 'back';
	$index_defaut6 = '0';
	$index7 = 'state';
	$index_defaut7 = '1';
	for ($i = 5; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["captions.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("Captions".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 5)	{
					$is_plgplayer_flashvars["captions.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["captions.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}