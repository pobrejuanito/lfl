<?php
/**
 *Jw Player Plugin Advanced : plg_jwadvanced
 * @version plg_jwadvanced$Id$
 * @package plg_jwadvanced
 * @subpackage default.php
 * @author joomlarulez.
 * @copyright (C) www.joomlarulez.com
 * @license Limited  http://www.gnu.org/licenses/gpl.html
 * final 1.13.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Check if the pop-up link overide the player
if ((($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') && ($is_plgplayer_popup_linkchoice == '0' || $is_plgplayer_popup_linkchoice == '1' || $is_plgplayer_popup_linkchoice == '2')) || ($is_plgplayer_playlist_popup == 'none' || $is_plgplayer_playlist_popup == 'off')) {

    $return
        .= "<div class=\"".$is_plgplayer_playlist_class." monitor\">";
    //Check if botr display
    if ($is_plgplayer_playlist_botr == true && $is_plgplayer_playlist_botr_display == 'botr') {
        if ($is_plgplayer_playlist_botr_file != '') {
            $return
                .= "".$is_plgplayer_playlist_botr_file."";
        }
    } else {
        // By pass the OVA companion div or not
        if ($is_plgplayer_ova_enabled == '1' && $is_plgplayer_ova_companion == '1' && $is_plgplayer_ova_companion_position == 'before')
        {
            $return
                .= "
	<div id='companion".$pluginclasspl_sfx."'></div>";
        }
        // By pass the adsolution div id or not
        if ($is_plgplayer_playlist_adsenabled == true) {
            $return
                .= "
	<div class='ltas-ad' id='mediaspaceplg".$pluginclasspl_sfx."'>
		<div id='jwplayer".$pluginclasspl_sfx."'>".$is_plgplayer_flash."</div>
	</div>";
        } else {
            $return
                .= "
	<div id='jwplayer".$pluginclasspl_sfx."'>".$is_plgplayer_flash."</div>
	";
        }
        // By pass the OVA companion div or not
        if ($is_plgplayer_ova_enabled == '1' && $is_plgplayer_ova_companion == '1' && $is_plgplayer_ova_companion_position == 'after') {
            $return
                .= "
	<div id='companion".$pluginclasspl_sfx."'></div>";
        }
        $return
            .= "
	<script type='text/javascript'>";
        // Valid or not script for player event this only for 4.x api
        if ($is_plgplayer_playlist_multiple_dropdown == '1' && $jw_html5 == '0') {
            $return
                .= "
		var player = null;
		function playerReady(jwplayer".$pluginclasspl_sfx.")
		{
			jwplayer".$pluginclasspl_sfx." = window.document[jwplayer".$pluginclasspl_sfx.".id];
		}";
        }

        // Valid or not script according to html 5
        if ($jw_html5 == '0') {

            $return
                .= "
		var flashvars =
		{
			";
            $i = 1;
            while (list($key, $value) = each($is_plgplayer_flashvars)) {
                if ($i > 1)	{
                    $return
                        .= ",
			";
                }
                $return
                    .= "'".$key."': '".$value."'";
                $i++;
            }
            reset($is_plgplayer_flashvars);
            //'flashvars': '".$is_plgplayer_flashvars_string."'";
            // Valid or not the plugin sharing code for the player
            if ($is_plgplayer_sharing_enabled == '1') {
                $return
                    .= ",
			'sharing.code': encodeURIComponent('<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars["width"]."\" height=\"".$is_plgplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />')";
            }
            $return
                .= "
		};
		var params =
		{
			'allowfullscreen': 'true',
			'allowscriptaccess': 'always',
			'allownetworking': 'all',
			'wmode': '".$is_plgplayer_flashvars["wmode"]."'
		};
		var attributes =
		{
			'id': 'jwplayer".$pluginclasspl_sfx."',
			'name': 'jwplayer".$pluginclasspl_sfx."'
		};
		swfobject.embedSWF('".$plgswf_player."', 'jwplayer".$pluginclasspl_sfx."', '".$is_plgplayer_flashvars["width"]."', '".$is_plgplayer_flashvars["height"]."', '9', false, flashvars, params, attributes);";
        }
        //Check if html5 display
        if ($jw_html5 == '1') {
            $return
                .= "
		jwplayer('jwplayer".$pluginclasspl_sfx."').setup({";
            //set simple playlist editor playlist
            if (!(empty($is_plgplayer_flashvars_html5["playlistfile"])) && !(empty($is_plgplayer_playlist_file1)) && (empty($is_plgplayer_playlist_json_flash_1))) {
                $return
                    .= "
			'playlist': [";
                for($i = 1; $i < 51; ++$i) {
                    if (!(empty(${"is_plgplayer_playlist_file".$i}))) {
                        //set file
                        if ($i > 1)	{
                            $return
                                .= ",";
                        }
                        $return //JSON Playlist Editor
                            .= "
				{
					'file': '".${"is_plgplayer_playlist_file".$i}."'";
                        //set variable
                        $index1 = "captions.file".$i;
                        $index2 = "title".$i;
                        $index3 = "description".$i;
                        $index4 = "author".$i;
                        $index5 = "image".$i;
                        $index6 = "link".$i;
                        $index7 = "start".$i;
                        $index8 = "streamer".$i;
                        $index9 = "duration".$i;
                        $index10 = "provider".$i;
                        $index11 = "tags".$i;
                        $index12 = "hd.file".$i;
                        $index13 = "sharing.link".$i;
                        for ($i2 = 1; $i2 < 14; $i2++) {
                            if (!(empty(${'is_plgplayer_playlist_'.${'index'.$i2}}))) {
                                $is_plgplayer_playlist_var = str_replace( $i, "", ${'index'.$i2});
                                ${'is_plgplayer_playlist_'.${'index'.$i2}} = addslashes(${'is_plgplayer_playlist_'.${'index'.$i2}});
                                $return
                                    .= ",
					'".$is_plgplayer_playlist_var."': '".${'is_plgplayer_playlist_'.${'index'.$i2}}."'";
                            }
                        }
                        $return
                            .= "
				}";
                    }
                }
                $return
                    .= "
			],";
                //clear incompatible flashvars when playlist is set in html5
                unset ($is_plgplayer_flashvars_html5["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5["file"]);
                $return
                    .= "
			'modes': [
				{ ".$jw_fallback1." },
				{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
				{ 'type': 'download' }";
                }
                $return
                    .= "
			]";
            } else if (!(empty($is_plgplayer_playlist_json_flash_1))) {
                $return
                    .= "
			'modes': [
				{
					".$jw_fallback1.",
					'config': {
						'playlist': [";
                // Load JSON playlist
                for($i = 1; $i < 51; ++$i)
                {
                    if (!(empty(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i}["file"])))
                    {
                        //set file
                        if ($i > 1)
                        {
                            $return
                                .= ",";
                        }
                        $i2 = 1;
                        while (list($key, $value) = each(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i})) {
                            if ($i2 > 1) {
                                $return
                                    .= ",
							";
                            } else {
                                $return
                                    .= "
							{
							";
                            }
                            $return
                                .= "'".$key."': '".addslashes($value)."'";
                            ++$i2;
                        }
                        $return
                            .= "
							}";
                        reset(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i});
                    }
                }
                $return .=
                    "
						]
					}	
				},
				{
					".$jw_fallback2.",
					'config': {
						'playlist': [";
                // Load JSON playlist
                for($i = 1; $i < 51; ++$i)
                {
                    if (!(empty(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i}["file"])))
                    {
                        //set file
                        if ($i > 1)
                        {
                            $return
                                .= ",";
                        }
                        $i2 = 1;
                        while (list($key, $value) = each(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i})) {
                            if ($i2 > 1) {
                                $return
                                    .= ",
							";
                            } else {
                                $return
                                    .= "
							{
							";
                            }
                            $return
                                .= "'".$key."': '".addslashes($value)."'";
                            ++$i2;
                        }
                        $return
                            .= "
							}";
                        reset(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i});
                    }
                }
                $return .=
                    "
						]
					}	
				}";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true") {
                    $return
                        .= ",
				{
					'type': 'download',
					'config': {
						'playlist': [";
                    // Load JSON playlist
                    for($i = 1; $i < 51; ++$i)
                    {
                        if (!(empty(${"is_plgplayer_playlist_json_download_".$i}["file"])))
                        {
                            //set file
                            if ($i > 1)
                            {
                                $return
                                    .= ",";
                            }
                            $i2 = 1;
                            while (list($key, $value) = each(${"is_plgplayer_playlist_json_download_".$i})) {
                                if ($i2 > 1) {
                                    $return
                                        .= ",
							";
                                } else {
                                    $return
                                        .= "
							{
							";
                                }
                                $return
                                    .= "'".$key."': '".addslashes($value)."'";
                                ++$i2;
                            }
                            $return
                                .= "
							}";
                            reset(${"is_plgplayer_playlist_json_download_".$i});
                        }
                    }
                    $return .=
                        "
						]
					}
				}";
                }
                $return
                    .= "
			]";
                //remove playlistfile and file only when playlist editor is set
                unset ($is_plgplayer_flashvars_html5["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5["file"]);
                unset ($is_plgplayer_flashvars_html5["streamer"]);
                unset ($is_plgplayer_flashvars_html5["provider"]);
            } else if (!(empty($is_plgplayer_flashvars_html5["playlistfile"]))) {
                //remove and return url encode for playlistfile
                $return
                    .= "
			'playlistfile': '".urldecode($is_plgplayer_flashvars_html5["playlistfile"])."',";
                unset ($is_plgplayer_flashvars_html5["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5["file"]);
                $return
                    .= "
			'modes': [
				{ ".$jw_fallback1." },
				{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
				{ 'type': 'download' }";
                }
                $return
                    .= "
			]";
            } else if (!(empty($is_plgplayer_flashvars_html5["file"]))) {
                //remove and retrun file
                $return
                    .= "
			'file': '".$is_plgplayer_flashvars_html5["file"]."',";
                unset ($is_plgplayer_flashvars_html5["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5["file"]);
                $return
                    .= "
			'modes': [
				{ ".$jw_fallback1." },
				{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
				{ 'type': 'download' }";
                }
                $return
                    .= "
			]";
            } else if (!(empty($is_plgplayer_flashvars_html5["levels"]))) {
                //remove and retrun file
                $return
                    .= "
			'levels': ".$is_plgplayer_flashvars_html5["levels"].",";
                unset ($is_plgplayer_flashvars_html5["levels"]);
                $return
                    .= "
			'modes': [
				{ ".$jw_fallback1." },
				{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
				{ 'type': 'download' }";
                }
                $return
                    .= "
			]";
            } else if (!(empty($is_plgplayer_flashvars_html5["playlist.json"]))) {
                //remove and retrun file
                $return
                    .= "
			'playlist': ".$is_plgplayer_flashvars_html5["playlist.json"].",";
                unset ($is_plgplayer_flashvars_html5["playlist.json"]);
                $return
                    .= "
			'modes': [
				{ ".$jw_fallback1." },
				{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
				{ 'type': 'download' }";
                }
                $return
                    .= "
			]";
            } else if (!(empty($is_plgplayer_flashvars_html5["modes"]))) {
                //remove and retrun file
                $return
                    .= "
			'modes': ".$is_plgplayer_flashvars_html5["modes"];
                unset ($is_plgplayer_flashvars_html5["modes"]);
            }
            //load plugin for html5 5.6
            if (!(empty($is_plgplayer_plugin_array))) {
                unset ($is_plgplayer_flashvars_html5["plugins"]);
                $i = 1;
                $return
                    .= ",
			'plugins': {";
                while (list($key, $value) = each($is_plgplayer_plugin_array)) {
                    if ($i > 1)
                    {
                        $return
                            .= ",";
                    }
                    $return
                        .= "
				'".$value."' : {}";
                    $i++;
                }
                $return
                    .= "	
			}";
                reset($is_plgplayer_plugin_array);
            }
            //remove url encode flashvar for jwplayer.js compatibilty
            //remove url encode for sharing.link
            if (!(empty($is_plgplayer_flashvars_html5["sharing.link"])) && $is_plgplayer_sharing_enabled != '0') {
                $is_plgplayer_flashvars_html5["sharing.link"] = urldecode($is_plgplayer_flashvars_html5["sharing.link"]);
            }
            //remove url encode for ova.json
            if (!(empty($is_plgplayer_flashvars_html5["ova.json"])) && $is_plgplayer_ova_enabled != '0') {
                $is_plgplayer_flashvars_html5["ova.json"] = urldecode($is_plgplayer_flashvars_html5["ova.json"]);
            }
            //set events
            if (!(empty($is_plgplayer_flashvars_html5["events"]))) {
                $return
                    .= ",
			'events': ".$is_plgplayer_flashvars_html5["events"];
                unset ($is_plgplayer_flashvars_html5["events"]);
            }
            //set flashvars
            while (list($key, $value) = each($is_plgplayer_flashvars_html5)) {
                $return
                    .= ",
			'".$key."': '".$value."'";
            }
            reset($is_plgplayer_flashvars_html5);
            // Valid or not the plugin sharing code for the player
            if ($is_plgplayer_sharing_enabled == '1') {
                $return
                    .= ",
			'sharing.code': '<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars_html5["width"]."\" height=\"".$is_plgplayer_flashvars_html5["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />'";
            }
            // Valid or not the embed viral code for the player only if JSON playlist is set
            if (($is_plgplayer_viral_enabled == '1') && ((!(empty($is_plgplayer_flashvars_html5["playlistfile"])) && !(empty($is_plgplayer_playlist_file1))) || (!(empty($is_plgplayer_playlist_json_flash_1))))) {
                $return
                    .= ",
			'viral.embed': '<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars_html5["width"]."\" height=\"".$is_plgplayer_flashvars_html5["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />'";
            }
            $return
                .= "
		});
	";
        }
        $return
            .= "
	</script>
	";
        //set multiple playlist
        if ($is_plgplayer_playlist_multiple_dropdown == '1') {
            $return
                .= "
	<br/>";
            if ($jw_html5 == '0') {
                $return
                    .= "
	<select name=\"sel".$pluginclasspl_sfx."\" onchange=\"javascript:jwplayer".$pluginclasspl_sfx.".sendEvent('STOP'); jwplayer".$pluginclasspl_sfx.".sendEvent('LOAD', this.value);\" ".$is_plgplayer_playlist_multiple_dropdownclass.">";
            } else {
                $return
                    .= "
	<select name=\"sel".$pluginclasspl_sfx."\" onchange=\"jwplayer('jwplayer".$pluginclasspl_sfx."').stop(); jwplayer('jwplayer".$pluginclasspl_sfx."').load(this.value);\" ".$is_plgplayer_playlist_multiple_dropdownclass.">";
            }
            $return
                .= "
		<option value=\"".$multiple_playlist[0]."\" selected=\"selected\">Select a Playlist</option>";
            $i = 0;
            while (!(empty($multiple_playlist[$i]))) {
                $return
                    .= "
		<option value=\"".$multiple_playlist[$i]."\">".$multiple_playlist_title[$i]."</option>";
                $i++;
            }
            $return
                .= "
	</select>";
        }
    }
}
//Check if there is the player and the text/image popup
if (($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') && ($is_plgplayer_popup_linkchoice == '0' || $is_plgplayer_popup_linkchoice == '1' || $is_plgplayer_popup_linkchoice == '2'))	{
    $return
        .= "<br />";
}
// Valid or not the pop-up
if ($is_plgplayer_playlist_popup == 'windows') {
    $return
        .= "".$is_plgplayer_ova_companion_clear_both_css_open."<a title=\"".$is_plgplayer_popup_text."\" onmouseover=\"window.status='".$is_plgplayer_popup_text."';return true\" onfocus=\"window.status='".$is_plgplayer_popup_text."';return true\" onmouseout=\"window.status=''\" href=\"JavaScript:void(0)\" onclick=\"window.open('".$plgswf_player."".$plgswf_signplayer."".$is_plgplayer_flashvars_string4."&amp;allowfullscreen=true&amp;allowscriptaccess=always','jwplayer".$pluginclasspl_sfx."','left=1,top=1,menubar=0,location=0,status=0,width=".$is_plgplayer_playlist_popupwidth.",height=".$is_plgplayer_playlist_popupheight.",toolbar=0,resizable=0,scrollbars=0');\">".$is_plgplayer_popup_link."";
    if ($is_plgplayer_popup_linkchoice == '2' || $is_plgplayer_popup_linkchoice == '5')	{
        $return
            .= "<br />
		".$is_plgplayer_popup_text."";
    }
    $return
        .= "</a>".$is_plgplayer_ova_companion_clear_both_css_closed."";
}
// Valid or not the highslide pop-up
if ($is_plgplayer_playlist_popup == 'highslide') {
    $return
        .= "".$is_plgplayer_ova_companion_clear_both_css_open."<a href=\"".$plgswf_player."\" onclick=\"return hs.htmlExpand
	(this,
		{
			objectType:	'swf',
			swfOptions:
			{
				version: '9',
				flashvars:
				{
					";
    $i = 1;
    while (list($key, $value) = each($is_plgplayer_flashvars)) {
        if ($i > 1)	{
            $return
                .= ",";
        }
        $return
            .= "
					'".$key."': '".$value."'";
        $i++;
    }
    reset($is_plgplayer_flashvars);
    //'flashvars': '".$is_plgplayer_flashvars_string."'";
    // Valid or not the plugin sharing link for the player
    if ($is_plgplayer_sharing_enabled == '1') {
        $return
            .= ",
					'sharing.code': encodeURIComponent('<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars["width"]."\" height=\"".$is_plgplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />')";
    }
    $return
        .= "
				},
				params:
				{
					'allowfullscreen': 'true',
					'allowscriptaccess': 'always',
					'allownetworking': 'all',
					'wmode': '".$is_plgplayer_flashvars["wmode"]."'
				},
				attributes:
				{
					'id': 'jwplayer".$pluginclasspl_sfx."pop',
					'name': 'jwplayer".$pluginclasspl_sfx."pop'
				}
			},
			width: ".$is_plgplayer_playlist_popupwidth.",
			objectWidth: ".$is_plgplayer_playlist_popupwidth.",
			objectHeight: ".$is_plgplayer_playlist_popupheight.",
			maincontentText: '".$is_plgplayer_flash2."'
		}
	)\" class=\"highslide\">
".$is_plgplayer_popup_link."";
    if ($is_plgplayer_popup_linkchoice == '2' || $is_plgplayer_popup_linkchoice == '5') {
        $return
            .= "<br />
".$is_plgplayer_popup_text."";
    }
    $return
        .= "</a>".$is_plgplayer_ova_companion_clear_both_css_closed."";
}
// Valid or not the JWBox pop-up
if ($is_plgplayer_playlist_popup == 'lightbox') {
    $return
        .= "
<".$plgplayercontainerjwbox_sfx." class=\"jwbox\">
	<a href=\"#\">".$is_plgplayer_popup_link."</a>";
    if ($is_plgplayer_popup_linkchoice == '2' || $is_plgplayer_popup_linkchoice == '5') {
        $return
            .= "<br />
	<a href=\"#\">".$is_plgplayer_popup_text."</a>";
    }
    $return
        .= "
	<".$plgplayercontainerjwbox_sfx." class=\"jwbox_hidden\">
		<".$plgplayercontainerjwbox_sfx." class=\"jwbox_content\">";
    //Check if botr display
    if ($is_plgplayer_playlist_botr == true) {
        if ($is_plgplayer_playlist_botr_file != '' && $is_plgplayer_playlist_botr_display == 'botr') {
            $return
                .= "".$is_plgplayer_playlist_botr_file."";
        }
    } else {
        $return
            .= "<".$plgplayercontainerjwbox_sfx." id='jwplayer".$pluginclasspl_sfx."pop'>".$is_plgplayer_flash."</".$plgplayercontainerjwbox_sfx.">
			<script type='text/javascript'>";
        // Valid or not script for player event for jw 4. x api
        if ($is_plgplayer_playlist_multiple_dropdown == '1' && $jw_html5 == '0') {
            $return
                .= "
				var player = null;
				function playerReady(jwplayer".$pluginclasspl_sfx."pop)
				{
					jwplayer".$pluginclasspl_sfx."pop = window.document[jwplayer".$pluginclasspl_sfx."pop.id];
				}";
        }
        if ($jw_html5 == '0') {
            $return
                .= "
				var flashvars =
				{
					";
            $i = 1;
            while (list($key, $value) = each($is_plgplayer_flashvars)) {
                if ($i > 1)	{
                    $return
                        .= ",";
                }
                $return
                    .= "
					'".$key."': '".$value."'";
                $i++;
            }
            reset($is_plgplayer_flashvars);
            //'flashvars': '".$is_plgplayer_flashvars_string."'";
            // Valid or not the plugin sharing link for the player
            if ($is_plgplayer_sharing_enabled == '1') {
                $return
                    .= ",
					'sharing.code': encodeURIComponent('<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars["width"]."\" height=\"".$is_plgplayer_flashvars["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />')";
            }
            $return
                .= "
				};
				var params =
				{
					'allowfullscreen': 'true',
					'allowscriptaccess': 'always',
					'allownetworking': 'all',
					'wmode': '".$is_plgplayer_flashvars["wmode"]."'
				};
				var attributes =
				{
					'id': 'jwplayer".$pluginclasspl_sfx."pop',
					'name': 'jwplayer".$pluginclasspl_sfx."pop'
				};
				swfobject.embedSWF('".$plgswf_player."', 'jwplayer".$pluginclasspl_sfx."pop', '".$is_plgplayer_playlist_popupwidth."', '".$is_plgplayer_playlist_popupheight."', '9', false, flashvars, params, attributes);
			";
        }
        //Check if html5 display
        if ($jw_html5 == '1') {
            $return
                .= "
				jwplayer('jwplayer".$pluginclasspl_sfx."pop').setup({";
            //set simple playlist editor playlist
            if (!(empty($is_plgplayer_flashvars_html5_popup["playlistfile"])) && !(empty($is_plgplayer_playlist_file1)) && (empty($is_plgplayer_playlist_json_flash_1))) {
                $return
                    .= "
					'playlist': [";
                for($i = 1; $i < 51; ++$i) {
                    if (!(empty(${"is_plgplayer_playlist_file".$i}))) {
                        //set file
                        if ($i > 1)	{
                            $return
                                .= ",";
                        }
                        $return //JSON Playlist Editor
                            .= "
						{
							'file': '".${"is_plgplayer_playlist_file".$i}."'";
                        //set variable
                        $index1 = "captions.file".$i;
                        $index2 = "title".$i;
                        $index3 = "description".$i;
                        $index4 = "author".$i;
                        $index5 = "image".$i;
                        $index6 = "link".$i;
                        $index7 = "start".$i;
                        $index8 = "streamer".$i;
                        $index9 = "duration".$i;
                        $index10 = "provider".$i;
                        $index11 = "tags".$i;
                        $index12 = "hd.file".$i;
                        $index13 = "sharing.link".$i;
                        for ($i2 = 1; $i2 < 14; $i2++) {
                            if (!(empty(${'is_plgplayer_playlist_'.${'index'.$i2}}))) {
                                $is_plgplayer_playlist_var = str_replace( $i, "", ${'index'.$i2});
                                ${'is_plgplayer_playlist_'.${'index'.$i2}} = addslashes(${'is_plgplayer_playlist_'.${'index'.$i2}});
                                $return
                                    .= ",
							'".$is_plgplayer_playlist_var."': '".${'is_plgplayer_playlist_'.${'index'.$i2}}."'";
                            }
                        }
                        $return
                            .= "
						}";
                    }
                }
                $return
                    .= "
					],";
                //clear incompatible flashvars when playlist is set in html5
                unset ($is_plgplayer_flashvars_html5_popup["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5_popup["file"]);
                $return
                    .= "
					'modes': [
						{ ".$jw_fallback1." },
						{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
						{ 'type': 'download' }";
                }
                $return
                    .= "
					]";
            } else if (!(empty($is_plgplayer_playlist_json_flash_1))) {
                $return
                    .= "
					'modes': [
						{
							".$jw_fallback1.",
							'config': {
								'playlist': [";
                // Load JSON playlist
                for($i = 1; $i < 51; ++$i)
                {
                    if (!(empty(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i}["file"])))
                    {
                        //set file
                        if ($i > 1)
                        {
                            $return
                                .= ",";
                        }
                        $i2 = 1;
                        while (list($key, $value) = each(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i})) {
                            if ($i2 > 1) {
                                $return
                                    .= ",
									";
                            } else {
                                $return
                                    .= "
									{
									";
                            }
                            $return
                                .= "'".$key."': '".addslashes($value)."'";
                            ++$i2;
                        }
                        $return
                            .= "
									}";
                        reset(${"is_plgplayer_playlist_json_".$jw_fallbackarray1."_".$i});
                    }
                }
                $return .=
                    "
								]
							}	
						},
						{
							".$jw_fallback2.",
							'config': {
								'playlist': [";
                // Load JSON playlist
                for($i = 1; $i < 51; ++$i)
                {
                    if (!(empty(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i}["file"])))
                    {
                        //set file
                        if ($i > 1)
                        {
                            $return
                                .= ",";
                        }
                        $i2 = 1;
                        while (list($key, $value) = each(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i})) {
                            if ($i2 > 1) {
                                $return
                                    .= ",
									";
                            } else {
                                $return
                                    .= "
									{
									";
                            }
                            $return
                                .= "'".$key."': '".addslashes($value)."'";
                            ++$i2;
                        }
                        $return
                            .= "
									}";
                        reset(${"is_plgplayer_playlist_json_".$jw_fallbackarray2."_".$i});
                    }
                }
                $return .=
                    "
								]
							}	
						}";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true") {
                    $return
                        .= ",
						{
							'type': 'download',
							'config': {
								'playlist': [";
                    // Load JSON playlist
                    for($i = 1; $i < 51; ++$i)
                    {
                        if (!(empty(${"is_plgplayer_playlist_json_download_".$i}["file"])))
                        {
                            //set file
                            if ($i > 1)
                            {
                                $return
                                    .= ",";
                            }
                            $i2 = 1;
                            while (list($key, $value) = each(${"is_plgplayer_playlist_json_download_".$i})) {
                                if ($i2 > 1) {
                                    $return
                                        .= ",
									";
                                } else {
                                    $return
                                        .= "
									{
									";
                                }
                                $return
                                    .= "'".$key."': '".addslashes($value)."'";
                                ++$i2;
                            }
                            $return
                                .= "
									}";
                            reset(${"is_plgplayer_playlist_json_download_".$i});
                        }
                    }
                    $return .=
                        "
								]
							}
						}";
                }
                $return
                    .= "
					]";
                //remove playlistfile and file only when playlist editor is set
                unset ($is_plgplayer_flashvars_html5_popup["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5_popup["file"]);
                unset ($is_plgplayer_flashvars_html5_popup["streamer"]);
                unset ($is_plgplayer_flashvars_html5_popup["provider"]);
            } else if (!(empty($is_plgplayer_flashvars_html5_popup["playlistfile"]))) {
                //remove and return url encode for playlistfile
                $return
                    .= "
					'playlistfile': '".urldecode($is_plgplayer_flashvars_html5_popup["playlistfile"])."',";
                unset ($is_plgplayer_flashvars_html5_popup["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5_popup["file"]);
                $return
                    .= "
					'modes': [
						{ ".$jw_fallback1." },
						{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
						{ 'type': 'download' }";
                }
                $return
                    .= "
					]";
            } else if (!(empty($is_plgplayer_flashvars_html5_popup["file"]))) {
                //remove and retrun file
                $return
                    .= "
					'file': '".$is_plgplayer_flashvars_html5_popup["file"]."',";
                unset ($is_plgplayer_flashvars_html5_popup["playlistfile"]);
                unset ($is_plgplayer_flashvars_html5_popup["file"]);
                $return
                    .= "
					'modes': [
						{ ".$jw_fallback1." },
						{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
						{ 'type': 'download' }";
                }
                $return
                    .= "
					]";
            } else if (!(empty($is_plgplayer_flashvars_html5_popup["levels"]))) {
                //remove and retrun file
                $return
                    .= "
					'levels': ".$is_plgplayer_flashvars_html5_popup["levels"].",";
                unset ($is_plgplayer_flashvars_html5_popup["levels"]);
                $return
                    .= "
					'modes': [
						{ ".$jw_fallback1." },
						{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
						{ 'type': 'download' }";
                }
                $return
                    .= "
					]";
            } else if (!(empty($is_plgplayer_flashvars_html5_popup["playlist.json"]))) {
                //remove and retrun file
                $return
                    .= "
					'playlist': ".$is_plgplayer_flashvars_html5_popup["playlist.json"].",";
                unset ($is_plgplayer_flashvars_html5_popup["playlist.json"]);
                $return
                    .= "
					'modes': [
						{ ".$jw_fallback1." },
						{ ".$jw_fallback2." }";
                //set download fallback
                if ($is_plgplayer_playlist_fallback_download == "true")	{
                    $return
                        .= ",
						{ 'type': 'download' }";
                }
                $return
                    .= "
					]";
            } else if (!(empty($is_plgplayer_flashvars_html5_popup["modes"]))) {
                //remove and retrun file
                $return
                    .= "
					'modes': ".$is_plgplayer_flashvars_html5_popup["modes"];
                unset ($is_plgplayer_flashvars_html5_popup["modes"]);
            }
            //load plugin for html5 5.6
            if (!(empty($is_plgplayer_plugin_array))) {
                unset ($is_plgplayer_flashvars_html5_popup["plugins"]);
                $i = 1;
                $return
                    .= ",
					'plugins': {";
                while (list($key, $value) = each($is_plgplayer_plugin_array)) {
                    if ($i > 1)
                    {
                        $return
                            .= ",";
                    }
                    $return
                        .= "
						'".$value."' : {}";
                    $i++;
                }
                $return
                    .= "	
					}";
                reset($is_plgplayer_plugin_array);
            }
            //remove url encode flashvar for jwplayer.js compatibilty
            //remove url encode for sharing.link
            if (!(empty($is_plgplayer_flashvars_html5_popup["sharing.link"])) && $is_plgplayer_sharing_enabled != '0') {
                $is_plgplayer_flashvars_html5_popup["sharing.link"] = urldecode($is_plgplayer_flashvars_html5_popup["sharing.link"]);
            }
            //remove url encode for ova.json
            if (!(empty($is_plgplayer_flashvars_html5_popup["ova.json"])) && $is_plgplayer_ova_enabled != '0') {
                $is_plgplayer_flashvars_html5_popup["ova.json"] = urldecode($is_plgplayer_flashvars_html5_popup["ova.json"]);
            }
            //set events
            if (!(empty($is_plgplayer_flashvars_html5_popup["events"]))) {
                $return
                    .= ",
					'events': ".$is_plgplayer_flashvars_html5_popup["events"];
                unset ($is_plgplayer_flashvars_html5_popup["events"]);
            }
            //set flashvars
            while (list($key, $value) = each($is_plgplayer_flashvars_html5_popup)) {
                $return
                    .= ",
					'".$key."': '".$value."'";
            }
            reset($is_plgplayer_flashvars_html5_popup);
            // Valid or not the plugin sharing code for the player
            if ($is_plgplayer_sharing_enabled == '1') {
                $return
                    .= ",
					'sharing.code': '<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars_html5["width"]."\" height=\"".$is_plgplayer_flashvars_html5["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />'";
            }
            // Valid or not the embed viral code for the player only if JSON playlist is set
            if (($is_plgplayer_viral_enabled == '1') && ((!(empty($is_plgplayer_flashvars_html5_popup["playlistfile"])) && !(empty($is_plgplayer_playlist_file1))) || (!(empty($is_plgplayer_playlist_json_flash_1))))) {
                $return
                    .= ",
					'viral.embed': '<embed src=\"".$plgswf_player."\" width=\"".$is_plgplayer_flashvars_html5["width"]."\" height=\"".$is_plgplayer_flashvars_html5["height"]."\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"".$is_plgplayer_flashvars_string3."\" />'";
            }
            $return
                .= "
				});
			";
        }
        $return
            .= "
			</script>
			";
        if ($is_plgplayer_playlist_multiple_dropdown == '1') {
            $return
                .= "
			<br/>";
            if ($jw_html5 == '0') {
                $return
                    .= "
			<select name=\"sel".$pluginclasspl_sfx."pop\" onchange=\"javascript:jwplayer".$pluginclasspl_sfx."pop.sendEvent('STOP'); jwplayer".$pluginclasspl_sfx."pop.sendEvent('LOAD', this.value);\" ".$is_plgplayer_playlist_multiple_dropdownclass_popup.">";
            } else {
                $return
                    .= "
			<select name=\"sel".$pluginclasspl_sfx."pop\" onchange=\"jwplayer('jwplayer".$pluginclasspl_sfx."pop').stop(); jwplayer('jwplayer".$pluginclasspl_sfx."pop').load(this.value);\" ".$is_plgplayer_playlist_multiple_dropdownclass_popup.">";
            }
            $return
                .= "
			<option value=\"".$multiple_playlist[0]."\" selected=\"selected\">Select a Playlist</option>";
            $i = 0;
            while (!(empty($multiple_playlist[$i]))) {
                $return
                    .= "
				<option value=\"".$multiple_playlist[$i]."\">".$multiple_playlist_title[$i]."</option>";
                $i++;
            }
            $return
                .= "
			</select>";
        }
    }
    $return
        .= "
		</".$plgplayercontainerjwbox_sfx.">
	</".$plgplayercontainerjwbox_sfx.">
</".$plgplayercontainerjwbox_sfx.">";
}
//Check if the pop-up link overide the player and add div closed if not
if ((($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') && ($is_plgplayer_popup_linkchoice == '0' || $is_plgplayer_popup_linkchoice == '1' || $is_plgplayer_popup_linkchoice == '2')) || ($is_plgplayer_playlist_popup == 'none' || $is_plgplayer_playlist_popup == 'off')) {
    $return
        .= "</div>";
}

//  return
return $return . '<div id="jwplayerid" playerid="jwplayer'.$pluginclasspl_sfx.'" style="display: none"></div>';