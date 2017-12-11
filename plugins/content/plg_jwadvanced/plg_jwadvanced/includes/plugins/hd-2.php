<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage hd-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('hd-2', $is_plgplayer_plugin_array)) {
	$is_plgplayer_hd_enabled = '1';
	$key = array_search( 'hd-2' , $is_plgplayer_plugin_array);
	$is_plgplayer_hd_version = "hd-2";
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_hd_enabled = $params->get('HDPluginEnabled');
	//set version of the plugin
	$is_plgplayer_hd_version = $params->get('HDPluginversion', "2");
	$is_plgplayer_hd_version = "hd-".$is_plgplayer_hd_version;
}
if($is_plgplayer_hd_enabled == '1' && $is_plgplayer_hd_version == "hd-2") {
	$is_plgplayer_plugin_array[] = $is_plgplayer_hd_version;
	$count = '6';
	$index3 = 'bitrate';
	$index_defaut3 = '1500';
	$index4 = 'state';
	$index_defaut4 = '1';
	$index5 = 'fullscreen';
	$index_defaut5 = '0';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["hd.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("HD".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 3) {
					$is_plgplayer_flashvars["hd.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["hd.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}