<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage adtimage.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

//check if  Adtonomy Image ads is enabled
if(in_array('adtimage', $is_plgplayer_plugin_array)) {
	$is_plgplayer_adtimage_enabled = '1';
	$key = array_search( 'adtimage' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_adtimage_enabled = $params->get('adtimagePluginEnabled', "0");
}
if($is_plgplayer_adtimage_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'adtimage';
	$count = '7';
	$index3 = 'graphic';
	$index_defaut3 = '';
	$index4 = 'link';
	$index_defaut4 = '';
	$index5 = 'positions';
	$index_defaut5 = 'pre,post';
	//true false
	$index6 = 'onpause';
	$index_defaut6 = '0';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["adtimage.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("adtimage".${"index".$i}, ${"index_defaut".$i});
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 5) {
					$is_plgplayer_flashvars["adtimage.".${"index".$i}] = $is_plgplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_plgplayer_flashvars["adtimage.".${"index".$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}
}