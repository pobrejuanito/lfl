<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage ova.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_ova_enabled = $params->get('ovaEnabled');
	$is_modplayer_ova_companion = $params->get('ovacompanion');
	$is_modplayer_ova_companion_position = $params->get('ovacompanionposition');
	$is_modplayer_ova_companion_clear_both_css = "";
if($is_modplayer_ova_enabled == '1') {
	//load plugin
	$is_modplayer_plugin_array[] = 'ova';
	// set Json
	$is_modplayer_ova_json = $params->get("ovajson");
	$is_modplayer_ova_json = urlencode( $is_modplayer_ova_json );
	$is_modplayer_flashvars["ova.json"] = $is_modplayer_ova_json;
	// Load OVA companion css or not
	if ($is_modplayer_ova_enabled == '1' && $is_modplayer_ova_companion == '1')	{
		// set CSS source
		$is_modplayer_ova_css_source = $params->get('ovacompanioncsssrc');
		$is_modplayer_ova_companion_clear_both_css = "style=\"clear: both;\"";
		if ($is_modplayer_ova_css_source == 'preconfigure') {
			// set preconfigure CSS
			$is_modplayer_ova_companion_background = $params->get('ovacompanionbg');
			$is_modplayer_ova_companion_height = $params->get('ovacompanionheight');
			$is_modplayer_ova_companion_width = $params->get('ovacompanionwidth');
			$is_modplayer_ova_companion_float = $params->get('ovacompanionfloat');
			$is_modplayer_ova_player_float = $params->get('ovaplayerfloat');
			$is_modplayer_ova_companion_margin = $params->get('ovacompanionmargin');
			$is_modplayer_ova_companion_margin_position = $params->get('ovacompanionmarginpos');
			// set css
			$modulefieldcssova_sfx =
			"
			<style type=\"text/css\">
			#jwplayer".$moduleclasspl_sfx." {
				float:".$is_modplayer_ova_player_float.";
				width: ".$is_modplayer_flashvars["width"]."px;
				height: ".$is_modplayer_flashvars["height"]."px;
			}
			#companion".$moduleclasspl_sfx." {
				margin-".$is_modplayer_ova_companion_margin_position.":".$is_modplayer_ova_companion_margin."px;
				width: ".$is_modplayer_ova_companion_width."px;
				height: ".$is_modplayer_ova_companion_height."px;
				background: #".$is_modplayer_ova_companion_background.";
				float:".$is_modplayer_ova_companion_float.";
			}
			</style>
			";
		} else if ($is_modplayer_ova_css_source == 'cssfields') {
			// set CSS fields
			$is_modplayer_ova_companion_css_fields = $params->get('ovacompanioncss');
			$is_modplayer_ova_player_css_fields = $params->get('ovaplayercss');
			// set css
			$modulefieldcssova_sfx =
			"
			<style type=\"text/css\">
			#jwplayer".$moduleclasspl_sfx." {
				".$is_modplayer_ova_player_css_fields."
			}
			#companion".$moduleclasspl_sfx." {
				".$is_modplayer_ova_companion_css_fields."
			}
			</style>
			";
		} else if ($is_modplayer_ova_css_source == 'cssfile') {
			// set css
			$modulefieldcssova_sfx = "<link href=\"".$playersite."modules/mod_playerjr_ad/css/ovacompanion.css\" rel=\"stylesheet\" type=\"text/css\" />";
		}
	}
}