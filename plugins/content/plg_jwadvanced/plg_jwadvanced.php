<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage plg_jwadvanced.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');

//Joomla version
$jversion = new JVersion;
$jversion = $jversion->RELEASE;

if ($jversion == "1.5") {
	$mainframe->registerEvent( 'onPrepareContent', 'botjwplayer15' );
} else {
	$mainframe = JFactory::getApplication();
	$mainframe->registerEvent( 'onContentPrepare', 'botjwplayer16' );
}

function botjwplayer15(&$row, &$params, $page=0)
{
	//get plugin Params
	$plugin =& JPluginHelper::getPlugin('content', 'plg_jwadvanced');
	$pluginParams = new JParameter( $plugin->params );

	//Get trigger
	$is_plgplayer_trigger = $pluginParams->get('Playlisttrigger', 'jwplayer');

	// define the regular expression for the bot
	$regex = "#{".$is_plgplayer_trigger."(.*?)}(.*?){/".$is_plgplayer_trigger."}#s";

	// check whether plugin has been unpublished
	if ( !$pluginParams->get( 'enabled', 1 )) {
		$row->text = preg_replace( $regex, '', $row->text );
		return true;
	}

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'botjwplayer_replacer', $row->text );
	return true;
}

function botjwplayer16($context, &$row, &$params, $page=0)
{
	//get plugin Params
	$plugin =& JPluginHelper::getPlugin('content', 'plg_jwadvanced');
	$pluginParams = new JRegistry( $plugin->params );

	//Get trigger
	$is_plgplayer_trigger = $pluginParams->get('Playlisttrigger', 'jwplayer');

	// define the regular expression for the bot
	$regex = "#{".$is_plgplayer_trigger."(.*?)}(.*?){/".$is_plgplayer_trigger."}#s";

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'botjwplayer_replacer', $row->text );
	return true;
}

