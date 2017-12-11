<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage gapro-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('gapro-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_gapro_enabled = '1';
	$key = array_search( 'gapro-1' , $is_plgplayer_plugin_array);
	$is_plgplayer_gapro_version = 'gapro-1';
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_gapro_enabled = $params->get('GaProPluginEnabled', "0");
	//set version of the plugin
	$is_plgplayer_gapro_version = $params->get('GaProPluginversion', "gapro-1");
}
if($is_plgplayer_gapro_enabled == '1' && $is_plgplayer_gapro_version == "gapro-1") {
	$is_plgplayer_plugin_array[] = $is_plgplayer_gapro_version;
	$count = '7';
	$index2 = 'accountid';
	$index_defaut2 = '';
	$index3 = 'idstring';
	$index_defaut3 = '||streamer||/||file||';
	$index4 = 'trackstarts';
	$index_defaut4 = '1';
	$index5 = 'trackpercentage';
	$index_defaut5 = '1';
	$index6 = 'tracktime';
	$index_defaut6 = '1';
	for ($i = 2; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["gapro.".${"index".$i}]))	{
			$is_plgplayer_playlist_var = $params->get("GaPro".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 3) {
					$is_plgplayer_flashvars["gapro.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["gapro.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}