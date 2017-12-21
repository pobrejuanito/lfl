<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage revolt-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_Revolt_enabled = $params->get('RevoltPluginEnabled');
	
if($is_modplayer_Revolt_enabled == '1')	{
	$is_modplayer_plugin_array[] = 'revolt-1';
	$count = '5';
	$index3 = 'gain';
	$index_defaut3 = '1';
	$index4 = 'timeout';
	$index_defaut4 = '10';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["revolt.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("RevoltPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				$is_modplayer_flashvars["revolt.".${"index".$i}] = $is_modplayer_playlist_var;
			}
		}
	}
}