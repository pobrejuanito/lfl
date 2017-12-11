<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage grid-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('grid-2', $is_plgplayer_plugin_array)) {
	$is_plgplayer_Grid_enabled = '1';
	$key = array_search( 'grid-2' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
	//set version of the plugin
	$is_plgplayer_Grid_version = "grid-2";
} else {
	$is_plgplayer_Grid_enabled = $params->get('GridPluginEnabled', "0");
	//set version of the plugin
	$is_plgplayer_Grid_version = $params->get('GridPluginversion', "grid-2");
}
if($is_plgplayer_Grid_enabled == '1' && $is_plgplayer_Grid_version == "grid-2") {
	$is_plgplayer_plugin_array[] = $is_plgplayer_Grid_version;
	$count = '18';
	$index1 = 'rows';
	$index_defaut1 = '3';
	$index2 = 'tilt';
	$index_defaut2 = '8';
	$index3 = 'distance';
	$index_defaut3 = '50';
	$index4 = 'thumbnailwidth';
	$index_defaut4 = '480';
	$index5 = 'thumbnailheight';
	$index_defaut5 = '270';
	$index6 = 'horizontalmargin';
	$index_defaut6 = '120';
	$index7 = 'verticalmargin';
	$index_defaut7 = '120';
	$index8 = 'start_distance';
	$index_defaut8 = '500';
	$index9 = 'focus_distance';
	$index_defaut9 = '200';
	$index10 = 'titles_position';
	$index_defaut10 = 'over';
	$index11 = 'titles_font';
	$index_defaut11 = '_sans';
	//true false
	$index12 = 'glow';
	$index_defaut12 = '1';
	$index13 = 'titles';
	$index_defaut13 = '1';
	$index14 = 'border';
	$index_defaut14 = '0';
	$index15 = 'fade_titles';
	$index_defaut15 = '1';
	$index16 = 'dof_blur';
	$index_defaut16 = '0';
	$index17 = 'dof_fade';
	$index_defaut17 = '0';
	for ($i = 1; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["grid.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("GridPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 11) {
					$is_plgplayer_flashvars["grid.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["grid.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}