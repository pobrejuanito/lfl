<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage hd-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );







	$is_modplayer_hd_enabled = $params->get('HDPluginEnabled');
	//set version of the plugin
	$is_modplayer_hd_version = $params->get('HDPluginversion', "1");
	$is_modplayer_hd_version = "hd-".$is_modplayer_hd_version;

if($is_modplayer_hd_enabled == '1' && $is_modplayer_hd_version == "hd-1") {
	$is_modplayer_plugin_array[] = $is_modplayer_hd_version;
	$count = '6';
	$index3 = 'bitrate';
	$index_defaut3 = '1500';
	$index4 = 'state';
	$index_defaut4 = '1';
	$index5 = 'fullscreen';
	$index_defaut5 = '0';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["hd.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("HD".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 3) {
					$is_modplayer_flashvars["hd.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["hd.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}