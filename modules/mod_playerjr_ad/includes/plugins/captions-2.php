<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage captions-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );








	$is_modplayer_captions_enabled = $params->get('CaptionsPluginEnabled');
	//set version of the plugin
	$is_modplayer_captions_version = $params->get('CaptionsPluginversion');
	$is_modplayer_captions_version = "captions-".$is_modplayer_captions_version;
	
if($is_modplayer_captions_enabled == '1' && $is_modplayer_captions_version == 'captions-2') {
	$is_modplayer_plugin_array[] = $is_modplayer_captions_version;
	$count = '8';
	$index5 = 'fontsize';
	$index_defaut5 = '14';
	$index6 = 'back';
	$index_defaut6 = '0';
	$index7 = 'state';
	$index_defaut7 = '1';
	for ($i = 5; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["captions.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("Captions".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 5)	{
					$is_modplayer_flashvars["captions.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["captions.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}