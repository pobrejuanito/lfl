<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage viral-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('viral-2', $is_plgplayer_plugin_array)) {
	$is_plgplayer_viral_enabled = '1';
	$key = array_search( 'viral-2' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_viral_enabled = $params->get('ViralPluginEnabled', "0");
}
if($is_plgplayer_viral_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'viral-2';
	$count = '15';
	$index3 = 'functions';
	$index_defaut3 = 'embed,link';
	$index4 = 'recommendations';
	$index_defaut4 = '';
	$index5 = 'emailsubject';
	$index_defaut5 = 'Check out this video!';
	$index6 = 'emailfooter';
	$index_defaut6 = 'www.longtailvideo.com';
	$index7 = 'fgcolor';
	$index_defaut7 = 'FFFFFF';
	$index8 = 'bgcolor';
	$index_defaut8 = '333333';
	//true false flashvars
	$index9 = 'onpause';
	$index_defaut9 = '1';
	$index10 = 'oncomplete';
	$index_defaut10 = '1';
	$index11 = 'allowdock';
	$index_defaut11 = '0';
	$index12 = 'multidock';
	$index_defaut12 = '0';
	$index13 = 'allowmenu';
	$index_defaut13 = '1';
	$index14 = 'matchplayercolors';
	$index_defaut14 = '1';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["viral.".${"index".$i}]))	{
			$is_plgplayer_playlist_var = $params->get("ViralPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 8)	{
					$is_plgplayer_flashvars["viral.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["viral.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}