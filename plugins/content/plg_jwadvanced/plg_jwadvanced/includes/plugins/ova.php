<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage ova.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('ova', $is_plgplayer_plugin_array)) {
	$is_plgplayer_ova_enabled = '1';
	$key = array_search( 'ova' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_ova_enabled = $params->get('ovaEnabled', '0');
}
if($is_plgplayer_ova_enabled == '1') {
	$is_plgplayer_plugin_array[] = 'ova';
	// set Json
	$is_plgplayer_ova_json_defaut = $params->get("ovajson", '');
	$is_plgplayer_ova_json_defaut = urlencode( $is_plgplayer_ova_json_defaut );
	if (!(empty($is_plgplayer_flashvars["ova.json"]))) {
		$is_plgplayer_ova_json = $is_plgplayer_flashvars["ova.json"];
		unset($is_plgplayer_flashvars["ova.json"]);
	} else {
		$is_plgplayer_ova_json  = $is_plgplayer_ova_json_defaut;
	}
	if($is_plgplayer_ova_json != "") {
		$is_plgplayer_flashvars["ova.json"] = $is_plgplayer_ova_json;
	}
	// set ova.companion
	if (!(empty($is_plgplayer_flashvars["ova.companion"]))) {
		$is_plgplayer_ova_companion = $is_plgplayer_flashvars["ova.companion"];
		unset($is_plgplayer_flashvars["ova.companion"]);
	} else {
		$is_plgplayer_ova_companion  = $params->get('ovacompanion', '0');
	}
	if ($is_plgplayer_ova_companion == 'true') {
		$is_plgplayer_ova_companion  = '1';
	} else if ($is_plgplayer_ova_companion == 'false') {
		$is_plgplayer_ova_companion  = '0';
	}
	// Load OVA companion css or not
	if ($is_plgplayer_ova_companion == '1')	{
		//set  clear css
		$is_plgplayer_ova_companion_clear_both_css_open = "<div style=\"clear: both;\">";
		$is_plgplayer_ova_companion_clear_both_css_closed = "</div>";
		// set ova.companionposition
		if (!(empty($is_plgplayer_flashvars["ova.companionposition"])))	{
			$is_plgplayer_ova_companion_position = $is_plgplayer_flashvars["ova.companionposition"];
			unset($is_plgplayer_flashvars["ova.companionposition"]);
		} else {
			$is_plgplayer_ova_companion_position = $params->get('ovacompanionposition', 'after');
		}
		// set ova.companioncsssrc  set CSS source
		if (!(empty($is_plgplayer_flashvars["ova.companioncsssrc"]))) {
			$is_plgplayer_ova_css_source = $is_plgplayer_flashvars["ova.companioncsssrc"];
			unset($is_plgplayer_flashvars["ova.companioncsssrc"]);
		} else {
			$is_plgplayer_ova_css_source = $params->get('ovacompanioncsssrc', 'preconfigure');
		}
		if ($is_plgplayer_ova_css_source == 'preconfigure')	{
			// set preconfigure CSS
			$count = 10;
			$index3 = 'companionbg';
			$index_defaut3 = 'CCCCCC';
			$index4 = 'companionheight';
			$index_defaut4 = '240';
			$index5 = 'companionwidth';
			$index_defaut5 = '200';
			$index6 = 'companionfloat';
			$index_defaut6 = 'left';
			$index7 = 'playerfloat';
			$index_defaut7 = 'left';
			$index8 = 'companionmargin';
			$index_defaut8 = '5';
			$index9 = 'companionmarginpos';
			$index_defaut9 = 'left';
			for ($i = 3; $i < $count; $i++)	{
				if (!(empty($is_plgplayer_flashvars["ova.".${'index'.$i}]))) {
					${"is_plgplayer_ova_".${"index".$i}} = $is_plgplayer_flashvars["ova.".${"index".$i}];
					unset($is_plgplayer_flashvars["ova.".${"index".$i}]);
				} else {
					${"is_plgplayer_ova_".${"index".$i}} = $params->get("ova".${"index".$i}, ${"index_defaut".$i});
				}
			}
			// set css
			$plgplayerfieldcssova_sfx =
			"
			<style type=\"text/css\">
			#jwplayer".$pluginclasspl_sfx." {
				float:".$is_plgplayer_ova_playerfloat.";
				width: ".$is_plgplayer_flashvars["width"]."px;
				height: ".$is_plgplayer_flashvars["height"]."px;
			}
			#companion".$pluginclasspl_sfx." {
				margin-".$is_plgplayer_ova_companionmarginpos.":".$is_plgplayer_ova_companionmargin."px;
				width: ".$is_plgplayer_ova_companionwidth."px;
				height: ".$is_plgplayer_ova_companionheight."px;
				background: #".$is_plgplayer_ova_companionbg.";
				float:".$is_plgplayer_ova_companionfloat.";
			}
			</style>
			";
			//set companion id in json
			$is_plgplayer_flashvars["ova.json"] = str_replace( "%22id%22%3A%22companion%22", "%22id%22%3A%22companion".$pluginclasspl_sfx."%22", $is_plgplayer_flashvars["ova.json"] );
		} else if ($is_plgplayer_ova_css_source == 'cssfields') {
			// set CSS fields
			if (!(empty($is_plgplayer_flashvars["ova.companioncss"]))) {
				$is_plgplayer_ova_companion_css_fields = $is_plgplayer_flashvars["ova.companioncss"];
				unset($is_plgplayer_flashvars["ova.companioncss"]);
			} else {
				$is_plgplayer_ova_companion_css_fields = $params->get('ovacompanioncss', 'after');
			}
			if (!(empty($is_plgplayer_flashvars["ova.playercss"])))	{
				$is_plgplayer_ova_player_css_fields = $is_plgplayer_flashvars["ova.playercss"];
				unset($is_plgplayer_flashvars["ova.playercss"]);
			} else {
				$is_plgplayer_ova_player_css_fields = $params->get('ovaplayercss', 'after');
			}
			// set css
			$plgplayerfieldcssova_sfx =
			"
			<style type=\"text/css\">
			#jwplayer".$pluginclasspl_sfx." {
				".$is_plgplayer_ova_player_css_fields."
			}
			#companion".$pluginclasspl_sfx." {
				".$is_plgplayer_ova_companion_css_fields."
			}
			</style>
			";
			//set companion id in json
			$is_plgplayer_flashvars["ova.json"] = str_replace( "%22id%22%3A%22companion%22", "%22id%22%3A%22companion".$pluginclasspl_sfx."%22", $is_plgplayer_flashvars["ova.json"] );
		} else if ($is_plgplayer_ova_css_source == 'cssfile') {
			// set css
			$plgplayerfieldcssova_sfx = "<link href=\"".$plug_pathway."css/ovacompanion.css\" rel=\"stylesheet\" type=\"text/css\" />";
			$pluginclasspl_sfx = $is_plgplayer_playlist_class;
		}
	}
}

// By pass the OVA companion css or not
if ($is_plgplayer_ova_enabled == '1' && $is_plgplayer_ova_companion == '1') {
	if ($is_plgplayer_ova_css_source != 'none')	{
		$document->addCustomTag($plgplayerfieldcssova_sfx);
	}
}