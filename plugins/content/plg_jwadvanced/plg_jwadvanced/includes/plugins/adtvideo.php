<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage adttext.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

//check if  Adtonomy Video ads is enabled
if(in_array('adtvideo', $is_plgplayer_plugin_array)) {
	$is_plgplayer_adtvideo_enabled = '1';
	$key = array_search( 'adtvideo' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_adtvideo_enabled = $params->get('adtvideoPluginEnabled', "0");
}
if($is_plgplayer_adtvideo_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'adtvideo';
	$is_plgplayer_adtvideo_config_defaut = $params->get("adtvideoPluginconfig", "");
	if (!(empty($is_plgplayer_flashvars["adtvideo.config"]))) {
		$is_plgplayer_adtvideo_config = $is_plgplayer_flashvars["adtvideo.config"];
		unset($is_plgplayer_flashvars["adtvideo.config"]);
	} else {
		$is_plgplayer_adtvideo_config  = $is_plgplayer_adtvideo_config_defaut;
	}
	if($is_plgplayer_adtvideo_config  != '') {
		$is_plgplayer_flashvars["adtvideo.config"] = $is_plgplayer_adtvideo_config;
	}
}