<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage default.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Check if the user have player file
if (($is_modplayer_playlist_select == '1' && $is_modplayer_playlist_file1 != '') || ($is_modplayer_playlist_select == '4' && $is_modplayer_playlist_botr_display != '' && $is_modplayer_playlist_botr_file != '') || ($is_modplayer_playlist_select == '0' && $is_modplayer_playlist_file != '') || ($is_modplayer_playlist_select == '3' && $is_modplayer_playlist_file != '') || ($is_modplayer_playlist_file1 != '' && $is_modplayer_playlist_select == '1') || ($is_modplayer_playlist_auto != '' && $is_modplayer_playlist_select == '2') || ($is_modplayer_playlist_json_field != '' && ($is_modplayer_playlist_select == '5' || $is_modplayer_playlist_select == '6'))) {
	if ($is_modplayer_popup_container != 'span') {
echo
"
<div align=\"center\" >";
	}
	// set swfobject load
	if ($moduleswf_sfx_founded == '0') {
		// set JS function cache parameters
		if ($modulecache_sfx == '0') {
			$document->addScript( $playersite."modules/mod_playerjr_ad/script/swfobject_2_2.js");
		} else {
		echo
		"
		<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/swfobject_2_2.js'></script>";
		}
	}
	// set extra js
	if ($is_modplayer_extra_js_sfx != '') {
		// set JS function cache parameters
		if ($modulecache_sfx == '0') {
			$document->addScript($playersite."modules/mod_playerjr_ad/script/".$is_modplayer_extra_js_sfx);
		} else {
		echo
		"
		<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/".$is_modplayer_extra_js_sfx."'></script>";
		}
	}
	// set jwbox load
	if ($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '2') {
		// set JS function cache parameters
		if ($modulecache_sfx == '0') {
			// set CSS Load
			if ($modulecssjwbox_sfx == '1') {
				JHTML::stylesheet("jwbox.css", $playersite."modules/mod_playerjr_ad/css/");
			} else if ($modulecssjwbox_sfx == '2') {
				$document->addCustomTag($modulefieldcssjwbox_sfx);
			}
			// set JQuery Load
			if ($modulejqueryjwbox_sfx_founded == '0') {
				$document->addScript( $playersite."modules/mod_playerjr_ad/script/jquery-1.7.2.min.js");
			}
			// Verify if mootools conflict is
			if ($modulemootoolsjwbox_sfx == '1') {
				if ($jversion != "1.5")	{
					JHTML::_('behavior.framework');
				} else {
					JHTML::_('behavior.mootools');
				}
				$document->addScriptDeclaration ( "jQuery.noConflict();" );
			}
			// set jquery.jwbox.js Load
			if ($modulejqueryjwboxjs_sfx == '2') {
				$document->addScript( $playersite."modules/mod_playerjr_ad/script/jquery.jwbox.js");
			}
		} else {
			// set CSS Load
			if ($modulecssjwbox_sfx == '1')	{
			echo
			"
			<link href=\"".$playersite."modules/mod_playerjr_ad/css/jwbox.css\" rel=\"stylesheet\" type=\"text/css\" />";
			} else if ($modulecssjwbox_sfx == '2') {
				echo $modulefieldcssjwbox_sfx;
			}
			// set JQuery Load
			if ($modulejqueryjwbox_sfx_founded == '0') {
			echo
			"
			<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/jquery-1.7.2.min.js'></script>";
			}
			// Verify if mootools conflict is
			if ($modulemootoolsjwbox_sfx == '1') {
				if ($jversion != "1.5")	{
					JHTML::_('behavior.framework');
				} else {
					JHTML::_('behavior.mootools');
				}
				echo
			"
			<script type=\"text/javascript\">jQuery.noConflict();</script>";
			}
			// set jquery.jwbox.js Load
			if ($modulejqueryjwboxjs_sfx == '2') {
			echo
			"
			<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/jquery.jwbox.js'></script>";
			}
		}
	}
	// set meta facebook load
	if ($module_meta_sfx_founded == '0' && $facebook_video_sharing == '1') {
		// set JS function cache parameters
		if ($modulecache_sfx == '0') {
			//load metatag
			$document->addCustomTag("<link rel=\"image_src\" href=\"".$facebook_video_sharing_thumbnail."\" />");
			$document->addCustomTag("<link rel=\"video_src\" href=\"".$player_metatag."\" />");
			$document->setMetaData("video_height", $is_modplayer_playlist_height_facebook);
			$document->setMetaData("video_width", $is_modplayer_playlist_width_facebook);
			$document->setMetaData("video_type", "application/x-shockwave-flash");
		} else {
			//load metatag
			echo
			"
			<link rel=\"image_src\" href=\"".$facebook_video_sharing_thumbnail."\" />
			<link rel=\"video_src\" href=\"".$player_metatag."\" />
			<meta name=\"video_height\" content=\"".$is_modplayer_playlist_height_facebook."\" />
			<meta name=\"video_width\" content=\"".$is_modplayer_playlist_width_facebook."\" />
			<meta name=\"video_type\" content=\"application/x-shockwave-flash\" />";
		}
	}
	// set ova css load
	if ($is_modplayer_ova_enabled == '1' && $is_modplayer_ova_companion == '1') {
		// set JS function cache parameters
		if ($modulecache_sfx == '0' && $is_modplayer_ova_css_source != 'none') {
			$document->addCustomTag($modulefieldcssova_sfx);
		} else if ($is_modplayer_ova_css_source != 'none') {
			echo
			$modulefieldcssova_sfx;
		}
	}
	// set gapro  load
	if ($is_modplayer_gapro_enabled == '1' && $is_modplayer_gapro_version == 'gapro-2' && (!(empty($modulefieldAsynchronous_Tracking_sfx)))) {
		// getting module head section datas
		unset($headDataply);
		$module_meta_gapro_founded = '0';
		$headDataply = $document->getHeadData();
		// generate keys of custom  section
		$headDataply_keys = $headDataply["custom"];
		// searching phrase $is_modplayer_gapro_accountid in custom paths
		for ($i = 0;$i < count($headDataply_keys); $i++) {
			if (preg_match("['_setAccount', '".$is_modplayer_gapro_accountid."']", $headDataply_keys[$i])) {
				// if founded set variable to true and break loop
				$module_meta_gapro_founded = '1';
				break;
			}
		}
		if ($module_meta_gapro_founded == '0') {
			// set JS function cache parameters
			if ($modulecache_sfx == '0') {
				$document->addCustomTag($modulefieldAsynchronous_Tracking_sfx);
			} else {
				echo
				$modulefieldAsynchronous_Tracking_sfx;
			}
		}
	}
	//Check if html5 display
	if ($jw_html5 == '1') {
		// set jquery.jwplayer.js load
		if ($modulehtml5js_sfx == '1') {
			// set JS function cache parameters
			if ($modulecache_sfx == '0') {
				$document->addScript( $playersite."modules/mod_playerjr_ad/script/jwplayer.js");
			} else {
				echo
				"
				<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/jwplayer.js'></script>";
			}
		}
		// set jquery.iscroll.js load
		if ($is_modplayer_iscrolljs_sfx == '1') {
			// set JS function cache parameters
			if ($modulecache_sfx == '0') {
				$document->addScript( $playersite."modules/mod_playerjr_ad/script/iscroll.js");
			} else {
				echo
				"
				<script type='text/javascript' src='".$playersite."modules/mod_playerjr_ad/script/iscroll.js'></script>";
			}
		}
	}
	//Check if the pop-up link overide the player
	if (($is_modplayer_popup_enabled == '1' && ($is_modplayer_popup_linkchoice == '0' || $is_modplayer_popup_linkchoice == '1' || $is_modplayer_popup_linkchoice == '2')) || $is_modplayer_popup_enabled == '0') {
		//Check if botr display
		if ($is_modplayer_playlist_select == '4' && $is_modplayer_playlist_botr_display == '0' && $is_modplayer_playlist_botr_file != '') {
			echo
			$is_modplayer_playlist_botr_file;
		} else {
			// By pass the OVA companion div or not
			if ($is_modplayer_ova_enabled == '1' && $is_modplayer_ova_companion == '1' && $is_modplayer_ova_companion_position == 'before')	{
			echo
			"
			<div id='companion".$moduleclasspl_sfx."'></div>";
			}
			// By pass the adsolution div id or not
			if ($is_modplayer_playlist_adsenabled == 'ltas') {
			echo
			"
			<div class='ltas-ad' id='mediaspacemod".$moduleclasspl_sfx."'>
				<div id='jwplayer".$moduleclasspl_sfx."'>".$is_modplayer_flash."</div>
			</div>";
			} else {
			echo
			"
			<div id='jwplayer".$moduleclasspl_sfx."'>".$is_modplayer_flash."</div>";
			}
			// By pass the OVA companion div or not
			if ($is_modplayer_ova_enabled == '1' && $is_modplayer_ova_companion == '1' && $is_modplayer_ova_companion_position == 'after') {
			echo
			"
			<div id='companion".$moduleclasspl_sfx."'></div>";
			}
			echo
			"
			<script type='text/javascript'>";
			// Valid or not script for player event
			if ($is_modplayer_playlist_select =='3' && $jw_html5 == '0') {
				if ($is_modplayer_playlist_multiple_dropdown == '1') {
				echo
				"
				var player = null;
				function playerReady(jwplayer".$moduleclasspl_sfx.")
				{
					jwplayer".$moduleclasspl_sfx." = window.document[jwplayer".$moduleclasspl_sfx.".id];
				}";
				}
			}
			// Valid or not script according to html 5
			if ($jw_html5 == '0') {
			echo
			"
				var flashvars =
				{
					'".$is_modplayer_playlisttype."': '".$is_modplayer_playlist."',
					";
					$i = 1;
					while (list($key, $value) = each($is_modplayer_flashvars)) {
						if ($i > 1)	{
					echo
					",
					";
						}
						echo
					"'".$key."': '".$value."'";
					$i++;
					}
					reset($is_modplayer_flashvars);
					// Valid or not the plugin sharing link for the player
					if ($is_modplayer_sharing_enabled != '') {
					echo
					",
					'sharing.code': encodeURIComponent('<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_flashvars["width"]."\" height=\"".$is_modplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
					while (list($key, $value) = each($is_modplayer_flashvars)) {
					echo
					"&amp;".$key."=".$value;
					}
					reset($is_modplayer_flashvars);
					echo
					"\" />')";
					}
					echo
					"
				};
				var params =
				{
					'allowfullscreen': 'true',
					'allowscriptaccess': 'always',
					'wmode': '".$is_modplayer_flashvars["wmode"]."',
					'allownetworking': 'all'
				};
				var attributes =
				{
					'id': 'jwplayer".$moduleclasspl_sfx."',
					'name': 'jwplayer".$moduleclasspl_sfx."'
				};
				swfobject.embedSWF('".$moduleswf_player."', 'jwplayer".$moduleclasspl_sfx."', '".$is_modplayer_flashvars["width"]."', '".$is_modplayer_flashvars["height"]."', '9', false, flashvars, params, attributes);";
			}
			//Check if html5 display
			if ($jw_html5 == '1') {
			echo
				"
				jwplayer('jwplayer".$moduleclasspl_sfx."').setup({";
					//set playlist
					if ($is_modplayer_playlist_select == '1' && !(empty($is_modplayer_playlist_json_flash))) {
					//set fallback
					if ($jw_fallback == "HTML5") {
					echo
					"
					'modes': [
						{
							'type': 'flash',
							'src': '".$moduleswf_player."',
							'config': {";
							// Load JSON playlist
							echo $is_modplayer_playlist_json_flash;
							echo
							"}	
						},
						{
							'type': 'html5',
							'config': {";
							// Load JSON playlist
							echo $is_modplayer_playlist_json_html5;
							echo
							"}	
						}";
					} else if ($jw_fallback == "JW5") {
					echo
					"
					'modes': [
						{
							'type': 'html5',
							'config': {";
							// Load JSON playlist
							echo $is_modplayer_playlist_json_html5;
							echo
							"}	
						},
						{
							'type': 'flash',
							'src': '".$moduleswf_player."',
							'config': {";
							// Load JSON playlist
							echo $is_modplayer_playlist_json_flash;
							echo
							"}
						}";
					}
					//set download fallback
					if ($is_modplayer_playlist_fallback_download == "1") {
					echo
					",
						{
							'type': 'download',
							'config': {";
							// Load JSON playlist
							echo $is_modplayer_playlist_json_download;
							echo
							"}
						}";
					}
					echo
					"
					]";
					//remove playlistfile and file only when playlist editor is set
					unset ($is_modplayer_flashvars["playlistfile"]);
					unset ($is_modplayer_flashvars["file"]);
					} else {
					if ($is_modplayer_playlist_select == '5') {
					echo
					"
					".$is_modplayer_playlist_json_field.",";
					} else if ($is_modplayer_playlist_select == '6') {
					echo
					"
					".$is_modplayer_playlist_json_field."";
					} else {
					//remove url encode flashvar for jwplayer.js compatibilty
					//remove url encode for playlistfile
					if (!(empty($is_modplayer_playlist))) {
						$is_modplayer_playlist = urldecode($is_modplayer_playlist);
					}
					echo
					"
					'".$is_modplayer_playlisttype."': '".$is_modplayer_playlist."',";
					}
					if ($is_modplayer_playlist_select != '6') {
					//set fallback
					if ($jw_fallback == "HTML5") {
					echo
					"
					'modes': [
						{ 'type': 'flash', 'src': '".$moduleswf_player."' },
						{ 'type': 'html5' }";
					} else if ($jw_fallback == "JW5") {
					echo
					"
					'modes': [
						{ 'type': 'html5' },
						{ 'type': 'flash', 'src': '".$moduleswf_player."' }";
					}
					//set download fallback
					if ($is_modplayer_playlist_fallback_download == "1") {
					echo
					",
						{ 'type': 'download' }";
					}
					echo
					"
					]";
					}
					}
					//load plugin for html5 5.6
					if (!(empty($is_modplayer_plugin_array))) {
					unset ($is_modplayer_flashvars["plugins"]);
					$i = 1;
					echo
					",
					'plugins': {";
					while (list($key, $value) = each($is_modplayer_plugin_array)) {
					if ($i > 1)
					{
					echo
					",";
					}
					echo
					"
						'".$value."' : {}";
					$i++;
					}
					echo
					"	
					}";
					reset($is_modplayer_plugin_array);
					}
					//clear incompatible flashvars for html5
					//remove url encode flashvar for jwplayer.js compatibilty
					//remove url encode for sharing.link
					if (!(empty($is_modplayer_flashvars["sharing.link"]))) {
						$is_modplayer_flashvars["sharing.link"] = urldecode($is_modplayer_flashvars["sharing.link"]);
					}
					//remove url encode for ova.json
					if (!(empty($is_modplayer_flashvars["ova.json"])) && ($is_modplayer_ova_enabled == '1')) {
						$is_modplayer_flashvars["ova.json"] = urldecode($is_modplayer_flashvars["ova.json"]);
					}
					//load events
					if ($is_modplayer_events != '')	{
					echo
					",
					'events': ".$is_modplayer_events."";
					}
					//set flashvars
					while (list($key, $value) = each($is_modplayer_flashvars)) {
					echo
					",
					'".$key."': '".$value."'";
					}
					reset($is_modplayer_flashvars);
					// Valid or not the plugin sharing link for the player
					if ($is_modplayer_sharing_enabled != '') {
					echo
					",
					'sharing.code': '<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_flashvars["width"]."\" height=\"".$is_modplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
					while (list($key, $value) = each($is_modplayer_flashvars)) {
					echo
					"&amp;".$key."=".$value;
					}
					reset($is_modplayer_flashvars);
					echo
					"\" />'";
					}
					// Valid or not the embed viral code for the player only if JSON playlist is set
					if ($is_modplayer_viral_enabled == '1' && ($is_modplayer_playlist_select == '1' && !(empty($is_modplayer_playlist_json_flash)))) {
					echo
					",
					'viral.embed': '<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_flashvars["width"]."\" height=\"".$is_modplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
					while (list($key, $value) = each($is_modplayer_flashvars)) {
					echo
					"&amp;".$key."=".$value;
					}
					reset($is_modplayer_flashvars);
					echo
					"\" />'";
					}
			echo
			"
				});";
			}
			echo
			"
			</script>
			";
			// Valid or not script for player event
			if ($is_modplayer_playlist_select =='3') {
			if ($is_modplayer_playlist_multiple_dropdown == '1') {
			echo
			"
			<br/>";
			if ($jw_html5 == '0') {
			echo
			"
			<select name=\"sel".$moduleclasspl_sfx."\" onchange=\"javascript:jwplayer".$moduleclasspl_sfx.".sendEvent('STOP'); jwplayer".$moduleclasspl_sfx.".sendEvent('LOAD', this.value);\" ".$is_modplayer_playlist_multiple_dropdown_class.">";
			} else {
			echo
			"
			<select name=\"sel".$moduleclasspl_sfx."\" onchange=\"jwplayer('jwplayer".$moduleclasspl_sfx."').stop(); jwplayer('jwplayer".$moduleclasspl_sfx."').load(this.value);\" ".$is_modplayer_playlist_multiple_dropdown_class.">";
			}
			echo
			"
				<option value=\"".$multiple_playlist[0]."\" selected=\"selected\">Select a Playlist</option>";
				$i = 0;
				while (!(empty($multiple_playlist[$i]))) {
					echo
					"
				<option value=\"".$multiple_playlist[$i]."\">".$multiple_playlist_title[$i]."</option>";
					$i++;
				}
				echo
				"
			</select>
			";
			}
			}
		}
	}
	// Valid or not the pop-up
	if ($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '0') {
	echo
	"
	<div align=\"center\" ".$is_modplayer_ova_companion_clear_both_css.">
		<a title=\"".$is_modplayer_popup_text."\" onmouseover=\"window.status='".$is_modplayer_popup_text."';return true\" onfocus=\"window.status='".$is_modplayer_popup_text."';return true\" onmouseout=\"window.status=''\" href=\"JavaScript:void(0)\" onclick=\"window.open('".$moduleswf_player.$moduleswf_signplayer."&amp;".$is_modplayer_playlisttype."=".$is_modplayer_playlist2."&amp;allowfullscreen=true&amp;allowscriptaccess=always";
		while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
			echo
			"&amp;".$key."=".$value;
		}
		reset($is_modplayer_flashvars_popup);
		// Valid or not the plugin sharing link for the player
		if ($is_modplayer_sharing_enabled != '') {
			echo
			"&amp;sharing.code=&lt;embed src=&quot;".$moduleswf_player."&quot; width=&quot;".$is_modplayer_playlist_popupwidth."&quot; height=&quot;".$is_modplayer_playlist_popupheight."&quot; allowscriptaccess=&quot;always&quot; allowfullscreen=&quot;true&quot; flashvars=&quot;".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
			while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
				echo
				"%26amp;".$key."=".$value;
			}
			reset($is_modplayer_flashvars_popup);
			echo
			"&quot; /&gt;";
		}
		echo
		"','windows".$moduleclasspl_sfx."','left=1,top=1,menubar=0,location=no,status=0,width=".$is_modplayer_playlist_popupwidth.",height=".$is_modplayer_playlist_popupheight.",toolbar=0,resizable=0,scrollbars=0');\">".$is_modplayer_popup_link;
		if ($is_modplayer_popup_linkchoice == '2' || $is_modplayer_popup_linkchoice == '5') {
			echo
			"<br />
			".$is_modplayer_popup_text;
		}
		echo
		"</a>
	</div>";
	}
	// Valid or not the highslide pop-up
	if ($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '1') {
	echo
	"
	<div align=\"center\" ".$is_modplayer_ova_companion_clear_both_css.">
	<a href=\"".$moduleswf_player."\" onclick=\"return hs.htmlExpand
		(this,
			{
				objectType:	'swf',
				swfOptions:
				{
					version: '9',
					flashvars:
					{
						'".$is_modplayer_playlisttype."': '".$is_modplayer_playlist."',
						";
						$i = 1;
						while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
							if ($i > 1) {
						echo
						",
						";
							}
							echo
						"'".$key."': '".$value."'";
						$i++;
						}
						reset($is_modplayer_flashvars_popup);
						// Valid or not the plugin sharing link for the player
						if ($is_modplayer_sharing_enabled != '') {
						echo
						",
						'sharing.code': encodeURIComponent('<embed src=&quot;".$moduleswf_player."&quot; width=&quot;".$is_modplayer_playlist_popupwidth."&quot; height=&quot;".$is_modplayer_playlist_popupheight."&quot; allowscriptaccess=&quot;always&quot; allowfullscreen=&quot;true&quot; flashvars=&quot;".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
						while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
						echo
						"&amp;".$key."=".$value;
						}
						reset($is_modplayer_flashvars_popup);
						echo
						"&quot; />')";
						}
						echo
						"
					},
					params:
					{
						'allowfullscreen': 'true',
						'allowscriptaccess': 'always',
						'wmode': '".$is_modplayer_flashvars_popup["wmode"]."',
						'allownetworking': 'all'
					},
					attributes:
					{
						'id': 'jwplayerpop".$moduleclasspl_sfx."',
						'name': 'jwplayerpop".$moduleclasspl_sfx."'
					}
				},
				width: ".$is_modplayer_playlist_popupwidth.",
				objectWidth: ".$is_modplayer_playlist_popupwidth.",
				objectHeight: ".$is_modplayer_playlist_popupheight.",
				maincontentText: '".$is_modplayer_flash2."'
			}
		)\" class=\"highslide\">
	".$is_modplayer_popup_link;
	if ($is_modplayer_popup_linkchoice == '2' || $is_modplayer_popup_linkchoice == '5') {
	echo
	"<br />
	".$is_modplayer_popup_text;
	}
	echo
	"</a>
	</div>";
	}
		// Valid or not the JWBox pop-up
	if ($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '2') {
	echo
	"<".$is_modplayer_popup_container." class=\"jwbox\">
		<a href=\"#\">".$is_modplayer_popup_link."</a>";
		if ($is_modplayer_popup_linkchoice == '2' || $is_modplayer_popup_linkchoice == '5') {
		echo
		"
		<br />
		<a href=\"#\">".$is_modplayer_popup_text."</a>";
		}
		echo
		"
		<".$is_modplayer_popup_container." class=\"jwbox_hidden\">
			<".$is_modplayer_popup_container." class=\"jwbox_content\">";
				//Check if botr display
				if ($is_modplayer_playlist_select == '4' && $is_modplayer_playlist_botr_display == '0' && $is_modplayer_playlist_botr_file != '') {
					echo
					$is_modplayer_playlist_botr_file;
				} else {
					echo
					"
					<".$is_modplayer_popup_container." id='jwplayer".$moduleclasspl_sfx."pop'>".$is_modplayer_flash."</".$is_modplayer_popup_container.">
					<script type='text/javascript'>";
					// Valid or not script for player event
					if ($is_modplayer_playlist_select =='3' && $jw_html5 == '0') {
						if ($is_modplayer_playlist_multiple_dropdown == '1') {
						echo
						"
						var player = null;
						function playerReady(jwplayer".$moduleclasspl_sfx."pop)
						{
							jwplayer".$moduleclasspl_sfx."pop = window.document[jwplayer".$moduleclasspl_sfx."pop.id];
						}";
						}
					}
					// Valid or not script according to html 5
					if ($jw_html5 == '0') {
						echo
						"
						var flashvars =
						{
							'".$is_modplayer_playlisttype."': '".$is_modplayer_playlist."',
							";
							$i = 1;
							while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
								if ($i > 1)	{
							echo
							",
							";
								}
								echo
							"'".$key."': '".$value."'";
							$i++;
							}
							reset($is_modplayer_flashvars_popup);
							// Valid or not the plugin sharing link for the player
							if ($is_modplayer_sharing_enabled != '') {
							echo
							",
							'sharing.code': encodeURIComponent('<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_playlist_popupwidth."\" height=\"".$is_modplayer_playlist_popupheight."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
								while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
							echo
							"&amp;".$key."=".$value;
							}
							reset($is_modplayer_flashvars_popup);
							echo
							"\" />')";
							}
							echo
							"
						};
						var params =
						{
							'allowfullscreen': 'true',
							'allowscriptaccess': 'always',
							'wmode': '".$is_modplayer_flashvars_popup["wmode"]."',
							'allownetworking': 'all'
						};
						var attributes =
						{
							'id': 'jwplayer".$moduleclasspl_sfx."pop',
							'name': 'jwplayer".$moduleclasspl_sfx."pop'
						};
						swfobject.embedSWF('".$moduleswf_player."', 'jwplayer".$moduleclasspl_sfx."pop', '".$is_modplayer_playlist_popupwidth."', '".$is_modplayer_playlist_popupheight."', '9', false, flashvars, params, attributes);";
					}
					//Check if html5 display
					if ($jw_html5 == '1') {
					echo
						"
						jwplayer('jwplayer".$moduleclasspl_sfx."pop').setup({";
							//set playlist
							if ($is_modplayer_playlist_select == '1' && !(empty($is_modplayer_playlist_json_flash))) {
							//set fallback
							if ($jw_fallback == "HTML5") {
							echo
							"
							'modes': [
								{
									'type': 'flash',
									'src': '".$moduleswf_player."',
									'config': {";
									// Load JSON playlist
									echo $is_modplayer_playlist_json_flash;
									echo
									"}	
								},
								{
									'type': 'html5',
									'config': {";
									// Load JSON playlist
									echo $is_modplayer_playlist_json_html5;
									echo
									"}	
								}";
							} else if ($jw_fallback == "JW5") {
							echo
							"
							'modes': [
								{
									'type': 'html5',
									'config': {";
									// Load JSON playlist
									echo $is_modplayer_playlist_json_html5;
									echo
									"}	
								},
								{
									'type': 'flash',
									'src': '".$moduleswf_player."',
									'config': {";
									// Load JSON playlist
									echo $is_modplayer_playlist_json_flash;
									echo
									"}
								}";
							}
							//set download fallback
							if ($is_modplayer_playlist_fallback_download == "1") {
							echo
							",
								{
									'type': 'download',
									'config': {";
									// Load JSON playlist
									echo $is_modplayer_playlist_json_download;
									echo
									"}
								}";
							}
							echo
							"
							]";
							//remove playlistfile and file only when playlist editor is set
							unset ($is_modplayer_flashvars_popup["playlistfile"]);
							unset ($is_modplayer_flashvars_popup["file"]);
							} else {
							if ($is_modplayer_playlist_select == '5') {
							echo
							"
							".$is_modplayer_playlist_json_field.",";
							} else if ($is_modplayer_playlist_select == '6') {
							echo
							"
							".$is_modplayer_playlist_json_field."";
							} else {
							//remove url encode flashvar for jwplayer.js compatibilty
							//remove url encode for playlistfile
							if (!(empty($is_modplayer_playlist))) {
								$is_modplayer_playlist = urldecode($is_modplayer_playlist);
							}
							echo
							"
							'".$is_modplayer_playlisttype."': '".$is_modplayer_playlist."',";
							}
							if ($is_modplayer_playlist_select != '6') {
							//set fallback
							if ($jw_fallback == "HTML5") {
							echo
							"
							'modes': [
								{ 'type': 'flash', 'src': '".$moduleswf_player."' },
								{ 'type': 'html5' }";
							} else if ($jw_fallback == "JW5") {
							echo
							"
							'modes': [
								{ 'type': 'html5' },
								{ 'type': 'flash', 'src': '".$moduleswf_player."' }";
							}
							//set download fallback
							if ($is_modplayer_playlist_fallback_download == "1") {
							echo
							",
								{ 'type': 'download' }";
							}
							echo
							"
							]";
							}
							}
							//load plugin for html5 5.6
							if (!(empty($is_modplayer_plugin_array))) {
							unset ($is_modplayer_flashvars_popup["plugins"]);
							$i = 1;
							echo
							",
							'plugins': {";
							while (list($key, $value) = each($is_modplayer_plugin_array)) {
							if ($i > 1)
							{
							echo
							",";
							}
							echo
							"
								'".$value."' : {}";
							$i++;
							}
							echo
							"	
							}";
							reset($is_modplayer_plugin_array);
							}
							//clear incompatible flashvars for html5
							//remove url encode flashvar for jwplayer.js compatibilty
							//remove url encode for sharing.link
							if (!(empty($is_modplayer_flashvars_popup["sharing.link"]))) {
								$is_modplayer_flashvars_popup["sharing.link"] = urldecode($is_modplayer_flashvars_popup["sharing.link"]);
							}
							//remove url encode for ova.json
							if (!(empty($is_modplayer_flashvars_popup["ova.json"])) && ($is_modplayer_ova_enabled == '1')) {
								$is_modplayer_flashvars_popup["ova.json"] = urldecode($is_modplayer_flashvars_popup["ova.json"]);
							}
							//load events
							if ($is_modplayer_events != '')	{
							echo
							",
							'events': ".$is_modplayer_events."";
							}
							//set flashvars
							while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
							echo
							",
							'".$key."': '".$value."'";
							}
							reset($is_modplayer_flashvars_popup);
							// Valid or not the plugin sharing link for the player
							if ($is_modplayer_sharing_enabled != '') {
							echo
							",
							'sharing.code': '<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_flashvars_popup["width"]."\" height=\"".$is_modplayer_flashvars_popup["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
							while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
							echo
							"&amp;".$key."=".$value;
							}
							reset($is_modplayer_flashvars_popup);
							echo
							"\" />'";
							}
							// Valid or not the embed viral code for the player only if JSON playlist is set
							if ($is_modplayer_viral_enabled == '1' && ($is_modplayer_playlist_select == '1' && !(empty($is_modplayer_playlist_json_flash)))) {
							echo
							",
							'viral.embed': '<embed src=\"".$moduleswf_player."\" width=\"".$is_modplayer_flashvars_popup["width"]."\" height=\"".$is_modplayer_flashvars_popup["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
							while (list($key, $value) = each($is_modplayer_flashvars_popup)) {
							echo
							"&amp;".$key."=".$value;
							}
							reset($is_modplayer_flashvars_popup);
							echo
							"\" />'";
							}
					echo
					"
						});";
					}
					echo
					"
					</script>";
					// Valid or not script for player event
					if ($is_modplayer_playlist_select =='3') {
					if ($is_modplayer_playlist_multiple_dropdown == '1') {
					echo
					"
					<br/>";
					if ($jw_html5 == '0') {
					echo
					"
					<select name=\"sel".$moduleclasspl_sfx."pop\" onchange=\"javascript:jwplayer".$moduleclasspl_sfx."pop.sendEvent('STOP'); jwplayer".$moduleclasspl_sfx."pop.sendEvent('LOAD', this.value);\" ".$is_modplayer_playlist_multiple_dropdown_class_popup.">";
					} else {
					echo
					"
					<select name=\"sel".$moduleclasspl_sfx."pop\" onchange=\"jwplayer('jwplayer".$moduleclasspl_sfx."pop').stop(); jwplayer('jwplayer".$moduleclasspl_sfx."pop').load(this.value);\" ".$is_modplayer_playlist_multiple_dropdown_class_popup.">";
					}
					echo
					"
						<option value=\"".$multiple_playlist[0]."\" selected=\"selected\">Select a Playlist</option>";
						$i = 0;
						while (!(empty($multiple_playlist[$i]))) {
							echo
							"
						<option value=\"".$multiple_playlist[$i]."\">".$multiple_playlist_title[$i]."</option>";
							$i++;
						}
						echo
						"
					</select>";
					}
					}
				}
			echo
			"
			</".$is_modplayer_popup_container.">
		</".$is_modplayer_popup_container.">
	</".$is_modplayer_popup_container.">";
	}
if ($is_modplayer_popup_container != 'span') {
	echo
	"
</div>
";
}
}