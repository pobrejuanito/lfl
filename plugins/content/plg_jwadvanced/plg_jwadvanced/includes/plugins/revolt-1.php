<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage revolt-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('revolt-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_Revolt_enabled = '1';
	$key = array_search( 'revolt-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_Revolt_enabled = $params->get('RevoltPluginEnabled', "0");
}
if($is_plgplayer_Revolt_enabled == '1')	{
	$is_plgplayer_plugin_array[] = 'revolt-1';
	$count = '5';
	$index3 = 'gain';
	$index_defaut3 = '1';
	$index4 = 'timeout';
	$index_defaut4 = '10';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["revolt.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("RevoltPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				$is_plgplayer_flashvars["revolt.".${"index".$i}] = $is_plgplayer_playlist_var;
			}
		}
	}
}