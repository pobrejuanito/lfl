<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage adttext.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

//check if  Adtonomy Text ads is enabled





	$is_modplayer_adttext_enabled = $params->get('adttextEnabled');

if($is_modplayer_adttext_enabled == '1') {
	$is_modplayer_plugin_array[] = 'adttext';
	$is_modplayer_adttext_config_defaut = $params->get("adttextconfig", "");
	if (!(empty($is_modplayer_flashvars["adttext.config"]))) {
		$is_modplayer_adttext_config = $is_modplayer_flashvars["adttext.config"];
		unset($is_modplayer_flashvars["adttext.config"]);
	} else {
		$is_modplayer_adttext_config  = $is_modplayer_adttext_config_defaut;
	}
	if($is_modplayer_adttext_config  != '') {
		$is_modplayer_flashvars["adttext.config"] = $is_modplayer_adttext_config;
	}
}