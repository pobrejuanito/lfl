<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage carousel-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );








	$is_modplayer_Grid_enabled = $params->get('GridPluginEnabled', "0");
	//set version of the plugin
	$is_modplayer_Grid_version = $params->get('GridPluginversion', "carousel-1");

if($is_modplayer_Grid_enabled == '1' && $is_modplayer_Grid_version == "carousel-1") {
	$is_modplayer_plugin_array[] = $is_modplayer_Grid_version;
	$count = '17';
	$index1 = 'thumbnailwidth';
	$index_defaut1 = '480';
	$index2 = 'thumbnailheight';
	$index_defaut2 = '270';
	$index3 = 'horizontalmargin';
	$index_defaut3 = '120';
	$index4 = 'verticalmargin';
	$index_defaut4 = '120';
	$index5 = 'start_distance';
	$index_defaut5 = '500';
	$index6 = 'focus_distance';
	$index_defaut6 = '200';
	$index7 = 'titles_position';
	$index_defaut7 = 'over';
	$index8 = 'titles_font';
	$index_defaut8 = '_sans';
	//true false
	$index9 = 'glow';
	$index_defaut9 = '1';
	$index10 = 'titles';
	$index_defaut10 = '1';
	$index11 = 'border';
	$index_defaut11 = '0';
	$index12 = 'fade_titles';
	$index_defaut12 = '1';
	$index13 = 'dof_blur';
	$index_defaut13 = '0';
	$index14 = 'dof_fade';
	$index_defaut14 = '0';
	$index15 = 'outside';
	$index_defaut15 = '0';
	$index16 = 'reflections';
	$index_defaut16 = '0';
	for ($i = 1; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["carousel.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("GridPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 8) {
					$is_modplayer_flashvars["carousel.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["carousel.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}