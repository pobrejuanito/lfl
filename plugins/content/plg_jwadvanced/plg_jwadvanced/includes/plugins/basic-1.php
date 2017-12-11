<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage basic-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('basic-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_Grid_enabled = '1';
	$key = array_search( 'basic-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
	//set version of the plugin
	$is_plgplayer_Grid_version = "basic-1";
} else {
	$is_plgplayer_Grid_enabled = $params->get('GridPluginEnabled', "0");
	//set version of the plugin
	$is_plgplayer_Grid_version = $params->get('GridPluginversion', "basic-1");
}
if($is_plgplayer_Grid_enabled == '1' && $is_plgplayer_Grid_version == "basic-1") {
	$is_plgplayer_plugin_array[] = $is_plgplayer_Grid_version;
	$count = '15';
	$index1 = 'thumbnailwidth';
	$index_defaut1 = '480';
	$index2 = 'thumbnailheight';
	$index_defaut2 = '270';
	$index3 = 'horizontalmargin';
	$index_defaut3 = '120';
	$index4 = 'start_distance';
	$index_defaut4 = '500';
	$index5 = 'focus_distance';
	$index_defaut5 = '200';
	$index6 = 'titles_position';
	$index_defaut6 = 'over';
	$index7 = 'titles_font';
	$index_defaut7 = '_sans';
	//true false
	$index8 = 'glow';
	$index_defaut8 = '1';
	$index9 = 'titles';
	$index_defaut9 = '1';
	$index10 = 'border';
	$index_defaut10 = '0';
	$index11 = 'fade_titles';
	$index_defaut11 = '1';
	$index12 = 'dof_blur';
	$index_defaut12 = '0';
	$index13 = 'dof_fade';
	$index_defaut13 = '0';
	$index14 = 'reflections';
	$index_defaut14 = '0';
	for ($i = 1; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["basic.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("GridPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 7) {
					$is_plgplayer_flashvars["basic.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["basic.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}