<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage tipjar-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('tipjar-1', $is_plgplayer_plugin_array)) {
	$is_plgplayer_tipjar_enabled = '1';
	$key = array_search( 'tipjar-1' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_tipjar_enabled = $params->get('TipJarPluginEnabled', "0");
}
if($is_plgplayer_tipjar_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'tipjar-1';
	$count = '10';
	$index3 = 'title';
	$index_defaut3 = '';
	$index4 = 'text';
	$index_defaut4 = '';
	$index5 = 'business';
	$index_defaut5 = '';
	$index6 = 'amount';
	$index_defaut6 = '';
	$index7 = 'currency_code';
	$index_defaut7 = 'USD';
	$index8 = 'image_url';
	$index_defaut8 = '';
	$index9 = 'return_url';
	$index_defaut9 = '';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars["tipjar.".${"index".$i}])) {
			$is_plgplayer_playlist_var = $params->get("TipJar".${"index".$i}, ${"index_defaut".$i});
			if(${"index".$i} == 'business' && $jw_html5 != '1') {
				$is_plgplayer_playlist_var = preg_replace('#@#', '%40', $is_plgplayer_playlist_var);
			}
			if($is_plgplayer_playlist_var != ${"index_defaut".$i}) {
				$is_plgplayer_flashvars["tipjar.".${"index".$i}] = $is_plgplayer_playlist_var;
			}
		} else if(${"index".$i} == 'business' && $jw_html5 != '1') {
			//url encode
			$is_plgplayer_flashvars["tipjar.".${"index".$i}] = preg_replace('#@#', '%40', $is_plgplayer_flashvars["tipjar.".${"index".$i}]);
		}
	}
}