function botjwplayer_replacer ( &$file )
{

	$return = null;

	//Joomla version
	$jversion = new JVersion;
	$jversion = $jversion->RELEASE;

	//get plugin Params and info
	$plugin =& JPluginHelper::getPlugin('content', 'plg_jwadvanced');

	if ($jversion != "1.5")	{
		$params = new JRegistry( $plugin->params );
	} else {
		$params = new JParameter( $plugin->params );
	}

	// get parameters
	$document = &JFactory::getDocument();

	//get pathway
	if ($jversion != "1.5") {
		$plug_pathway = JURI::base()."plugins/content/plg_jwadvanced/plg_jwadvanced/";
	} else {
		$plug_pathway = JURI::base()."plugins/content/plg_jwadvanced/";
	}

	//Load swfobject
	$plgplayerswf_sfx = $params->get('PlaylistSwfobject', '1');

	if($plgplayerswf_sfx == '2') {
		// getting plgplayer head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$plgplayerswf_sfx_founded = '0';
		// searching phrase swf in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++) {
			if(preg_match('/swfobject/i', $headDataply_keys[$i])) {
				// if founded set variable to true and break loop
				$plgplayerswf_sfx_founded = '1';
				break;
			}
		}
	}
	if($plgplayerswf_sfx == '0') {
		$plgplayerswf_sfx_founded = '1';
	}
	if($plgplayerswf_sfx == '1') {
		$plgplayerswf_sfx_founded = '0';
	}

	// Set mootools conflict
	$plgplayermootoolsjwbox_sfx = $params->get('Playlistjquerymootoolsconflict', '1');

	//extract the flashvars 1
	$is_plgplayer_flashvars = $file[0];

	//remove html tag
	$is_plgplayer_flashvars = strip_tags($is_plgplayer_flashvars);

	// Remove Line Feed and carrier return
	$is_plgplayer_flashvars = str_replace('\r', '', str_replace('\n', '', $is_plgplayer_flashvars));

	//extract the flashvars 2
 	$is_plgplayer_flashvars = str_replace( '{/jwplayer}', '', $is_plgplayer_flashvars );
	//$is_plgplayer_flashvars = strstr($is_plgplayer_flashvars, '}');
	$is_plgplayer_flashvars = str_replace( '&amp;', '&', $is_plgplayer_flashvars );
	$is_plgplayer_flashvars = str_replace( '{jwplayer}&', '', $is_plgplayer_flashvars );
	$is_plgplayer_flashvars = str_replace( '{jwplayer}', '', $is_plgplayer_flashvars );
 	//$is_plgplayer_flashvars = str_replace( '}&', '', $is_plgplayer_flashvars );


	//Construct the player ID
	$pluginclasspl_sfx = rand(100, 10000000);

	if ($is_plgplayer_flashvars) {
		//check if there is no trigger ask
		if (((strpos($is_plgplayer_flashvars, 'file=') === false) || (strpos($is_plgplayer_flashvars, 'file=') > 2)) && (strpos($is_plgplayer_flashvars, 'playlistfile1=') === false) && (strpos($is_plgplayer_flashvars, 'playlistfile=') === false) && (strpos($is_plgplayer_flashvars, 'playlistauto.file') === false) && (strpos($is_plgplayer_flashvars, 'file1=') === false) && (strpos($is_plgplayer_flashvars, 'botr.file=') === false) && (strpos($is_plgplayer_flashvars, 'video.joomlarulez.com') === false) && (strpos($is_plgplayer_flashvars, 'content.bitsontherun.com') === false) && (strpos($is_plgplayer_flashvars, 'flash.file=') === false) && (strpos($is_plgplayer_flashvars, 'flash.file1=') === false) && (strpos($is_plgplayer_flashvars, 'levels=') === false) && (strpos($is_plgplayer_flashvars, 'playlist.json=') === false) && (strpos($is_plgplayer_flashvars, 'modes=') === false)  && (strpos($is_plgplayer_flashvars, 'json.file=') === false)) {
			//$is_plgplayer_flashvars = str_replace( '}', '', $is_plgplayer_flashvars );
			$is_plgplayer_flashvars = "file=".$is_plgplayer_flashvars;
		}

		//check if botr is ask but  not set with botr.file
		if ( (strpos($is_plgplayer_flashvars, 'botr.file=') === false) && (((strpos($is_plgplayer_flashvars, 'video.joomlarulez.com/players') !== false) && (strpos($is_plgplayer_flashvars, '.js') !== false)) || ((strpos($is_plgplayer_flashvars, 'content.bitsontherun.com/players') !== false) && (strpos($is_plgplayer_flashvars, '.js') !== false)) || (strpos($is_plgplayer_flashvars, 'content.bitsontherun.com/previews') !== false) || (strpos($is_plgplayer_flashvars, 'video.joomlarulez.com/previews') !== false))) {
			//$is_plgplayer_flashvars = str_replace( '}', '', $is_plgplayer_flashvars );
			$is_plgplayer_flashvars = "botr.file=".$is_plgplayer_flashvars;
		}

		// youtube filter input
		$is_plgplayer_flashvars = str_replace( '?v=', '%3Fv%3D', $is_plgplayer_flashvars );
		// document location event input filter input
		$is_plgplayer_flashvars = str_replace( 'document.location=', 'document.location%3D', $is_plgplayer_flashvars );
		// botr url already sign filter input
		$is_plgplayer_flashvars = str_replace( '?exp=', '%3Fexp%3D', $is_plgplayer_flashvars );
		$is_plgplayer_flashvars = str_replace( '&sig=', '%26sig%3D', $is_plgplayer_flashvars );

		//extract the flashvars in array
		$tab = explode('&', $is_plgplayer_flashvars);
		$is_plgplayer_flashvars2 = array();
		foreach ($tab as $ligne) {
			$a = explode('=', $ligne);
			if ( isset($a[1]) )
			$is_plgplayer_flashvars2[$a[0]] = $a[1];
		}
		$is_plgplayer_flashvars = $is_plgplayer_flashvars2;

		// youtube filter output
		$is_plgplayer_flashvars = str_replace( '%3Fv%3D', '?v=', $is_plgplayer_flashvars );
		// document location event filter output
		$is_plgplayer_flashvars = str_replace( 'document.location%3D', 'document.location=', $is_plgplayer_flashvars );
		// botr url already sign filter input
		$is_plgplayer_flashvars = str_replace( '%3Fexp%3D', '?exp=', $is_plgplayer_flashvars );
		$is_plgplayer_flashvars = str_replace( '%26sig%3D', '&sig=', $is_plgplayer_flashvars );
	}

	//check if JWVersion is ask an set html5 fallback
	$index = 'jwversion';
	if(empty($is_plgplayer_flashvars[$index])) {
		$jwversion = $params->get('Playlistjwversion', "JW5_HTML5");
		if ($jwversion == '5') {
			$jwversion = '5';
			$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
			$jw_html5 = '0';
			$is_plgplayer_playlisttype = "playlistfile";
			$index_defaut_controlbar = 'bottom';
		} else if ($jwversion == '4') {
			$jwversion = '';
			$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
			$jw_html5 = '0';
			$is_plgplayer_playlisttype = "file";
			$index_defaut_controlbar = 'bottom';
		} else if ($jwversion == 'JW5_HTML5') {
			$jwversion = '5';
			$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
			$jw_html5 = '1';
			$jw_fallback1 = "'type': 'flash', 'src': '".$plgswf_player."'";
			$jw_fallback2 = "'type': 'html5'";
			$jw_fallbackarray1 = "flash";
			$jw_fallbackarray2 = "html";
			$is_plgplayer_playlisttype = "playlistfile";
			$index_defaut_controlbar = 'over';
		} else if ($jwversion == 'HTML5_JW5') {
			$jwversion = '5';
			$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
			$jw_html5 = '1';
			$jw_fallback1 = "'type': 'html5'";
			$jw_fallback2 = "'type': 'flash', 'src': '".$plgswf_player."'";
			$jw_fallbackarray1 = "html";
			$jw_fallbackarray2 = "flash";
			$is_plgplayer_playlisttype = "playlistfile";
			$index_defaut_controlbar = 'over';
		}
	} else if($is_plgplayer_flashvars[$index] == '5') {
		$jwversion = '5';
		$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
		$jw_html5 = '0';
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_playlisttype = "playlistfile";
		$index_defaut_controlbar = 'bottom';
	} else if($is_plgplayer_flashvars[$index] == '4') {
		$jwversion = '';
		$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
		$jw_html5 = '0';
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_playlisttype = "file";
		$index_defaut_controlbar = 'bottom';
	} else if($is_plgplayer_flashvars[$index] == '5_html5')	{
		$jwversion = '5';
		$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
		$jw_html5 = '1';
		$jw_fallback1 = "'type': 'flash', 'src': '".$plgswf_player."'";
		$jw_fallback2 = "'type': 'html5'";
		$jw_fallbackarray1 = "flash";
		$jw_fallbackarray2 = "html";
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_playlisttype = "playlistfile";
		$index_defaut_controlbar = 'over';
	} else if($is_plgplayer_flashvars[$index] == 'html5_5')	{
		$jwversion = '5';
		$plgswf_player = $plug_pathway."player-licensed".$jwversion.".swf";
		$jw_html5 = '1';
		$jw_fallback1 = "'type': 'html5'";
		$jw_fallback2 = "'type': 'flash', 'src': '".$plgswf_player."'";
		$jw_fallbackarray1 = "html";
		$jw_fallbackarray2 = "flash";
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_playlisttype = "playlistfile";
		$index_defaut_controlbar = 'over';
	}

	// set alternative flashplayer
	$index = 'flashplayer';
	if (!(empty($is_plgplayer_flashvars[$index]))) {
		if (!(empty($jw_fallback1))) {
			$jw_fallback1 = str_replace($plgswf_player, JURI::base().$is_plgplayer_flashvars[$index], $jw_fallback1);
		}
		if (!(empty($jw_fallback2))) {
			$jw_fallback2 = str_replace($plgswf_player, JURI::base().$is_plgplayer_flashvars[$index], $jw_fallback2);
		}
		$plgswf_player = JURI::base().$is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	//set ? for sign player
	$plgswf_signplayer = "?";

	// Extra JS
	$is_plgplayer_extra_js_sfx = $params->get('extrajsname', '');
	if ($is_plgplayer_extra_js_sfx != '') {
		$document->addScript($plug_pathway."script/".$is_plgplayer_extra_js_sfx);
	}

	//check if Download link failover is ask
	$index = 'fallbackdownload';
	if (empty($is_plgplayer_flashvars[$index]))	{
		$is_plgplayer_playlist_fallback_download = ($params->get('Playlistfallbackdownload','1')) ? 'true' : 'false';
	} else {
		$is_plgplayer_playlist_fallback_download = $is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	//set script load for html5
	if ($jw_html5 == '1') {

		// set alternative jwplayer.js
		$index = 'jwplayer.js';
		if (!(empty($is_plgplayer_flashvars[$index]))) {
			$document->addScript(JURI::base().$is_plgplayer_flashvars[$index]);
			unset($is_plgplayer_flashvars[$index]);
		}

		//Load jwplayer.js for html5
		$pluginhtml5js_sfx = $params->get('PlaylistjwplayerLoad', '2');
		if($pluginhtml5js_sfx == '2') {
			// getting module head section datas
			unset($headDataply);
			$headDataply = $document->getHeadData();
			// generate keys of script section
			$headDataply_keys = array_keys($headDataply["scripts"]);
			// set variable for false
			$pluginhtml5js_sfx = '1';
			// searching phrase jwplayer.js in scripts paths
			for($i = 0;$i < count($headDataply_keys); $i++)	{
				if(preg_match('/jwplayer.js/i', $headDataply_keys[$i]))	{
					// if founded set variable to true and break loop
					$pluginhtml5js_sfx = '0';
					break;
				}
			}
		}/*
        echo '<pre>';
		var_dump(get_class_methods($document));
		echo '</pre>';
		exit;
        */
		// set jquery.jwplayer.js load
		if ($pluginhtml5js_sfx == '1') {
			$document->addScript($plug_pathway."script/jwplayer.js");
			$document->addScriptDeclaration('jwplayer.key="hznIzsF43F3jhVDDOIgE9HXwd+0whquCRuWamQ==";');
		}

		//Load iscroll.js for html
		$pluginiscrolljs_sfx = $params->get('PlaylistiscrollLoad', '2');
		if($pluginiscrolljs_sfx == '2') {
			// getting module head section datas
			unset($headDataply);
			$headDataply = $document->getHeadData();
			// generate keys of script section
			$headDataply_keys = array_keys($headDataply["scripts"]);
			// set variable for false
			$pluginiscrolljs_sfx = '1';
			// searching phrase iscroll.js in scripts paths
			for($i = 0;$i < count($headDataply_keys); $i++)	{
				if(preg_match('/iscroll.js/i', $headDataply_keys[$i]))	{
					// if founded set variable to true and break loop
					$pluginiscrolljs_sfx = '0';
					break;
				}
			}
		}
	}

	// set img to image
	$index = 'img';
	if (!(empty($is_plgplayer_flashvars[$index]))) {
		$is_plgplayer_flashvars['image'] = $is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	//set  flashvars with no default mode
	$count = 5;
	$index1 = 'height';
	$index_defaut1 = '240';
	$index2 = 'width';
	$index_defaut2 = '320';
	$index3 = 'wmode';
	$index_defaut3 = 'opaque';
	$index4 = 'playlistsize';
	$index_defaut4 = '180';
	for ($i = 1; $i < $count; $i++)	{
		if ((empty($is_plgplayer_flashvars[${'index'.$i}]))) {
			$is_plgplayer_flashvars[${'index'.$i}] = $params->get("Playlist".${'index'.$i}, ${'index_defaut'.$i});
		}
	}

	//check if popup is ask
	$index = 'popup';
	$index2 = 'popup.width';
	$index3 = 'popup.height';
	$index4 = 'popup.playlistsize';
	$index5 = 'popup.text';
	$index6 = 'popup.image';
	$index7 = 'popup.overidetext';
	$index8 = 'popup.overideimage';
	$index9 = 'popup.size';
	if(empty($is_plgplayer_flashvars[$index])) {
		$is_plgplayer_playlist_popup = $params->get('Playlistpopup', "none");
	} else {
		$is_plgplayer_playlist_popup = $is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	if ($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') {
		if((empty($is_plgplayer_flashvars[$index5])) && (empty($is_plgplayer_flashvars[$index6])) && (empty($is_plgplayer_flashvars[$index7])) && (empty($is_plgplayer_flashvars[$index8]))) {
			$is_plgplayer_popup_linkchoice  = $params->get('Playlistpopuplinkchoice', '0');
			$is_plgplayer_popup_text = $params->get('Playlistpopuptextlink', "Click to watch the player in a Pop-Up");
			if($is_plgplayer_popup_linkchoice == '1' || $is_plgplayer_popup_linkchoice == '2' || $is_plgplayer_popup_linkchoice == '4' || $is_plgplayer_popup_linkchoice == '5') {
				$is_plgplayer_popup_img = $params->get('Playlistpopupimagelink', '');
				$is_plgplayer_popup_link = "<img src=\"".$is_plgplayer_popup_img."\" alt=\"".$is_plgplayer_popup_text."\" />";
			} else {
				$is_plgplayer_popup_link = $is_plgplayer_popup_text;
			}
		}
		if(!(empty($is_plgplayer_flashvars[$index5]))) {
			$is_plgplayer_popup_linkchoice = '0';
			$is_plgplayer_popup_text = $is_plgplayer_flashvars[$index5];
			$is_plgplayer_popup_link = $is_plgplayer_popup_text;
			unset($is_plgplayer_flashvars[$index5]);
		}
		if(!(empty($is_plgplayer_flashvars[$index6]))) {
			$is_plgplayer_popup_img = $is_plgplayer_flashvars[$index6];
			if(empty($is_plgplayer_popup_text)) {
				$is_plgplayer_popup_text = $params->get('Playlistpopuptextlink', "Click to watch the player in a Pop-Up");
				$is_plgplayer_popup_linkchoice = '1';
			}
			$is_plgplayer_popup_link = "<img src=\"".$is_plgplayer_popup_img."\" alt=\"".$is_plgplayer_popup_text."\" />";
			if($is_plgplayer_popup_linkchoice == '0') {
				$is_plgplayer_popup_linkchoice = '2';
			}
			unset($is_plgplayer_flashvars[$index6]);
		}
		if(!(empty($is_plgplayer_flashvars[$index7]))) {
			$is_plgplayer_popup_linkchoice = '3';
			$is_plgplayer_popup_text = $is_plgplayer_flashvars[$index7];
			$is_plgplayer_popup_link = $is_plgplayer_popup_text;
			unset($is_plgplayer_flashvars[$index7]);
		}
		if(!(empty($is_plgplayer_flashvars[$index8]))) {
			if(empty($is_plgplayer_popup_text))	{
				$is_plgplayer_popup_text = $params->get('Playlistpopuptextlink', "Click to watch the player in a Pop-Up");
			}
			$is_plgplayer_popup_img = $is_plgplayer_flashvars[$index8];
			$is_plgplayer_popup_link = "<img src=\"".$is_plgplayer_popup_img."\" alt=\"".$is_plgplayer_popup_text."\" />";
			if(empty($is_plgplayer_popup_linkchoice)) {
				$is_plgplayer_popup_linkchoice = '4';
			} else if($is_plgplayer_popup_linkchoice == '3') {
				$is_plgplayer_popup_linkchoice = '5';
			} else {
				$is_plgplayer_popup_linkchoice = '4';
			}
			unset($is_plgplayer_flashvars[$index8]);
		}
		//set default size
		if(empty($is_plgplayer_flashvars[$index9]))	{
			$is_plgplayer_popup_sizechoice = $params->get('Playlistpopupsizechoice', 'default');
		} else	{
			$is_plgplayer_popup_sizechoice = $is_plgplayer_flashvars[$index9];
			unset($is_plgplayer_flashvars[$index9]);
		}
		// width Size choice
		if(empty($is_plgplayer_flashvars[$index2]))	{
			if($is_plgplayer_popup_sizechoice == 'adjust') {
				$is_plgplayer_playlist_popupwidth = $params->get('PlaylistpopupWidth', '280');
			} else if($is_plgplayer_popup_sizechoice == 'default') {
				$is_plgplayer_playlist_popupwidth = $is_plgplayer_flashvars["width"];
			}
		} else if(!(empty($is_plgplayer_flashvars[$index2]))) {
			$is_plgplayer_popup_sizechoice = 'none';
			$is_plgplayer_playlist_popupwidth = $is_plgplayer_flashvars[$index2];
			unset($is_plgplayer_flashvars[$index2]);
		}
		// height Size choice
		if(empty($is_plgplayer_flashvars[$index3]))	{
			if($is_plgplayer_popup_sizechoice == 'adjust') {
				$is_plgplayer_playlist_popupheight = $params->get('PlaylistpopupHeight', '400');
			} else if($is_plgplayer_popup_sizechoice == 'default') {
				$is_plgplayer_playlist_popupheight = $is_plgplayer_flashvars["height"];
			}
		} else if(!(empty($is_plgplayer_flashvars[$index3]))) {
			$is_plgplayer_popup_sizechoice = 'none';
			$is_plgplayer_playlist_popupheight = $is_plgplayer_flashvars[$index3];
			unset($is_plgplayer_flashvars[$index3]);
		}
		// width playlistSize choice
		if(empty($is_plgplayer_flashvars[$index4]))	{
			if($is_plgplayer_popup_sizechoice == 'adjust') {
				$is_plgplayer_playlist_popupsize = $params->get('PlaylistpopupSize', '180');
			} else if($is_plgplayer_popup_sizechoice == 'default') {
				$is_plgplayer_playlist_popupsize = $is_plgplayer_flashvars["playlistsize"];
			}
		} else if(!(empty($is_plgplayer_flashvars[$index4]))) {
			$is_plgplayer_popup_sizechoice = 'none';
			$is_plgplayer_playlist_popupsize = $is_plgplayer_flashvars[$index4];
			unset($is_plgplayer_flashvars[$index4]);
		}
	}

	//Load  jquery for JW Box
	$plgplayerjqueryjwbox_sfx = $params->get('PlaylistjqueryLoad', '2');

	//Check if the pop-up link overide the player set container
	if ((($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') && ($is_plgplayer_popup_linkchoice == '0' || $is_plgplayer_popup_linkchoice == '1' || $is_plgplayer_popup_linkchoice == '2')) || ($is_plgplayer_playlist_popup == 'none' || $is_plgplayer_playlist_popup == 'off')) {
		$plgplayercontainerjwbox_sfx = 'div';
	} else {
		$plgplayercontainerjwbox_sfx = $params->get('Playlistjwboxcontainer', 'span');
	}

	if($plgplayerjqueryjwbox_sfx == '0' && $is_plgplayer_playlist_popup == 'lightbox') {
		// getting plgplayer head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$plgplayerjqueryjwbox_sfx_founded = '0';
		// searching phrase jquery in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++)	{
			if(preg_match('/jquery/i', $headDataply_keys[$i])) {
				// if founded set variable to true and break loop
				$plgplayerjqueryjwbox_sfx_founded = '1';
				break;
			}
		}
	} else if($plgplayerjqueryjwbox_sfx == '2') {
		$plgplayerjqueryjwbox_sfx_founded = '0';
	} else if($plgplayerjqueryjwbox_sfx == '1')	{
		$plgplayerjqueryjwbox_sfx_founded = '1';
	}

	//Load jquery.jwbox.js for JW Box
	$plgplayerjqueryjwboxjs_sfx = $params->get('PlaylistjqueryjwboxLoad');
	if($plgplayerjqueryjwboxjs_sfx == '0' && $is_plgplayer_playlist_popup == 'lightbox') {
		// getting module head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$plgplayerjqueryjwboxjs_sfx = '2';
		// searching phrase jquery.jwbox.js in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++)	{
			if(preg_match("/jquery.jwbox.js/i", $headDataply_keys[$i]))	{
				// if founded set variable to true and break loop
				$plgplayerjqueryjwboxjs_sfx = '1';
				break;
			}
		}
	}

	//Load CSS for JW Box
	$index = 'jwboxcss';
	if (empty($is_plgplayer_flashvars[$index])) {
		$plgplayercssjwbox_sfx = $params->get('PlaylistcssLoad', '1');
	} else {
		$plgplayercssjwbox_sfx = $is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	//Load CSS Field for JW Box
	$index = 'jwboxcssfield';
	if (empty($is_plgplayer_flashvars[$index])) {
		$plgplayerfieldcssjwbox_sfx = $params->get('mod_css', '');
		$plgplayerfieldcssjwbox_sfx = "<style type=\"text/css\">".$plgplayerfieldcssjwbox_sfx."</style>";
	} else {
		$plgplayerfieldcssjwbox_sfx = "<style type=\"text/css\">".$is_plgplayer_flashvars[$index]."</style>";
		unset($is_plgplayer_flashvars[$index]);
	}

	// set jwbox load
	if ($is_plgplayer_playlist_popup == 'lightbox') {
		// set CSS Load
		if ($plgplayercssjwbox_sfx == '1' || $plgplayercssjwbox_sfx == 'true') {
			JHTML::stylesheet("jwbox.css", $plug_pathway."css/");
		} else if ($plgplayercssjwbox_sfx == 'cssfield') {
			$document->addCustomTag($plgplayerfieldcssjwbox_sfx);
		}

		// set JQuery Load
		if ($plgplayerjqueryjwbox_sfx_founded == '0') {
			$document->addScript( $plug_pathway."script/jquery-1.7.2.min.js");
		}
		// Verify if mootools conflict is
		if ($plgplayermootoolsjwbox_sfx == '1') {
			if ($jversion != "1.5") {
				JHTML::_('behavior.framework');
			} else {
				JHTML::_('behavior.mootools');
			}
			$document->addScriptDeclaration ( "jQuery.noConflict();" );
		}
		// set jquery.jwbox.js Load
		if ($plgplayerjqueryjwboxjs_sfx == '2') {
			$document->addScript( $plug_pathway."script/jquery.jwbox.js");
		}
	}

	//check what modes is ask
	$is_plgplayer_playlist_auto_share = $is_plgplayer_playlist_multiple_dropdown = "0";
	$is_plgplayer_playlist_botr = false;
	$is_plgplayer_playlist_botr_display = 'botr';

	$scan_modes_dir_result = dir(dirname(__FILE__).DS."plg_jwadvanced".DS."includes".DS."modes");
	if ($scan_modes_dir_result != '') {
		for ($i_modes = 1; $i_modes < 20; $i_modes++) {
			$modes = $scan_modes_dir_result->read();
			$modes = substr($modes, 0, -4);
			if (!(empty($is_plgplayer_flashvars[$modes]))) {
				include (dirname(__FILE__).DS."plg_jwadvanced".DS."includes".DS."modes".DS.$modes.".php");
				$i_modes = 20;
			}
		}
		$scan_modes_dir_result->close();
	}

	// urlencode json playlist flashvars for embed code, this will not  work but at least not break the code
	if (!(empty($is_plgplayer_flashvars['levels'])) || !(empty($is_plgplayer_flashvars['playlist.json'])) || !(empty($is_plgplayer_flashvars['modes']))) {
		$is_plgplayer_playlist_auto_share = '1';
	}

	//check if class is ask
	$index = 'class';
	if ((empty($is_plgplayer_flashvars[$index])) || $is_plgplayer_flashvars[$index] != '') {
		if(empty($is_plgplayer_flashvars[$index])) {
			$is_plgplayer_playlist_class = $params->get('Playlistclass', "");
		} else if($is_plgplayer_flashvars[$index] != '' && $is_plgplayer_flashvars[$index] != 'off') {
			$is_plgplayer_playlist_class = $is_plgplayer_flashvars[$index];
			unset($is_plgplayer_flashvars[$index]);
		} else if($is_plgplayer_flashvars[$index] == 'off') {
			$is_plgplayer_playlist_class = '';
			unset($is_plgplayer_flashvars[$index]);
		}
	}

	//check if flashinstall is ask
	$index = 'flashinstall';
	if ((empty($is_plgplayer_flashvars[$index])) || $is_plgplayer_flashvars[$index] == 'true') {
		if(empty($is_plgplayer_flashvars[$index])) {
			$is_plgplayer_flash_enabled = $params->get('Playlistflashinstall', "1");
		} else if($is_plgplayer_flashvars[$index] == 'true') {
			$is_plgplayer_flash_enabled = '1';
			unset($is_plgplayer_flashvars[$index]);
		}
		if ($is_plgplayer_flash_enabled == '1') {
			$is_plgplayer_flash = "You must have <a href=\"http://get.adobe.com/flashplayer\">the Adobe Flash Player</a> installed to view this player.";
			$is_plgplayer_flash2 = "You must have the Adobe Flash Player installed to view this player.";
		}
		if ($is_plgplayer_flash_enabled == '0') {
			$is_plgplayer_flash = $is_plgplayer_flash2 = "";
		}
	} else if ($is_plgplayer_flashvars[$index] == 'false') {
		$is_plgplayer_flash = $is_plgplayer_flash2 = "";
		unset($is_plgplayer_flashvars[$index]);
	}

	//check if RTMP general setting is ask this for cleaning as it's removed
	if (!(empty($is_plgplayer_flashvars['rtmp']))) {
		unset($is_plgplayer_flashvars['rtmp']);
	}

	//check if child flashvars are ask
	$count = 17;
	$index1 = 'logo.link';
	$index_defaut1 = '';
	$index2 = 'logo.position';
	$index_defaut2 = 'bottom-left';
	$index3 = 'logo.timeout';
	$index_defaut3 = '3';
	$index4 = 'logo.linktarget';
	$index_defaut4 = '_blank';
	$index5 = 'logo.margin';
	$index_defaut5 = '8';
	$index6 = 'logo.over';
	$index_defaut6 = '1';
	$index7 = 'logo.out';
	$index_defaut7 = '0.5';
	$index8 = 'http.startparam';
	$index_defaut8 = 'start';
	//set  true false flaswars
	$index9 = 'logo.hide';
	$index_defaut9 = '1';
	$index10 = 'rtmp.prepend';
	$index_defaut10 = '1';
	$index11 = 'rtmp.loadbalance';
	$index_defaut11 = '0';
	$index12 = 'rtmp.subscribe';
	$index_defaut12 = '0';
	$index13 = 'controlbar.idlehide';
	$index_defaut13 = '0';
	$index14 = 'controlbar.forcenextprev';
	$index_defaut14 = '0';
	$index15 = 'display.showmute';
	$index_defaut15 = '0';
	$index16 = 'http.dvr';
	$index_defaut16 = '0';
	for ($i = 1; $i < $count; $i++) {
		if (empty($is_plgplayer_flashvars[${'index'.$i}])) {
			$is_plgplayer_playlist_var = $params->get("Playlist".(str_replace(".", "", ${'index'.$i})), ${'index_defaut'.$i});
			if ($is_plgplayer_playlist_var != '' && $is_plgplayer_playlist_var != ${'index_defaut'.$i})	{
				if ($i > 8) {
					$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_var ? 'true' : 'false' ;
				} else {
					$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}

	//check if logo.file is ask and assign it to logo
	$index = 'logo.file';
	if (!(empty($is_plgplayer_flashvars[$index]))) {
		$is_plgplayer_flashvars["logo"] = $is_plgplayer_flashvars[$index];
		unset($is_plgplayer_flashvars[$index]);
	}

	//set  simple flaswars
	$count = 27;
	$index1 = 'playlist';
	$index_defaut1 = 'none';
	$index2 = 'controlbar';
	$index_defaut2 = $index_defaut_controlbar;
	$index3 = 'bandwidth';
	$index_defaut3 = '5000';
	$index4 = 'bufferlength';
	$index_defaut4 = '1';
	$index5 = 'linktarget';
	$index_defaut5 = '_blank';
	$index6 = 'repeat';
	$index_defaut6 = 'none';
	$index7 = 'stretching';
	$index_defaut7 = 'uniform';
	$index8 = 'volume';
	$index_defaut8 = '90';
	$index9 = 'debug';
	$index_defaut9 = 'none';
	$index10 = 'displayclick';
	$index_defaut10 = 'play';
	$index11 = 'config';
	$index_defaut11 = '';
	$index12 = 'abouttext';
	$index_defaut12 = '';
	$index13 = 'aboutlink';
	$index_defaut13 = '';
	$index14 = 'backcolor';
	$index_defaut14 = '';
	$index15 = 'frontcolor';
	$index_defaut15 = '';
	$index16 = 'lightcolor';
	$index_defaut16 = '';
	$index17 = 'screencolor';
	$index_defaut17 = '';
	$index18 = 'logo';
	$index_defaut18 = '';
	//set  true false flaswars
	$index19 = 'autostart';
	$index_defaut19 = '0';
	$index20 = 'resizing';
	$index_defaut20 = '1';
	$index21 = 'shuffle';
	$index_defaut21 = '0';
	$index22 = 'smoothing';
	$index_defaut22 = '1';
	$index23 = 'icons';
	$index_defaut23 = '1';
	$index24 = 'displaytitle';
	$index_defaut24 = '0';
	$index25 = 'dock';
	$index_defaut25 = '0';
	$index26 = 'mute';
	$index_defaut26 = '0';
	for ($i = 1; $i < $count; $i++)	{
		if (empty($is_plgplayer_flashvars[${'index'.$i}])) {
			$is_plgplayer_playlist_var = $params->get("Playlist".${'index'.$i}, ${'index_defaut'.$i});
			if ($is_plgplayer_playlist_var != '' && $is_plgplayer_playlist_var != ${'index_defaut'.$i})	{
				if ($i > 18) {
					$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_var ? 'true' : 'false' ;
				} else {
					$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_var;
				}
			}
		}
	}

	//check if events is ask and combine if need
	$index = 'events';
	if (empty($is_plgplayer_flashvars[$index])) {
		$is_plgplayer_playlist_var = $params->get("Playlistevents", "");
		if ($is_plgplayer_playlist_var != "") {
			$is_plgplayer_flashvars[$index] = $is_plgplayer_playlist_var;
		}
	} else {
		//extract json from article
		$is_json_events1_first = strpos( $is_plgplayer_flashvars[$index] , "{" );
		$is_json_events1_last = strrpos( $is_plgplayer_flashvars[$index] , "}" );
		$is_plgplayer_flashvars[$index] = substr( $is_plgplayer_flashvars[$index] , ($is_json_events1_first + 1) , ($is_json_events1_last - 1 - $is_json_events1_first) );
		//extract the json in array
		$tab_json = explode(',', $is_plgplayer_flashvars[$index]);
		$is_plgplayer_playlist_json_events1 = array();
		foreach ($tab_json as $ligne_json) {
			$a_json = explode(':', $ligne_json);
			$is_plgplayer_playlist_json_events1[$a_json[0]] = $a_json[1];
		}
		unset($is_plgplayer_flashvars[$index]);
		//extract json events in backend
		$is_plgplayer_playlist_var = $params->get("Playlistevents", "");
		$is_json_events2_first = strpos( $is_plgplayer_playlist_var , "{" );
		$is_json_events2_last = strrpos( $is_plgplayer_playlist_var , "}" );
		$is_plgplayer_playlist_var = substr( $is_plgplayer_playlist_var , ($is_json_events2_first + 1) , ($is_json_events2_last - 1 - $is_json_events2_first) );
		//extract the json  backend in array
		$tab_json = explode(',', $is_plgplayer_playlist_var);
		$is_plgplayer_playlist_json_events2 = array();
		foreach ($tab_json as $ligne_json) {
			$a_json = explode(':', $ligne_json);
			$is_plgplayer_playlist_json_events2[$a_json[0]] = $a_json[1];
		}
		//combine json events
		$is_plgplayer_flashvars[$index] = $is_plgplayer_playlist_json_events1 + $is_plgplayer_playlist_json_events2;
		//set json events
		$temp = null;
		$i = 1;
		$temp
		.= "{";
		while (list($key, $value) = each($is_plgplayer_flashvars[$index])) {
		if ($i > 1)
		{
		$temp
		.= ",";
		}
		$temp
		.= "
				".$key.": ".$value."";
		$i++;
		}
		$temp
		.= "
			}";
		reset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_flashvars[$index] = $temp;
	}

	//check if a skin swf is ask
	$index = 'skin';
	$swf = 'skinswf';
	$xml = 'skinxml';
	if (empty($is_plgplayer_flashvars[$index]) && empty($is_plgplayer_flashvars[$swf]) && empty($is_plgplayer_flashvars[$xml])) {
		$is_plgplayer_playlist_skintype = $params->get('Playlistskintype', "1");
		$is_plgplayer_playlist_skin = $params->get('Playlistskin', "-1");
		$is_plgplayer_playlist_skin_xml = $params->get('Playlistskinxml', "-1");
		if($is_plgplayer_playlist_skin != '-1' && $is_plgplayer_playlist_skin != '' && $is_plgplayer_playlist_skin != 'index' && ($is_plgplayer_playlist_skintype == '0' || $jwversion != '5')) {
			$is_plgplayer_flashvars["skin"] = $plug_pathway."skin/swf/".$is_plgplayer_playlist_skin.".swf";
		} else if($is_plgplayer_playlist_skin_xml != '-1' && $is_plgplayer_playlist_skin_xml != '' && $is_plgplayer_playlist_skin_xml != 'index' && $is_plgplayer_playlist_skintype == '1' && $jwversion == '5') {
			$is_plgplayer_flashvars["skin"] = $plug_pathway."skin/xml/".$is_plgplayer_playlist_skin_xml.".zip";
			//if ($jw_html5 == '1') {
			//	if (!(file_exists( dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml".DS.$is_plgplayer_playlist_skin_xml.".xml"))) {
			//		jimport( 'joomla.filesystem.archive' );
			//		JArchive::extract( dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml".DS.$is_plgplayer_playlist_skin_xml.".zip", dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml");
			//	}
			//}
		}
	} else if (!(empty($is_plgplayer_flashvars[$swf]))) {
		$is_plgplayer_flashvars["skin"] = $plug_pathway."skin/swf/".$is_plgplayer_flashvars[$swf].".swf";
		unset($is_plgplayer_flashvars[$swf]);
	} else if (!(empty($is_plgplayer_flashvars[$xml])))	{
		$is_plgplayer_flashvars["skin"] = $plug_pathway."skin/xml/".$is_plgplayer_flashvars[$xml].".zip";
		//if ($jw_html5 == '1') {
		//	if (!(file_exists( dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml".DS.$is_plgplayer_flashvars[$xml].".xml"))) {
		//		jimport( 'joomla.filesystem.archive' );
		//		JArchive::extract( dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml".DS.$is_plgplayer_flashvars[$xml].".zip", dirname(__FILE__).DS."plg_jwadvanced".DS."skin".DS."xml");
		//	}
		//}
		unset($is_plgplayer_flashvars[$xml]);
	} else if ($is_plgplayer_flashvars[$index] == 'off') {
		unset($is_plgplayer_flashvars[$index]);
	}

	//build the plugin array
	$index = 'plugins';
	if (!(empty($is_plgplayer_flashvars[$index]))) {
	    $is_plgplayer_plugin = $is_plgplayer_flashvars[$index];
		$is_plgplayer_plugin = str_replace( '{plugins=', '', $is_plgplayer_plugin );
		$is_plgplayer_plugin_array = explode(',', $is_plgplayer_plugin);
	} else {
		$is_plgplayer_plugin_array = array();
	}

	//check if some plugins are is enabled
	$is_plgplayer_Facebook_enabled = '0';
	$is_plgplayer_ova_enabled = '0';
	//set  clear css default
	$is_plgplayer_ova_companion_clear_both_css_open = "";
	$is_plgplayer_ova_companion_clear_both_css_closed = "";
	//set companion default
	$is_plgplayer_ova_companion = '0';
	//set companion default position
	$is_plgplayer_ova_companion_position = '0';
	//set default thumb facebook
	$is_plgplayer_sharinglink_thumb = '';

	$scan_plugin_dir_result = dir(dirname(__FILE__).DS."plg_jwadvanced".DS."includes".DS."plugins");
	if ($scan_plugin_dir_result != '') {
		while($value = $scan_plugin_dir_result->read()) {
			$off = substr($value, 0, -4).'_off';
			if (!(in_array($off, $is_plgplayer_plugin_array)) && $off != '_off' && (stripos( $value , ".php" ) !== false)) {
				include (dirname(__FILE__).DS."plg_jwadvanced".DS."includes".DS."plugins".DS.$value);
			} else if (in_array($off, $is_plgplayer_plugin_array)) {
				$key = array_search( $off , $is_plgplayer_plugin_array);
				unset($is_plgplayer_plugin_array[$key]);
			}
		}
		$scan_plugin_dir_result->close();
	}

	// add extra plugin is ask
	$is_plgplayer_extra_plugin_list = $params->get('extrapluginlist');
	if($is_plgplayer_extra_plugin_list != '') {
		$index = 'plugins';
		unset($is_plgplayer_flashvars[$index]);
		if (!(empty($is_plgplayer_plugin_array))) {
			$is_plgplayer_plugin = implode(',', $is_plgplayer_plugin_array);
			$is_plgplayer_plugin = $is_plgplayer_plugin.",".$is_plgplayer_extra_plugin_list;
			$is_plgplayer_flashvars[$index] = $is_plgplayer_plugin;
			$is_plgplayer_plugin_array = explode(',', $is_plgplayer_plugin);
		} else {
			$is_plgplayer_plugin_array = explode(',', $is_plgplayer_extra_plugin_list);
			$is_plgplayer_flashvars[$index] = $is_plgplayer_extra_plugin_list;
		}
	}

	//check if extra flashvars  is ask
	$is_plgplayer_playlist_extra_flashvars = $params->get('extrapluginflashvarslist');
	if ($is_plgplayer_playlist_extra_flashvars != '') {
		$tab = explode('&', $is_plgplayer_playlist_extra_flashvars);
		$is_plgplayer_playlist_extra_flashvars2 = array();
		foreach ($tab as $ligne) {
			$a = explode('=', $ligne);
			$is_plgplayer_playlist_extra_flashvars2[$a[0]] = $a[1];
		}
		$is_plgplayer_playlist_extra_flashvars = $is_plgplayer_playlist_extra_flashvars2;
		// ad extra flasvars to array flashvars
		$is_plgplayer_flashvars = $is_plgplayer_flashvars + $is_plgplayer_playlist_extra_flashvars2;
	}

	// array replace if botr combine is set
	if ($is_plgplayer_playlist_botr == true) {
		// verify is botr override local combine is set
		if ($is_plgplayer_playlist_botr_display == 'combinebotr') {
			$is_plgplayer_flashvars = $is_plgplayer_flashvars_botr + $is_plgplayer_flashvars;
		}
		// verify is local override botr combine is set
		if ($is_plgplayer_playlist_botr_display == 'combinelocal') {
			$is_plgplayer_flashvars = $is_plgplayer_flashvars + $is_plgplayer_flashvars_botr;
		}
	}

	//check if playlist is ask and change to playlist.position, this for jwplayer.js compatibilty
	if (!(empty($is_plgplayer_flashvars['playlist'])) && $jwversion == '5') {
	    $is_plgplayer_playlist_position = $is_plgplayer_flashvars['playlist'];
		unset($is_plgplayer_flashvars['playlist']);
		$is_plgplayer_flashvars['playlist.position'] = $is_plgplayer_playlist_position;
	} else {
		$is_plgplayer_playlist_position = "";
	}

	//check if botr have plugin set
	if (!(empty($is_plgplayer_flashvars_botr['plugins']))) {
		$is_plgplayer_plugin_botr = $is_plgplayer_flashvars_botr['plugins'];
		$is_plgplayer_plugin_botr = str_replace( '{plugins=', '', $is_plgplayer_plugin_botr );
		$is_plgplayer_plugin_array_botr = explode(',', $is_plgplayer_plugin_botr);
	}

	// array replace if botr combine is set
	if ($is_plgplayer_playlist_botr == true) {
		// verify is botr combine is not set
		if ($is_plgplayer_playlist_botr_display == 'combinebotr' || $is_plgplayer_playlist_botr_display == 'combinelocal') {
			$index = 'plugins';
			if ((!(empty($is_plgplayer_plugin_botr))) && (!(empty($is_plgplayer_plugin_array)))) {
				$is_plgplayer_plugin = implode(',', $is_plgplayer_plugin_array);
				$is_plgplayer_plugin = $is_plgplayer_plugin.",".$is_plgplayer_plugin_botr;
				unset($is_plgplayer_flashvars[$index]);
				$is_plgplayer_flashvars[$index] = $is_plgplayer_plugin;
				$is_plgplayer_plugin_array = explode(',', $is_plgplayer_plugin);
			} else if (!(empty($is_plgplayer_plugin_botr)))	{
				unset($is_plgplayer_flashvars[$index]);
				$is_plgplayer_flashvars[$index] = $is_plgplayer_plugin_botr;
				$is_plgplayer_plugin_array = explode(',', $is_plgplayer_plugin_botr);
			}
		}
	}

	//Insert the plugin array and clean the string flaswars
	$index = 'plugins';
	if ((!(empty($is_plgplayer_flashvars[$index]))) && (!(empty($is_plgplayer_plugin_array)))) {
	    $is_plgplayer_plugin = implode(',', $is_plgplayer_plugin_array);
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_flashvars[$index] = $is_plgplayer_plugin;
	} else if(!(empty($is_plgplayer_plugin_array))) {
	    $is_plgplayer_plugin = implode(',', $is_plgplayer_plugin_array);
		unset($is_plgplayer_flashvars[$index]);
		$is_plgplayer_flashvars[$index] = $is_plgplayer_plugin;
	} else if ((empty($is_plgplayer_plugin_array)) || (empty($is_plgplayer_flashvars[$index])))	{
		unset($is_plgplayer_flashvars[$index]);
	}

	//extract the flashvars in a string
	//$is_plgplayer_flashvars_string = "&".urldecode(http_build_query($is_plgplayer_flashvars));//php 5.x.x
	$is_plgplayer_flashvars_string = "";
	$is_plgplayer_flashvars2 = $is_plgplayer_flashvars;
	foreach($is_plgplayer_flashvars2 as $key=>$value) {
		$is_plgplayer_flashvars_string = $is_plgplayer_flashvars_string."&".$key."=".$value;
	}

	//create flashvars array for HTML5 embedder
	if ($jw_html5 == '1') {
		$is_plgplayer_flashvars_html5 = $is_plgplayer_flashvars;
		if ($is_plgplayer_playlist_popup == 'lightbox') {
			//create flashvars array for pop-up HTML5 embedder, this will be removed when js embedder will fully support xml file
			$is_plgplayer_flashvars_html5_popup = $is_plgplayer_flashvars_html5;
			if ($is_plgplayer_playlist_popupwidth) {
				$is_plgplayer_flashvars_html5_popup["width"] = $is_plgplayer_playlist_popupwidth;
			}
			if ($is_plgplayer_playlist_popupheight) {
				$is_plgplayer_flashvars_html5_popup["height"] = $is_plgplayer_playlist_popupheight;
			}
			if ($is_plgplayer_playlist_popupsize) {
				$is_plgplayer_flashvars_html5_popup["playlistsize"] = $is_plgplayer_playlist_popupsize;
			}
		}
	}

	// build playlist flashvars for embed code
	$is_plgplayer_flashvars_string4 = preg_replace('#&#', '&amp;', $is_plgplayer_flashvars_string);
	if ($is_plgplayer_playlist_auto_share == '1') {
		$is_plgplayer_flashvars_string3 = urlencode($is_plgplayer_flashvars_string);
	} else {
		$is_plgplayer_flashvars_string3 = $is_plgplayer_flashvars_string4;
	}

	//Load share video meta for facebook
	$plgplayer_meta_sfx = $params->get('Playlistmetaload', "2");

	// set variable for false
	$facebook_video_sharing = '0';
	$plgplayer_meta_sfx_founded = '0';
	if ((($is_plgplayer_playlist_botr != true) || ($is_plgplayer_playlist_botr == true && $is_plgplayer_playlist_botr_display != 'botr' )) && (($is_plgplayer_sharing_enabled == '1') || $is_plgplayer_Facebook_enabled == '1')) {
		if ($plgplayer_meta_sfx == '2')	{
			// getting module head section datas
			unset($headDataply);
			$headDataply = $document->getHeadData();
			// generate keys of link rel section
			$headDataply_keys = array_keys($headDataply["metaTags"]["standard"]);
			// searching phrase swf in link rel paths
			for($i = 0;$i < count($headDataply_keys); $i++)	{
				if(preg_match('/video_type/i', $headDataply_keys[$i])) {
					// if founded set variable to true and break loop
					$plgplayer_meta_sfx_founded = '1';
					break;
				}
			}
		} else if ($plgplayer_meta_sfx == '1') {
			$plgplayer_meta_sfx_founded = '0';
		} else {
			$plgplayer_meta_sfx_founded = '1';
		}
		//set facebook sharing
		if ($plgplayer_meta_sfx_founded == '0')	{
			if($is_plgplayer_sharing_enabled == '1') {
				//set facebook sharing
				if($is_plgplayer_sharinglink_thumb != '') {
					$facebook_video_sharing = '1';
					$facebook_video_sharing_thumbnail = $is_plgplayer_sharinglink_thumb;
				}
			}
			if($is_plgplayer_Facebook_enabled == '1') {
				//set facebook sharing
				if($is_plgplayer_Facebooklink_thumb != '') {
					$facebook_video_sharing = '1';
					$facebook_video_sharing_thumbnail = $is_plgplayer_Facebooklink_thumb;
				}
			}
			if($facebook_video_sharing == '1') {
				//set player html valid when sign botr player use
				$plgswf_player = str_replace( '&', '&amp;', $plgswf_player );
				//set player metatag
				$player_metatag = $plgswf_player.$plgswf_signplayer.$is_plgplayer_flashvars_string4;
				// remove playlist display if width is > 420 px or if height > 280 px
				if ($is_plgplayer_flashvars["height"] > 280 && ($is_plgplayer_playlist_position == 'bottom' || $is_plgplayer_playlist_position == 'top')) {
					$is_plgplayer_flashvars_height_facebook = $is_plgplayer_flashvars["height"] - $is_plgplayer_flashvars["playlistsize"];
					$player_metatag = str_replace( "&amp;height=".$is_plgplayer_flashvars["height"], "&amp;height=".$is_plgplayer_flashvars_height_facebook, $player_metatag );
					$is_plgplayer_flashvars_width_facebook = $is_plgplayer_flashvars["width"];
					//remove playlist flashvars
					$player_metatag = str_replace( "&amp;playlist.position=".$is_plgplayer_playlist_position, "", $player_metatag );
					$player_metatag = str_replace( "&amp;playlistsize=".$is_plgplayer_flashvars["playlistsize"], "", $player_metatag );
				} else if ($is_plgplayer_flashvars["width"] > 420 && ($is_plgplayer_playlist_position == 'right' || $is_plgplayer_playlist_position == 'left'))	{
					$is_plgplayer_flashvars_height_facebook = $is_plgplayer_flashvars["height"];
					$is_plgplayer_flashvars_width_facebook = $is_plgplayer_flashvars["width"] - $is_plgplayer_flashvars["playlistsize"];
					$player_metatag = str_replace( "&amp;width=".$is_plgplayer_flashvars["width"], "&amp;width=".$is_plgplayer_flashvars_width_facebook, $player_metatag );
					//remove playlist flashvars
					$player_metatag = str_replace( "&amp;playlist.position=".$is_plgplayer_playlist_position, "", $player_metatag );
					$player_metatag = str_replace( "&amp;playlistsize=".$is_plgplayer_flashvars["playlistsize"], "", $player_metatag );
				} else {
					$is_plgplayer_flashvars_height_facebook = $is_plgplayer_flashvars["height"];
					$is_plgplayer_flashvars_width_facebook = $is_plgplayer_flashvars["width"];
				}
				//load metatag
				$document->addCustomTag("<link rel=\"image_src\" href=\"".$facebook_video_sharing_thumbnail."\" />");
				$document->addCustomTag("<link rel=\"video_src\" href=\"".$player_metatag."\" />");
				$document->setMetaData("video_height", $is_plgplayer_flashvars_height_facebook);
				$document->setMetaData("video_width", $is_plgplayer_flashvars_width_facebook);
				$document->setMetaData("video_type", "application/x-shockwave-flash");
			}
		}
	}

	// set gapro  load
	if ($is_plgplayer_gapro_enabled == '1' && $is_plgplayer_gapro_version == 'gapro-2' && (!(empty($pluginfieldAsynchronous_Tracking_sfx)))) {
		// getting plugin head section datas
		unset($headDataply);
		$plugin_meta_gapro_founded = '0';
		$headDataply = $document->getHeadData();
		// generate keys of custom  section
		$headDataply_keys = $headDataply["custom"];
		// searching phrase $is_plgplayer_gapro_accountid in custom paths
		for ($i = 0;$i < count($headDataply_keys); $i++) {
			if (preg_match("['_setAccount', '".$is_plgplayer_gapro_accountid."']", $headDataply_keys[$i])) {
				// if founded set variable to true and break loop
				$plugin_meta_gapro_founded = '1';
				break;
			}
		}
		if ($plugin_meta_gapro_founded == '0') {
			$document->addCustomTag($pluginfieldAsynchronous_Tracking_sfx);
		}
	}

	// Return the player
	return include (dirname(__FILE__).DS.'plg_jwadvanced'.DS.'tmpl'.DS.'default.php');

}