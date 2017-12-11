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

//check if  Adtonomy Text ads is enabled
if(in_array('adttext', $is_plgplayer_plugin_array)) {
	$is_plgplayer_adttext_enabled = '1';
	$key = array_search( 'adttext' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_adttext_enabled = $params->get('adttextPluginEnabled', "0");
}
if($is_plgplayer_adttext_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'adttext';
	$is_plgplayer_adttext_config_defaut = $params->get("adttextPluginconfig", "");
	if (!(empty($is_plgplayer_flashvars["adttext.config"]))) {
		$is_plgplayer_adttext_config = $is_plgplayer_flashvars["adttext.config"];
		unset($is_plgplayer_flashvars["adttext.config"]);
	} else {
		$is_plgplayer_adttext_config  = $is_plgplayer_adttext_config_defaut;
	}
	if($is_plgplayer_adttext_config  != '') {
		$is_plgplayer_flashvars["adttext.config"] = $is_plgplayer_adttext_config;
	}
}