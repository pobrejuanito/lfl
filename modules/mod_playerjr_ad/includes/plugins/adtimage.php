<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage adtimage.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

//check if  Adtonomy Image ads is enabled





	$is_modplayer_adtimage_enabled = $params->get('adtimageEnabled');

if($is_modplayer_adtimage_enabled == '1') {
	$is_modplayer_plugin_array[] = 'adtimage';
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
		if (empty($is_modplayer_flashvars["adtimage.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("adtimage".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 5) {
					$is_modplayer_flashvars["adtimage.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["adtimage.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}