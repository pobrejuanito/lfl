<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage viral-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_viral_enabled = $params->get('ViralPluginEnabled');

if($is_modplayer_viral_enabled == '1') {
	$is_modplayer_plugin_array[] = 'viral-2';
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
		if (empty($is_modplayer_flashvars["viral.".${"index".$i}]))	{
			$is_modplayer_playlist_var = $params->get("ViralPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 8)	{
					$is_modplayer_flashvars["viral.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["viral.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}