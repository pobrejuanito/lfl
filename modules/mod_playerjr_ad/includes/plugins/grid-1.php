<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage grid-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );








	$is_modplayer_Grid_enabled = $params->get('GridPluginEnabled', "0");
	//set version of the plugin
	$is_modplayer_Grid_version = $params->get('GridPluginversion', "grid-1");
	
if($is_modplayer_Grid_enabled == '1' && $is_modplayer_Grid_version == "grid-1") {
	$is_modplayer_plugin_array[] = $is_modplayer_Grid_version;
	$count = '9';
	$index1 = 'rows';
	$index_defaut1 = '4';
	$index2 = 'tilt';
	$index_defaut2 = '8';
	$index3 = 'distance';
	$index_defaut3 = '50';
	$index4 = 'thumbnailwidth';
	$index_defaut4 = '480';
	$index5 = 'thumbnailheight';
	$index_defaut5 = '270';
	$index6 = 'horizontalmargin';
	$index_defaut6 = '100';
	$index7 = 'verticalmargin';
	$index_defaut7 = '150';
	//true false
	$index8 = 'glow';
	$index_defaut8 = '1';
	for ($i = 1; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["grid.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("GridPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 7) {
					$is_modplayer_flashvars["grid.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["grid.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}