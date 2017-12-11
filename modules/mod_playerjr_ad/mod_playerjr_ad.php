<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage mod_playerjr_ad.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$params = modplayerjr_adHelper::getParams( $params );

//Joomla version
$jversion = new JVersion;
$jversion = $jversion->RELEASE;
	
// JW Version
$jwversion = $params->get('PlaylistJWVersion');
switch ($jwversion) {
    case 5:
		$jwversion_playlist = '5';
		$jw_html5 = '0';
		$is_modplayer_playlisttype = 'playlistfile';
		$is_modplayer_logo = 'logo.file';
		$index_defaut_controlbar = 'bottom';
		break;
    case 4:
		$jwversion_playlist = '';
		$jw_html5 = '0';
		$is_modplayer_playlisttype = 'file';
		$is_modplayer_logo = 'logo';
		$index_defaut_controlbar = 'bottom';
        break;
    case "JW5_HTML5":
		$jwversion = '5';
		$jw_html5 = '1';
		$jw_fallback = 'HTML5';
		$jwversion_playlist = '5';
		$is_modplayer_playlisttype = 'playlistfile';
		$is_modplayer_logo = 'logo.file';
		$index_defaut_controlbar = 'over';
        break;
    case "HTML5_JW5":
		$jwversion = '5';
		$jw_html5 = '1';
		$jw_fallback = 'JW5';
		$jwversion_playlist = '5';
		$is_modplayer_playlisttype = 'playlistfile';
		$is_modplayer_logo = 'logo.file';
		$index_defaut_controlbar = 'over';
        break;
}

// Module Parameters
$playersite  = JURI::root();
$document = &JFactory::getDocument();

// Article ID
$articleId=JRequest::getVar('id',0);
$pos = strpos($articleId, ':');
if ($pos != '') {
	$articleId = substr($articleId, 0, $pos);
}

// Module ID
$moduleclasspl_sfx = $module->id;

// Cache
$modulecache_sfx = $params->get('cache');
//cache issue (load js an css in head resolve since 1.6)
if ($jversion != "1.5") {
	$modulecache_sfx = "0";
}

//set player
$moduleswf_player = $playersite."modules/mod_playerjr_ad/player-licensed".$jwversion_playlist.".swf";
//set ? for sign player
$moduleswf_signplayer = "?";
//Load swfobject
$moduleswf_sfx = $params->get('PlaylistSwfobject');
if($moduleswf_sfx == '2') {
	// getting module head section datas
	unset($headDataply);
	$headDataply = $document->getHeadData();
	// generate keys of script section
	$headDataply_keys = array_keys($headDataply["scripts"]);
	// set variable for false
	$moduleswf_sfx_founded = '0';
	// searching phrase swf in scripts paths
	for($i = 0;$i < count($headDataply_keys); $i++)	{
		if(preg_match('/swfobject/i', $headDataply_keys[$i])) {
			// if founded set variable to true and break loop
			$moduleswf_sfx_founded = '1';
			break;
		}
	}
}
if($moduleswf_sfx == '0') {
	$moduleswf_sfx_founded = '1';
}
if($moduleswf_sfx == '1') {
	$moduleswf_sfx_founded = '0';
}

// Flash Install
$moduleflash_sfx = $params->get('PlaylistFlashinstall');
if ($moduleflash_sfx == '1') {
	$is_modplayer_flash = "You must have <a href=\"http://get.adobe.com/flashplayer\">the Adobe Flash Player</a> installed to view this player.";
	$is_modplayer_flash2 = "You must have the Adobe Flash Player installed to view this player.";
} else {
	$is_modplayer_flash = "";
	$is_modplayer_flash2 = "";
}

// Playlist Parameters
$is_modplayer_playlist_select = $params->get('mod_plselect');
$is_modplayer_playlist_item ='0';

//set javascript load for html5
if ($jw_html5 == '1') {
	//Load jwplayer.js for html
	$modulehtml5js_sfx = $params->get('PlaylistjwplayerLoad');
	if($modulehtml5js_sfx == '2') {
		// getting module head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$modulehtml5js_sfx = '1';
		// searching phrase jwplayer.js in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++)	{
			if(preg_match('/jwplayer.js/i', $headDataply_keys[$i]))	{
				// if founded set variable to true and break loop
				$modulehtml5js_sfx = '0';
				break;
			}
		}
	}

	//check if Download link failover is ask
	$is_modplayer_playlist_fallback_download = $params->get('Playlistfallbackdownload');
	
	//Load iscroll.js for html
	$is_modplayer_iscrolljs_sfx = $params->get('PlaylistiscrollLoad');
	if($is_modplayer_iscrolljs_sfx == '2') {
		// getting module head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$is_modplayer_iscrolljs_sfx = '1';
		// searching phrase iscroll.js in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++)	{
			if(preg_match('/iscroll.js/i', $headDataply_keys[$i]))	{
				// if founded set variable to true and break loop
				$is_modplayer_iscrolljs_sfx = '0';
				break;
			}
		}
	}

}

//Playlist botr
$is_modplayer_playlist_botr_file = $params->get('mod_plbotrfile');
$checkvideojoomlarulez = stripos($is_modplayer_playlist_botr_file, 'video.joomlarulez.com');
$is_modplayer_playlist_botr_display = $params->get('mod_plbotrdisplay');
if ($is_modplayer_playlist_botr_file !='') {
	$apikey = $params->get('mod_plbotrapikey');
	$secret = $params->get('mod_plbotrsecretkey');
}

if ($is_modplayer_playlist_select =='4' && ($checkvideojoomlarulez != false)) {
	$is_modplayer_playlist_botr = true;
	//replace video.joomlarulez.com by content.bitsontherun.com for secret
	if ($checkvideojoomlarulez != false) {
		$is_modplayer_playlist_botr_file = str_replace( 'video.joomlarulez.com', 'content.bitsontherun.com', $is_modplayer_playlist_botr_file );
	}

	// set js array	
	$is_modplayer_playlist_botr_file = str_replace( 'http://', '', $is_modplayer_playlist_botr_file );
	$is_modplayer_playlist_botr_file_array = explode("/", $is_modplayer_playlist_botr_file);
	
	// botr url already sign
	if (stripos($is_modplayer_playlist_botr_file, '/previews/')) {
		$is_modplayer_playlist_botr_file_array[1] = str_replace( 'previews', 'players', $is_modplayer_playlist_botr_file_array[1] );
		$botr_file_array_2_balisestop = stripos($is_modplayer_playlist_botr_file_array[2], '?');
		$botr_file_array_2_length = strlen($is_modplayer_playlist_botr_file_array[2]);
		$is_modplayer_playlist_botr_file_array[2] = substr($is_modplayer_playlist_botr_file_array[2], 0 , ($botr_file_array_2_length - ($botr_file_array_2_length - $botr_file_array_2_balisestop)));
		$is_modplayer_playlist_botr_file_array[2] = str_replace( '?', '', $is_modplayer_playlist_botr_file_array[2] );
	}
	
	// set js secret
	$timeout = $params->get('mod_plbotrtimeout');
	$expires = time() + $timeout;
	$signature = md5($is_modplayer_playlist_botr_file_array[1].'/'.$is_modplayer_playlist_botr_file_array[2].':'.$expires.':'.$secret);
	$is_modplayer_playlist_botr_file = 'http://'.$is_modplayer_playlist_botr_file_array[0].'/'.$is_modplayer_playlist_botr_file_array[1].'/'.$is_modplayer_playlist_botr_file_array[2].'?exp='.$expires.'&sig='.$signature;

	// find video ID
	$videoid = str_replace( '.js', '', $is_modplayer_playlist_botr_file_array[2] );
	$videoidbalisestop = stripos($videoid, '-');
	$videoidlength = strlen  ($videoid);
	$videoid = substr($videoid, 0 , ($videoidlength - $videoidbalisestop));
	$videoid = str_replace( '-', '', $videoid );

	// find player ID
	$playerid = str_replace( '.js', '', $is_modplayer_playlist_botr_file_array[2] );
	$playeridbalisestart = stripos($playerid, '-');
	$playerid = substr($playerid, $playeridbalisestart , $videoidlength);
	$playerid = str_replace( '-', '', $playerid );
	
	// set xml secret
	$signature = md5('jwp/'.$videoid.'.xml:'.$expires.':'.$secret);
	$is_modplayer_playlist_botr_xml = "http://content.bitsontherun.com/jwp/".$videoid.".xml?exp=".$expires."&sig=".$signature;

	//replace content.bitsontherun.com by video.joomlarulez.com  for secret
	if ($checkvideojoomlarulez != false) {
		$is_modplayer_playlist_botr_file = str_replace( 'content.bitsontherun.com', 'video.joomlarulez.com', $is_modplayer_playlist_botr_file );
		$is_modplayer_playlist_botr_xml = str_replace( 'content.bitsontherun.com', 'video.joomlarulez.com', $is_modplayer_playlist_botr_xml );
	}

	// setting display and source
	//set combine mode
	if ($is_modplayer_playlist_botr_display == '1' || $is_modplayer_playlist_botr_display == '2') {
		// Call api if class not set
		if (!(class_exists('BotrAPI'))) {
			require_once('script/api.php');
		}
		// Set api
		$botr_api = new BotrAPI($apikey, $secret);
		// set flashvars
		$is_modplayer_flashvars_botr = ($botr_api->call("/players/show", array('player_key' => $playerid)));
		$is_modplayer_flashvars_botr_status = $is_modplayer_flashvars_botr["status"];
		if ($is_modplayer_flashvars_botr_status == 'ok') {
			$is_modplayer_flashvars_botr = $is_modplayer_flashvars_botr["player"];
			unset($is_modplayer_flashvars_botr["name"]);
			unset($is_modplayer_flashvars_botr["views"]);
			unset($is_modplayer_flashvars_botr["key"]);
			// if template Id  is not empty set  a new xml secret
			if (!(empty($is_modplayer_flashvars_botr["template"]["key"]))) {
				$templateid = $is_modplayer_flashvars_botr["template"]["key"];
				// set xml secret
				$signature = md5('jwp/'.$videoid.'-'.$templateid.'.xml:'.$expires.':'.$secret);
				$is_modplayer_playlist_botr_xml = "http://content.bitsontherun.com/jwp/".$videoid."-".$templateid.".xml?exp=".$expires."&sig=".$signature;	
			}
			unset($is_modplayer_flashvars_botr["template"]);
			// set custom flasvars
			if (!(empty($is_modplayer_flashvars_botr["custom_flashvars"]))) {
				// set custom flashvars as array
				$is_modplayer_flashvars_botr_custom_flashvars = $is_modplayer_flashvars_botr["custom_flashvars"];
				unset($is_modplayer_flashvars_botr["custom_flashvars"]);

				$tab = explode('&', $is_modplayer_flashvars_botr_custom_flashvars);
				$is_modplayer_flashvars_botr_custom_flashvars2 = array();
				foreach ($tab as $ligne) {
					$a = explode('=', $ligne);
					$is_modplayer_flashvars_botr_custom_flashvars2[$a[0]] = $a[1];
				}
				$is_modplayer_flashvars_botr_custom_flashvars = $is_modplayer_flashvars_botr_custom_flashvars2;

				// add custom flashvars array player flashvars
				$is_modplayer_flashvars_botr = $is_modplayer_flashvars_botr + $is_modplayer_flashvars_botr_custom_flashvars;
			}
			// set skin
			if (!(empty($is_modplayer_flashvars_botr["skin"])))	{
				$is_modplayer_flashvars_botr_skin = $is_modplayer_flashvars_botr["skin"]["key"];
				unset($is_modplayer_flashvars_botr["skin"]);
				// set format skin
				$is_modplayer_flashvars_botr_skin_info = ($botr_api->call("/accounts/skins/show", array('skin_key' => $is_modplayer_flashvars_botr_skin)));
				$is_modplayer_flashvars_botr_skin_status = $is_modplayer_flashvars_botr_skin_info["status"];
				//check status
				if ($is_modplayer_flashvars_botr_skin_status == 'ok') {
					$is_modplayer_flashvars_botr_skin_info_format = $is_modplayer_flashvars_botr_skin_info["skin"]["format"];
					//load skin
					$is_modplayer_flashvars_botr_skin = "http://content.bitsontherun.com/skins/".$is_modplayer_flashvars_botr_skin.".".$is_modplayer_flashvars_botr_skin_info_format;
					$is_modplayer_flashvars_botr["skin"] = $is_modplayer_flashvars_botr_skin;
				}
			}
			// set plugins
			if ((!(empty($is_modplayer_flashvars_botr["ltas_channel"]))) && ($is_modplayer_playlist_botr_display == '2')) {
				$is_modplayer_plugin_botr = 'ltas';
				$is_modplayer_flashvars_botr["ltas.cc"] = $is_modplayer_flashvars_botr["ltas_channel"];
				unset($is_modplayer_flashvars_botr["ltas_channel"]);

				if (!(empty($is_modplayer_flashvars_botr["plugins"]))) {
					$is_modplayer_plugin_botr = $is_modplayer_flashvars_botr["plugins"].",".$is_modplayer_plugin_botr;
					unset($is_modplayer_flashvars_botr["plugins"]);
				}
			} else if (!(empty($is_modplayer_flashvars_botr["plugins"]))) {
				$is_modplayer_plugin_botr = $is_modplayer_flashvars_botr["plugins"];
				unset($is_modplayer_flashvars_botr["plugins"]);
			}
			// unset empty flashvars
			foreach($is_modplayer_flashvars_botr AS $indice => $valeur) {
				if ($valeur == "") {
					unset($is_modplayer_flashvars_botr[$indice]);
				}
			}
			//set xml file
			$is_modplayer_playlist_botr_file = $is_modplayer_playlist_botr_xml;
			// $check player if combinebotr is ask
			if ($is_modplayer_playlist_botr_display == '1')	{
				//$moduleswf_player = "http://content.bitsontherun.com/players/".$videoid."-".$playerid.".swf";
				// set player secret
				$signature = md5("players/".$videoid."-".$playerid.".swf:".$expires.":".$secret);
				$moduleswf_player = "http://content.bitsontherun.com/players/".$videoid."-".$playerid.".swf?exp=".$expires."&sig=".$signature;
				//set ? for sign player
				$moduleswf_signplayer = "";
			}
		} else {
			$is_modplayer_playlist_botr_display = '0';
		}
	}
	//set local mode
	if ($is_modplayer_playlist_botr_display == '3')	{
		$is_modplayer_playlist_botr_file = $is_modplayer_playlist_botr_xml;
	}
	//set remote mode
	if ($is_modplayer_playlist_botr_display == '0') {
		$is_modplayer_playlist_botr_file = "<script type=\"text/javascript\" src=\"".$is_modplayer_playlist_botr_file."\"></script>";
		$moduleswf_sfx_founded = '1';
	}
} else {
	$is_modplayer_playlist_botr = false;
}

//Playlist JSON
$is_modplayer_playlist_json_src = $params->get('mod_plfilesrc');
$is_modplayer_playlist_json_field = $params->get('mod_plfilejson');
if ($is_modplayer_playlist_select == '5' && $jw_html5 == '1') {
	if (empty($is_modplayer_playlist_item)) {
		$is_modplayer_playlist_item = '0';
	}
	//select source
	if ($is_modplayer_playlist_json_src == "1") {
		$is_modplayer_playlist_json_file = $params->get('mod_plfileextjson');
		// set slash file
		$is_modplayer_playlist_json_file_first_slash = strpos($is_modplayer_playlist_json_file , "/");
		if ($is_modplayer_playlist_json_file_first_slash == '0') {
			$is_modplayer_playlist_json_file = "first".$is_modplayer_playlist_json_file;
			$is_modplayer_playlist_json_file = preg_replace('#first/#', '', $is_modplayer_playlist_json_file);
		}
		if (file_exists($is_modplayer_playlist_json_file) && is_readable($is_modplayer_playlist_json_file) && (strpos($is_modplayer_playlist_json_file , ".json") || strpos($is_modplayer_playlist_json_file , ".txt"))) {
			$is_modplayer_playlist_json_field = file_get_contents($playersite.$is_modplayer_playlist_json_file);
		}
	}
	//check if modes is set
	if ((strpos($is_modplayer_playlist_json_field , "modes")) != false) {
		$is_modplayer_playlist_select = '6';
	}
} else if ($is_modplayer_playlist_select == '5') {
	$is_modplayer_playlist_select = '0';
}

//Playlist RSS
$is_modplayer_playlist_file = $params->get('mod_plfile');
if ($is_modplayer_playlist_select == '0') {
	$is_modplayer_playlist_file_contentid = $params->get('mod_plfilecontentID');
	//Assign Poss  Item For content ID
	$itempos_contentid = explode(",", $is_modplayer_playlist_file_contentid);
	while ($value = current($itempos_contentid)) {
		if ($value == $articleId) {
			$is_modplayer_playlist_item = key($itempos_contentid);
		}
		next($itempos_contentid);
	}
	if (empty($is_modplayer_playlist_item)) {
		$is_modplayer_playlist_item ='0';
	}
}

//Multiple Playlist RSS
if ($is_modplayer_playlist_select =='3') {
	$is_modplayer_playlist_multiple_file = $params->get('mod_plfilemulti');
	$is_modplayer_playlist_playlist_contentid = $params->get('mod_plfilecontentIDmulti');
	$is_modplayer_playlist_multiple_dropdown = $params->get('mod_plmultidropdownlist');
	$is_modplayer_playlist_multiple_dropdown_title = $params->get('mod_plmultidropdowntitle');
	$is_modplayer_playlist_multiple_length_title = $params->get('mod_plmultidropdowntitlelength');

	//Assign Playlist For content ID
	$playlist_contentid = explode(",", $is_modplayer_playlist_playlist_contentid);
	$multiple_playlist = explode(",", $is_modplayer_playlist_multiple_file);
	$is_modplayer_playlist_file = $multiple_playlist[0];
	while ($value = current($playlist_contentid)) {
		if ($value == $articleId) {
			$is_modplayer_playlist_file = current($multiple_playlist);
		}
		next($playlist_contentid);
	}

	//Assign title for playlist
	if ($is_modplayer_playlist_multiple_dropdown_title == '2') {
		$multiple_playlist_title = explode(",", $is_modplayer_playlist_multiple_file);
		$is_modplayer_curlinstall = function_exists('curl_version') ? 'Enabled' : 'Disabled';
		// Check if title is available
		if ($is_modplayer_curlinstall == 'Enabled') {
			// create curl resource
			$ch = curl_init();
			for($i = 0; $i < sizeof($multiple_playlist_title); ++$i) {
				// set url
				curl_setopt($ch, CURLOPT_URL, $multiple_playlist_title[$i]);
				//return the transfer as a string
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				//stop after timeout
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);

				// $checktitle contains the output string
				$checktitle = curl_exec($ch);
				$checktitle = str_replace("\t","",$checktitle);
				$checktitle = str_replace("\n","",$checktitle);
				$checktitlebalisestart = stripos($checktitle, '<title>');
				$checktitlebalisestart_youtube = stripos($checktitle, "<title type='text'>");
				if ( $checktitlebalisestart != false) {
					$checktitlebalisestop = stripos($checktitle, '</title>');
					$checktitle = substr($checktitle, $checktitlebalisestart , $checktitlebalisestop - $checktitlebalisestart);
					$checktitle = str_replace("<title>","",$checktitle);
					if ((strlen($checktitle)) > $is_modplayer_playlist_multiple_length_title) {
						$checktitle = substr($checktitle, 0 , $is_modplayer_playlist_multiple_length_title - 3);
						$checktitle = $checktitle."...";
					}
					$multiple_playlist_title[$i] = $checktitle;
				} else if ( $checktitlebalisestart_youtube != false) {
					$checktitlebalisestop = stripos($checktitle, '</title>');
					$checktitle = substr($checktitle, $checktitlebalisestart_youtube , $checktitlebalisestop - $checktitlebalisestart_youtube);
					$checktitle = str_replace("<title type='text'>","",$checktitle);
					if ((strlen($checktitle)) > $is_modplayer_playlist_multiple_length_title) {
						$checktitle = substr($checktitle, 0 , $is_modplayer_playlist_multiple_length_title - 3);
						$checktitle = $checktitle."...";
					}
					$multiple_playlist_title[$i] = $checktitle;
				} else {
					$multiple_playlist_title[$i] = strrchr( $multiple_playlist_title[$i] , '/');
					$multiple_playlist_title[$i] = preg_replace('#/#', '', $multiple_playlist_title[$i]);
					$pos = strripos ( $multiple_playlist_title[$i]  , '.');
					if ($pos != false) {
						$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0, $pos);
					}
					$multiple_playlist_title[$i] = preg_replace('#_#', ' ', $multiple_playlist_title[$i]);
					$multiple_playlist_title[$i] = preg_replace('#%20#', ' ', $multiple_playlist_title[$i]);
					$multiple_playlist_title[$i] = ucfirst($multiple_playlist_title[$i]);
					if ((strlen($multiple_playlist_title[$i])) > $is_modplayer_playlist_multiple_length_title) {
						$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_modplayer_playlist_multiple_length_title - 3);
						$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
					}
				}
			}
			// close curl resource to free up system resources
			curl_close($ch);
		}
	} else if ($is_modplayer_playlist_multiple_dropdown_title == '1') {
		$multiple_playlist_title = explode(",", $is_modplayer_playlist_multiple_file);
		for($i = 0; $i < sizeof($multiple_playlist_title); ++$i) {
			$multiple_playlist_title[$i] = strrchr( $multiple_playlist_title[$i] , '/');
			$multiple_playlist_title[$i] = preg_replace('#/#', '', $multiple_playlist_title[$i]);
			$pos = strripos ( $multiple_playlist_title[$i]  , '.');
			if ($pos != false) {
				$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0, $pos);
			}
			$multiple_playlist_title[$i] = preg_replace('#_#', ' ', $multiple_playlist_title[$i]);
			$multiple_playlist_title[$i] = preg_replace('#%20#', ' ', $multiple_playlist_title[$i]);
			$multiple_playlist_title[$i] = ucfirst($multiple_playlist_title[$i]);
			if ((strlen($multiple_playlist_title[$i])) > $is_modplayer_playlist_multiple_length_title) {
				$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_modplayer_playlist_multiple_length_title - 3);
				$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
			}
		}
	} else if ($is_modplayer_playlist_multiple_dropdown_title == '0') {
		$multiple_playlist_title = $multiple_playlist;
		for($i = 0; $i < sizeof($multiple_playlist_title); ++$i) {
			if ((strlen($multiple_playlist_title[$i])) > $is_modplayer_playlist_multiple_length_title) {
				$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_modplayer_playlist_multiple_length_title - 3);
				$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
			}
		}
	}
}

//Playlist auto
$is_modplayer_playlist_auto = $params->get('mod_plauto');

// set slash Playlist auto
$is_modplayer_playlist_auto_first_slash = strpos ( $is_modplayer_playlist_auto , "/");
if ($is_modplayer_playlist_auto_first_slash == '0') {
	$is_modplayer_playlist_auto = "first".$is_modplayer_playlist_auto;
	$is_modplayer_playlist_auto = preg_replace('#first/#', '', $is_modplayer_playlist_auto);
}
$is_modplayer_playlist_auto_last_slash = strrpos ( $is_modplayer_playlist_auto , "/");
$length_is_modplayer_playlist_auto = strlen($is_modplayer_playlist_auto);
if ($is_modplayer_playlist_auto_last_slash != ($length_is_modplayer_playlist_auto - 1)) {
	$is_modplayer_playlist_auto = $is_modplayer_playlist_auto."/";
}

// set config Playlist auto
if ($is_modplayer_playlist_select =='2') {
	$is_modplayer_playlist_autosort = $params->get('mod_plautosort');
	$is_modplayer_playlist_auto_contentid = $params->get('mod_plautocontentID');

	//Assign Poss  Item For content ID Auto
	$itempos_contentid = explode(",", $is_modplayer_playlist_auto_contentid);
	while ($value = current($itempos_contentid)) {
		if ($value == $articleId) {
			$is_modplayer_playlist_item = key($itempos_contentid);
		}
		next($itempos_contentid);
	}

	$is_modplayer_playlist_autodefthumb = $params->get('mod_plautodefthumb');
	$is_modplayer_playlist_autoplaylistimage = $params->get('mod_plautoplaylistimage');
	$is_modplayer_playlist_autoduration = $params->get('mod_plautoduration');
	$is_modplayer_playlist_autotitle = $params->get('mod_plautotypetitle');
	$is_modplayer_playlist_autodesc = $params->get('mod_plautotypedescription');
	$is_modplayer_playlist_autoallowlink = $params->get('mod_plautoallowlink');
	$is_modplayer_playlist_autoallowjpg = $params->get('mod_plautoallowjpg');
	$is_modplayer_playlist_autoallowpng = $params->get('mod_plautoallowpng');
	$is_modplayer_playlist_autoallowgif = $params->get('mod_plautoallowgif');
	$is_modplayer_playlist_autoallowflv = $params->get('mod_plautoallowflv');
	$is_modplayer_playlist_autoallowmp3 = $params->get('mod_plautoallowmp3');
	$is_modplayer_playlist_autoallowmp4 = $params->get('mod_plautoallowmp4');
	$is_modplayer_playlist_autoallowm4a = $params->get('mod_plautoallowm4a');
	$is_modplayer_playlist_autoallowm4v = $params->get('mod_plautoallowm4v');
	$is_modplayer_playlist_autoallowmov = $params->get('mod_plautoallowmov');
	$is_modplayer_playlist_autoseparator = $params->get('mod_plautoseparator');
	$is_modplayer_playlist_autotrackpos = $params->get('mod_plautotrackposition');
	$is_modplayer_playlist_autotitlepos = $params->get('mod_plautotitleposition');
	$is_modplayer_playlist_autoauthorpos = $params->get('mod_plautoauthorposition');
	$is_modplayer_playlist_autodescpos = $params->get('mod_plautodescposition');
}

//Playlist editor
$is_modplayer_playlist_file1 = $params->get('mod_plfile1');
$is_modplayer_playlist_file2 = $params->get('mod_plfile2');
$is_modplayer_playlist_file3 = $params->get('mod_plfile3');
$is_modplayer_playlist_file4 = $params->get('mod_plfile4');
$is_modplayer_playlist_file5 = $params->get('mod_plfile5');

if ($is_modplayer_playlist_select =='1') {

	//set  XML playlist
	for($i = 1; $i < 6; ++$i) {
		//content ID
		${'is_modplayer_playlist_file_contentid'.$i} = $params->get("mod_plfilecontentID".$i);
		//Assign Poss  Item For content ID
		$itempos_contentid = explode(",", ${'is_modplayer_playlist_file_contentid'.$i});
		while ($value = current($itempos_contentid)) {
			if ($value == $articleId) {
				$is_modplayer_playlist_item = $i - 1;
			}
			next($itempos_contentid);
		}
		${'is_modplayer_playlist_hd.file'.$i} = $params->get('mod_plhdfile'.$i);
		${'is_modplayer_playlist_title'.$i} = $params->get('mod_pltitle'.$i);
		${'is_modplayer_playlist_description'.$i} = $params->get('mod_pldesc'.$i);
		${'is_modplayer_playlist_author'.$i} = $params->get('mod_plcredit'.$i);
		${'is_modplayer_playlist_image'.$i} = $params->get('mod_plthumbnail'.$i);
		${'is_modplayer_playlist_captions.file'.$i} = $params->get('mod_plcaption'.$i);
		${'is_modplayer_playlist_link'.$i} = $params->get('mod_pllink'.$i);
		${'is_modplayer_playlist_start'.$i} = $params->get('mod_plstart'.$i);
		${'is_modplayer_playlist_streamer'.$i} = $params->get('mod_plstreamer'.$i);
		${'is_modplayer_playlist_tags'.$i} = $params->get('mod_pltag'.$i);
		${'is_modplayer_playlist_duration'.$i} = $params->get('mod_plduration'.$i);
		${'is_modplayer_playlist_provider'.$i} = $params->get('mod_plformat'.$i);
		// Vimeo type and provider
		if ((${'is_modplayer_playlist_provider'.$i} == "vimeo") || ( (strpos( ${'is_modplayer_playlist_file'.$i} , 'http://vimeo.com/' )) !== false )) {
			${'is_modplayer_playlist_provider'.$i} = $playersite."modules/mod_playerjr_ad/vimeo.swf";
		}
	}

	if ($jw_html5 == '1') {
		$mode0 = "flash";
		$mode1 = "html5";
		$mode2 = "download";
		if ($is_modplayer_playlist_fallback_download == "1") {
			$count = 3;
		} else {
			$count = 2;
		}
		for ($i3 = 0; $i3 < $count; $i3++) {
								// set JSON playlist for flash, html5 and download , tab is just here for html layout of the JSON playlist
								${'is_modplayer_playlist_json_'.${'mode'.$i3}} = null;
								${'is_modplayer_playlist_json_'.${'mode'.$i3}}
								.= "
								'playlist': [";
								for($i = 1; $i < 6; ++$i) {
									if ($i3 == 0) {
										${"is_modplayer_playlist_file_array".$i} = explode(',', ${"is_modplayer_playlist_file".$i});
									} else if (empty(${"is_modplayer_playlist_file_array".$i}[$i3])) {
										${"is_modplayer_playlist_file_array".$i}[$i3] = ${"is_modplayer_playlist_file_array".$i}[0];
									}
									if (!(empty(${"is_modplayer_playlist_file_array".$i}[$i3]))) {
										//set file
									if ($i > 1)	{
									${'is_modplayer_playlist_json_'.${'mode'.$i3}}
									.= ",";
									}
									${'is_modplayer_playlist_json_'.${'mode'.$i3}} //JSON Playlist Editor
									.= "
									{
										'file': '".${"is_modplayer_playlist_file_array".$i}[$i3]."'";
										//set variable
										$index1 = "title".$i;
										$index2 = "description".$i;
										$index3 = "image".$i;
										$index4 = "duration".$i;
										$index5 = "hd.file".$i;
										$index6 = "captions.file".$i;
										$index7 = "provider".$i;
										$index8 = "start".$i;
										$index9 = "streamer".$i;
										$index10 = "link".$i;
										$index11 = "tags".$i;
										$index12 = "author".$i;
										for ($i2 = 1; $i2 < 13; $i2++) {
										if (!(empty(${'is_modplayer_playlist_'.${'index'.$i2}}))) {
										if (($i3 == 0) || ($i2 < 5) ||($i2 < 7 && $i3 == 1) || ($i2 == 7 && ((${'is_modplayer_playlist_'.${'index'.$i2}} == 'video') || (${'is_modplayer_playlist_'.${'index'.$i2}} == 'sound') || (${'is_modplayer_playlist_'.${'index'.$i2}} == 'image')))) {
										$is_modplayer_playlist_var = str_replace( $i, "", ${'index'.$i2});
										${'is_modplayer_playlist_'.${'index'.$i2}} = addslashes(${'is_modplayer_playlist_'.${'index'.$i2}});
										${'is_modplayer_playlist_json_'.${'mode'.$i3}}
										.= ",
										'".$is_modplayer_playlist_var."': '".${'is_modplayer_playlist_'.${'index'.$i2}}."'";
										}
										}
										}
									${'is_modplayer_playlist_json_'.${'mode'.$i3}}
									.= "
									}";
									}
								}
								${'is_modplayer_playlist_json_'.${'mode'.$i3}}
								.= "
								]";
		}
	}
}

// Construct the Global parameter for the playlist
if (($is_modplayer_playlist_select == '0' || $is_modplayer_playlist_select == '3') && $is_modplayer_playlist_file != '') {
	$is_modplayer_playlist = $is_modplayer_playlist_file;
} else if ($is_modplayer_playlist_select == '4' && $is_modplayer_playlist_botr != false && $is_modplayer_playlist_botr_file != '' && ($is_modplayer_playlist_botr_display == '1' || $is_modplayer_playlist_botr_display == '2' || $is_modplayer_playlist_botr_display == '3')) {
	$is_modplayer_playlist = $is_modplayer_playlist_botr_file;
} else if ($is_modplayer_playlist_auto != '' && $is_modplayer_playlist_select == '2') {
	if ($jwversion_playlist == '5')	{
		$is_modplayer_playlist = $playersite."modules/mod_playerjr_ad/autogenerate_playlist5.php?dir=".$is_modplayer_playlist_auto."&url=".$playersite."&sor=".base64_encode($is_modplayer_playlist_autosort)."&tyt=".$is_modplayer_playlist_autotitle."&tdes=".$is_modplayer_playlist_autodesc."&sep=".$is_modplayer_playlist_autoseparator."&tp=".$is_modplayer_playlist_autotitlepos."&ap=".$is_modplayer_playlist_autoauthorpos."&thu=".$is_modplayer_playlist_autodefthumb."&img=".$is_modplayer_playlist_autoplaylistimage."&dur=".$is_modplayer_playlist_autoduration."&trp=".$is_modplayer_playlist_autotrackpos."&li=".$is_modplayer_playlist_autoallowlink."&jpg=".$is_modplayer_playlist_autoallowjpg."&png=".$is_modplayer_playlist_autoallowpng."&gif=".$is_modplayer_playlist_autoallowgif."&flv=".$is_modplayer_playlist_autoallowflv."&mp3=".$is_modplayer_playlist_autoallowmp3."&mp4=".$is_modplayer_playlist_autoallowmp4."&m4a=".$is_modplayer_playlist_autoallowm4a."&m4v=".$is_modplayer_playlist_autoallowm4v."&mov=".$is_modplayer_playlist_autoallowmov."&dp=".$is_modplayer_playlist_autodescpos;
	} else if ($jwversion_playlist == '') {
		$is_modplayer_playlist = $playersite."modules/mod_playerjr_ad/autogenerate_playlist.php?dir=".$is_modplayer_playlist_auto."&url=".$playersite."&sor=".base64_encode($is_modplayer_playlist_autosort)."&tyt=".$is_modplayer_playlist_autotitle."&tdes=".$is_modplayer_playlist_autodesc."&sep=".$is_modplayer_playlist_autoseparator."&tp=".$is_modplayer_playlist_autotitlepos."&ap=".$is_modplayer_playlist_autoauthorpos."&thu=".$is_modplayer_playlist_autodefthumb."&dur=".$is_modplayer_playlist_autoduration."&trp=".$is_modplayer_playlist_autotrackpos."&li=".$is_modplayer_playlist_autoallowlink."&jpg=".$is_modplayer_playlist_autoallowjpg."&png=".$is_modplayer_playlist_autoallowpng."&gif=".$is_modplayer_playlist_autoallowgif."&flv=".$is_modplayer_playlist_autoallowflv."&mp3=".$is_modplayer_playlist_autoallowmp3."&mp4=".$is_modplayer_playlist_autoallowmp4."&m4a=".$is_modplayer_playlist_autoallowm4a."&m4v=".$is_modplayer_playlist_autoallowm4v."&mov=".$is_modplayer_playlist_autoallowmov."&dp=".$is_modplayer_playlist_autodescpos;
	}
} else if ($is_modplayer_playlist_file1 != '' && $is_modplayer_playlist_select == '1') {
	$is_modplayer_playlist = $playersite."modules/mod_playerjr_ad/playlist5.php?pf1=".base64_encode($is_modplayer_playlist_file1)."&hd1=".base64_encode(${'is_modplayer_playlist_hd.file1'})."&pd1=".base64_encode($is_modplayer_playlist_description1)."&pc1=".base64_encode($is_modplayer_playlist_author1)."&pth1=".base64_encode($is_modplayer_playlist_image1)."&tg1=".base64_encode($is_modplayer_playlist_tags1)."&pt1=".base64_encode($is_modplayer_playlist_title1)."&pl1=".base64_encode($is_modplayer_playlist_link1)."&st1=".$is_modplayer_playlist_start1."&str1=".base64_encode($is_modplayer_playlist_streamer1)."&cap1=".base64_encode(${'is_modplayer_playlist_captions.file1'})."&dur1=".$is_modplayer_playlist_duration1."&pfo1=".$is_modplayer_playlist_provider1."&pf2=".base64_encode($is_modplayer_playlist_file2)."&hd2=".base64_encode(${'is_modplayer_playlist_hd.file2'})."&pd2=".base64_encode($is_modplayer_playlist_description2)."&pc2=".base64_encode($is_modplayer_playlist_author2)."&pth2=".base64_encode($is_modplayer_playlist_image2)."&tg2=".base64_encode($is_modplayer_playlist_tags2)."&pt2=".base64_encode($is_modplayer_playlist_title2)."&pl2=".base64_encode($is_modplayer_playlist_link2)."&st2=".$is_modplayer_playlist_start2."&str2=".base64_encode($is_modplayer_playlist_streamer2)."&cap2=".base64_encode(${'is_modplayer_playlist_captions.file2'})."&dur2=".$is_modplayer_playlist_duration2."&pfo2=".$is_modplayer_playlist_provider2."&pd3=".base64_encode($is_modplayer_playlist_description3)."&pf3=".base64_encode($is_modplayer_playlist_file3)."&hd3=".base64_encode(${'is_modplayer_playlist_hd.file3'})."&pc3=".base64_encode($is_modplayer_playlist_author3)."&pth3=".base64_encode($is_modplayer_playlist_image3)."&tg3=".base64_encode($is_modplayer_playlist_tags3)."&pt3=".base64_encode($is_modplayer_playlist_title3)."&pl3=".base64_encode($is_modplayer_playlist_link3)."&st3=".$is_modplayer_playlist_start3."&str3=".base64_encode($is_modplayer_playlist_streamer3)."&cap3=".base64_encode(${'is_modplayer_playlist_captions.file3'})."&dur3=".$is_modplayer_playlist_duration3."&pfo3=".$is_modplayer_playlist_provider3."&pf4=".base64_encode($is_modplayer_playlist_file4)."&hd4=".base64_encode(${'is_modplayer_playlist_hd.file4'})."&pd4=".base64_encode($is_modplayer_playlist_description4)."&pc4=".base64_encode($is_modplayer_playlist_author4)."&pth4=".base64_encode($is_modplayer_playlist_image4)."&tg4=".base64_encode($is_modplayer_playlist_tags4)."&pt4=".base64_encode($is_modplayer_playlist_title4)."&pl4=".base64_encode($is_modplayer_playlist_link4)."&st4=".$is_modplayer_playlist_start4."&str4=".base64_encode($is_modplayer_playlist_streamer4)."&cap4=".base64_encode(${'is_modplayer_playlist_captions.file4'})."&dur4=".$is_modplayer_playlist_duration4."&pfo4=".$is_modplayer_playlist_provider4."&pf5=".base64_encode($is_modplayer_playlist_file5)."&hd5=".base64_encode(${'is_modplayer_playlist_hd.file5'})."&pd5=".base64_encode($is_modplayer_playlist_description5)."&pc5=".base64_encode($is_modplayer_playlist_author5)."&pth5=".base64_encode($is_modplayer_playlist_image5)."&tg5=".base64_encode($is_modplayer_playlist_tags5)."&pt5=".base64_encode($is_modplayer_playlist_title5)."&pl5=".base64_encode($is_modplayer_playlist_link5)."&st5=".$is_modplayer_playlist_start5."&str5=".base64_encode($is_modplayer_playlist_streamer5)."&cap5=".base64_encode(${'is_modplayer_playlist_captions.file5'})."&pfo5=".$is_modplayer_playlist_provider5."&dur5=".$is_modplayer_playlist_duration5;
} else if ($is_modplayer_playlist_select == '5') {
	$is_modplayer_playlist = '';
} else {
	$is_modplayer_playlist = '';
	$is_modplayer_playlisttype = "file";
}

//set playlist for  embed code for pop-up windows
$is_modplayer_playlist2 = preg_replace('#&#', '%26', $is_modplayer_playlist);

//Html validate for JW4 and 5
$is_modplayer_playlist = urlencode($is_modplayer_playlist);

if ($jwversion == '5') {
	//set playlist for  embed code for sharing code
	$is_modplayer_playlist3 = preg_replace('#&#', '%2526', $is_modplayer_playlist);
} else {
	$is_modplayer_playlist3 = $is_modplayer_playlist2;
}

// set array flashvars
$is_modplayer_flashvars = array();

// JS events
$is_modplayer_events = $params->get('Playlistevents');

// Extra JS
$is_modplayer_extra_js_sfx = $params->get('extrajsname');


// Plugin and setting parameters
//check width
$is_modplayer_flashvars["width"]= $params->get('PlaylistWidth');

//check height
$is_modplayer_flashvars["height"] = $params->get('PlaylistHeight');

// height/width replace if botr combine is set
if ($is_modplayer_playlist_select =='4') {
	// verify is botr combine is not set
	if ($is_modplayer_playlist_botr_display == '1')	{
		// height replace if botr combine is set
		if (!(empty($is_modplayer_flashvars_botr["height"]))) {
			$is_modplayer_flashvars["height"] = $is_modplayer_flashvars_botr["height"];
		}
		// width replace if botr combine is set
		if (!(empty($is_modplayer_flashvars_botr["width"]))) {
			$is_modplayer_flashvars["width"] = $is_modplayer_flashvars_botr["width"];
		}
	}
}

//check playlistsize
$is_modplayer_flashvars["playlistsize"] = $params->get('PlaylistSize');

// set transparence
$is_modplayer_flashvars["wmode"] = $params->get('Playlistwmode');

//check if logo is ask
$is_modplayer_playlist_logo = $params->get('PlaylistLogo');
if ($is_modplayer_playlist_logo != '' )	{
	$is_modplayer_flashvars["logo"] = $is_modplayer_playlist_logo;
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
	$is_modplayer_playlist_var = $params->get("Playlist".(str_replace(".", "", ${'index'.$i})));
	if ($is_modplayer_playlist_var != '' && $is_modplayer_playlist_var != ${'index_defaut'.$i})	{
		if ($i > 8) {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var ? 'true' : 'false' ;
		} else {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var;
		}
	}
}

//set  simple flashwars
$count = 12;
$index1 = 'playlist';
$index_defaut1 = 'none';
$index2 = 'bandwidth';
$index_defaut2 = '5000';
$index3 = 'linktarget';
$index_defaut3 = '_blank';
$index4 = 'debug';
$index_defaut4 = 'none';
$index5 = 'displayclick';
$index_defaut5 = 'play';
$index6 = 'config';
$index_defaut6 = '';
$index7 = 'abouttext';
$index_defaut7 = '';
$index8 = 'aboutlink';
$index_defaut8 = '';
//set  true false flaswars
$index9 = 'displaytitle';
$index_defaut9 = '0';
$index10 = 'dock';
$index_defaut10 = '0';
$index11 = 'mute';
$index_defaut11 = '0';
for ($i = 1; $i < $count; $i++) {
	$is_modplayer_playlist_var = $params->get("Playlist".${'index'.$i});
	if ($is_modplayer_playlist_var != '' && $is_modplayer_playlist_var != ${'index_defaut'.$i})	{
		if ($i > 8) {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var ? 'true' : 'false' ;
		} else {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var;
		}
	}
}

//set  simple flashwars  with first letter capitalize
$count = 15;
$index1 = 'controlbar';
$index_defaut1 = $index_defaut_controlbar;
$index2 = 'bufferlength';
$index_defaut2 = '1';
$index3 = 'repeat';
$index_defaut3 = 'none';
$index4 = 'stretching';
$index_defaut4 = 'uniform';
$index5 = 'volume';
$index_defaut5 = '90';
$index6 = 'backcolor';
$index_defaut6 = '';
$index7 = 'frontcolor';
$index_defaut7 = '';
$index8 = 'lightcolor';
$index_defaut8 = '';
$index9 = 'screencolor';
$index_defaut9 = '';
//set  true false flaswars
$index10 = 'autostart';
$index_defaut10 = '0';
$index11 = 'resizing';
$index_defaut11 = '1';
$index12 = 'shuffle';
$index_defaut12 = '0';
$index13 = 'smoothing';
$index_defaut13 = '1';
$index14 = 'icons';
$index_defaut14 = '1';
for ($i = 1; $i < $count; $i++) {
	$is_modplayer_playlist_var = $params->get("Playlist".(ucfirst(${"index".$i})));
	if ($is_modplayer_playlist_var != '' && $is_modplayer_playlist_var != ${'index_defaut'.$i})	{
		if ($i > 9) {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var ? 'true' : 'false' ;
		} else {
			$is_modplayer_flashvars[${'index'.$i}] = $is_modplayer_playlist_var;
		}
	}
}

// Pop-up
$is_modplayer_popup_enabled = $params->get('Playlistpopupenabled');
$is_modplayer_popup_linkchoice  = $params->get('Playlistpopuplinkchoice');
$is_modplayer_popup_high = $params->get('Playlistpopuphighslide');
$is_modplayer_popup_sizechoice = $params->get('Playlistpopupsizechoice');
if($is_modplayer_popup_enabled == '1') {

	// set pop-up display for botr
	if ($is_modplayer_playlist_botr_display == '0' && $is_modplayer_playlist_botr != false && ($is_modplayer_popup_high == '0' || $is_modplayer_popup_high == '1'))	{
		$is_modplayer_popup_high = '2';
	}
	// set Link choice for botr
	if ($is_modplayer_playlist_botr_display == '0' && $is_modplayer_playlist_botr != false && ($is_modplayer_popup_linkchoice == '0' || $is_modplayer_popup_linkchoice == '1' || $is_modplayer_popup_linkchoice == '2')) {
		$is_modplayer_popup_linkchoice = '3';
	}

	//Link choice
	$is_modplayer_popup_text = $params->get('Playlistpopuptextlink');
	if($is_modplayer_popup_linkchoice == '1' || $is_modplayer_popup_linkchoice == '2' || $is_modplayer_popup_linkchoice == '4' || $is_modplayer_popup_linkchoice == '5') {
		$is_modplayer_popup_img = $params->get('Playlistpopupimagelink');
		$is_modplayer_popup_link = "<img src=\"".$is_modplayer_popup_img."\" alt=\"".$is_modplayer_popup_text."\" />";
	} else {
		$is_modplayer_popup_link = $is_modplayer_popup_text;
	}
	// Size choice
	if($is_modplayer_popup_sizechoice == '1') {
		$is_modplayer_playlist_popupsize = $params->get('PlaylistpopupSize');
		$is_modplayer_playlist_popupheight = $params->get('PlaylistpopupHeight');
		$is_modplayer_playlist_popupwidth = $params->get('PlaylistpopupWidth');
	} else {
		$is_modplayer_playlist_popupsize = $is_modplayer_flashvars["playlistsize"];
		$is_modplayer_playlist_popupheight = $is_modplayer_flashvars["height"];
		$is_modplayer_playlist_popupwidth = $is_modplayer_flashvars["width"];
	}

	//Load jquery.jwbox.js for JW Box
	$modulejqueryjwboxjs_sfx = $params->get('PlaylistjqueryjwboxLoad');
	if($modulejqueryjwboxjs_sfx == '0' && $is_modplayer_popup_high == '2') {
		// getting module head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of script section
		$headDataply_keys = array_keys($headDataply["scripts"]);
		// set variable for false
		$modulejqueryjwboxjs_sfx = '2';
		// searching phrase jquery.jwbox.js in scripts paths
		for($i = 0;$i < count($headDataply_keys); $i++) {
			if(preg_match('/jquery.jwbox.js/i', $headDataply_keys[$i]))	{
				// if founded set variable to true and break loop
				$modulejqueryjwboxjs_sfx = '1';
				break;
			}
		}
	}

	//Load CSS for JW Box
	$modulecssjwbox_sfx = $params->get('PlaylistcssLoad');
	$modulefieldcssjwbox_sfx = $params->get('mod_css');
	$modulefieldcssjwbox_sfx = "<style type=\"text/css\">".$modulefieldcssjwbox_sfx."</style>";
}

//container of jw box text overidde
if (($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '2') && ($is_modplayer_popup_linkchoice == '5' || $is_modplayer_popup_linkchoice == '3' || $is_modplayer_popup_linkchoice == '4')) {
	$is_modplayer_popup_container = $params->get('Playlistjwboxcontainer');
} else {
	$is_modplayer_popup_container = "div";
}

//Load  jquery for JW Box
$modulejqueryjwbox_sfx = $params->get('PlaylistjqueryLoad');
$modulemootoolsjwbox_sfx = $params->get('Playlistjquerymootoolsconflict', '0');
if($modulejqueryjwbox_sfx == '0' && ($is_modplayer_popup_enabled == '1' && $is_modplayer_popup_high == '2')) {
	// getting module head section datas
	unset($headDataply);
	$headDataply = $document->getHeadData();
	// generate keys of script section
	$headDataply_keys = array_keys($headDataply["scripts"]);
	// set variable for false
	$modulejqueryjwbox_sfx_founded = '0';
	// searching phrase jquery in scripts paths
	for($i = 0;$i < count($headDataply_keys); $i++)	{
		if(preg_match('/jquery/i', $headDataply_keys[$i])) {
			// if founded set variable to true and break loop
			$modulejqueryjwbox_sfx_founded = '1';
			break;
		}
	}
} else if($modulejqueryjwbox_sfx == '2') {
	$modulejqueryjwbox_sfx_founded = '0';
} else if($modulejqueryjwbox_sfx == '1') {
	$modulejqueryjwbox_sfx_founded = '1';
}

//Multiple Playlist RSS //Assign class for the dropdown list
if ($is_modplayer_playlist_select == '3') {
	//Assign class for the dropdown list
	$is_modplayer_playlist_multiple_dropdown_style = $params->get('mod_plmultidropdownstyle');
	$is_modplayer_playlist_multiple_dropdown_class = $params->get('mod_plmultidropdownclass');
	if ($is_modplayer_playlist_multiple_dropdown_style == '0') {
		$is_modplayer_playlist_multiple_dropdown_class = "style=\"width:".$is_modplayer_flashvars["width"]."px\"";
		if($is_modplayer_popup_sizechoice == '1' && $is_modplayer_popup_enabled == '1') {
			$is_modplayer_playlist_multiple_dropdown_class_popup = "style=\"width:".$is_modplayer_playlist_popupwidth."px\"";
		} else {
			$is_modplayer_playlist_multiple_dropdown_class_popup = $is_modplayer_playlist_multiple_dropdown_class;
		}
	} else if ($is_modplayer_playlist_multiple_dropdown_style == '1') {
		$is_modplayer_playlist_multiple_dropdown_class_popup = "class=\"pop".$is_modplayer_playlist_multiple_dropdown_class."\"";
		$is_modplayer_playlist_multiple_dropdown_class = "class=\"".$is_modplayer_playlist_multiple_dropdown_class."\"";
	} else {
		$is_modplayer_playlist_multiple_dropdown_class = "";
		$is_modplayer_playlist_multiple_dropdown_class_popup = "";
	}
}

//check if a skin swf is ask
$index = 'skin';
$is_modplayer_playlist_skintype = $params->get('PlaylistSkintype');
$is_modplayer_playlist_skin = $params->get('PlaylistSkin');
$is_modplayer_playlist_skin_xml = $params->get('PlaylistSkinxml');
if($is_modplayer_playlist_skin != '-1' && $is_modplayer_playlist_skin != '' && $is_modplayer_playlist_skintype == '0' && $is_modplayer_playlist_skin != 'index') {
	$is_modplayer_flashvars[$index] = $is_modplayer_playlist_skin = $playersite."modules/mod_playerjr_ad/skin/swf/".$is_modplayer_playlist_skin.".swf";
} else if($is_modplayer_playlist_skin_xml != '-1' && $is_modplayer_playlist_skin_xml != '' && $is_modplayer_playlist_skintype == '1'  && $is_modplayer_playlist_skin_xml != 'index' && $jwversion == '5') {
	$is_modplayer_flashvars[$index] = $is_modplayer_playlist_skin = $playersite."modules/mod_playerjr_ad/skin/xml/".$is_modplayer_playlist_skin_xml.".zip";
}

//check if extra flashvars  is ask
$is_modplayer_playlist_extra_flashvars = $params->get('extrapluginflashvarslist');
if ($is_modplayer_playlist_extra_flashvars != '') {
	$tab = explode('&', $is_modplayer_playlist_extra_flashvars);
	$is_modplayer_playlist_extra_flashvars2 = array();
	foreach ($tab as $ligne) {
		$a = explode('=', $ligne);
		$is_modplayer_playlist_extra_flashvars2[$a[0]] = $a[1];
	}
	$is_modplayer_playlist_extra_flashvars = $is_modplayer_playlist_extra_flashvars2;
	// ad extra flasvars to array flashvars
	$is_modplayer_flashvars = $is_modplayer_flashvars + $is_modplayer_playlist_extra_flashvars2;
}

//build the plugin array
$index = 'plugins';

//check if botr have plugin set
if (!(empty($is_modplayer_flashvars_botr[$index]))) {
	$is_modplayer_plugin_botr = $is_modplayer_flashvars_botr[$index];
	$is_modplayer_plugin_botr = str_replace( '{plugins=', '', $is_modplayer_plugin_botr );
	$is_modplayer_plugin_array_botr = explode(',', $is_modplayer_plugin_botr);
}

// plugin set
$is_modplayer_plugin_array = array();

//check if Sharing is enabled
if (($is_modplayer_playlist_select !='4') || ($is_modplayer_playlist_select =='4' && $is_modplayer_playlist_botr_display != '1')) {
	//set version of the plugin
	$is_modplayer_sharing_version = $params->get('SharingPluginversion');
	$index = "sharing-".$is_modplayer_sharing_version;
	//enable embed and link
	$is_modplayer_sharingembed_enabled = $params->get('SharingPluginembedEnabled');
	$is_modplayer_sharinglink_enabled = $params->get('SharingPluginlinkEnabled');
	$is_modplayer_sharinglink = $params->get('SharingPluginlink');
	$is_modplayer_sharinglink_thumb = $params->get('SharingPluginthumbnail');
	// set  link
	if($is_modplayer_sharinglink_enabled == '1' && $is_modplayer_sharinglink != '') {
		$is_modplayer_flashvars["sharing.link"] = $is_modplayer_sharinglink;
	} else if ($is_modplayer_sharinglink_enabled == '1' && $is_modplayer_sharing_version != '1') {
		$u =& JURI::getInstance();
		$is_modplayer_flashvars["sharing.link"] = urlencode($u->toString());
	} else if ($is_modplayer_sharinglink_enabled == '0' && $is_modplayer_sharing_version == '1' && $is_modplayer_sharingembed_enabled == '1') {
		$is_modplayer_flashvars["sharing.link"] = 'none';
	}
	//set code embed validation
	if($is_modplayer_sharingembed_enabled == '1') {
		$is_modplayer_sharing_enabled = "sharing-".$is_modplayer_sharing_version;
	} else {
		$is_modplayer_sharing_enabled = '';
	}
	//load plugin
	if($is_modplayer_sharingembed_enabled == '1' || $is_modplayer_sharinglink_enabled == '1') {
		$is_modplayer_plugin_array[] = $index;
	}
} else {
	$is_modplayer_sharing_enabled = '';
}

// Load plugin
$scan_plugin_dir_result = dir(dirname(__FILE__).DS."includes".DS."plugins");
if ($scan_plugin_dir_result != '') {
	while($value = $scan_plugin_dir_result->read()) {
		if ($value != '.' && $value != '..' && $value != '' && (stripos( $value , ".php" ) !== false)) {
			include (dirname(__FILE__).DS."includes".DS."plugins".DS.$value);
		}
	}
	$scan_plugin_dir_result->close();
}

// array replace if botr combine is set
if ($is_modplayer_playlist_select =='4') {
	// verify is botr override local combine is set
	if ($is_modplayer_playlist_botr_display == '1')	{
		$is_modplayer_flashvars = $is_modplayer_flashvars_botr + $is_modplayer_flashvars;
	}
	// verify is local override botr combine is set
	if ($is_modplayer_playlist_botr_display == '2')	{
		$is_modplayer_flashvars = $is_modplayer_flashvars + $is_modplayer_flashvars_botr;
	}
}

//check if playlist is ask and change to playlist.position, this for jwplayer.js compatibilty
if (!(empty($is_modplayer_flashvars['playlist'])) && $jwversion == '5') {
	$is_modplayer_playlist_position = $is_modplayer_flashvars['playlist.position'] = $is_modplayer_flashvars['playlist'];
	unset($is_modplayer_flashvars['playlist']);
} else {
	$is_modplayer_playlist_position = "";
}

//Insert the plugin array and clean the string flaswars
$is_modplayer_plugin = implode(',', $is_modplayer_plugin_array);
unset($is_modplayer_flashvars['plugins']);
if (!(empty($is_modplayer_plugin))) {
	$is_modplayer_flashvars['plugins'] = $is_modplayer_plugin;
}

// add extra plugin is ask
$is_modplayer_extra_plugin_list = $params->get('extrapluginlist');
if ($is_modplayer_extra_plugin_list != '') {
	if (!(empty($is_modplayer_plugin)))	{
		$is_modplayer_plugin = $is_modplayer_plugin.",".$is_modplayer_extra_plugin_list;
		unset($is_modplayer_flashvars['plugins']);
		$is_modplayer_flashvars['plugins'] = $is_modplayer_plugin;
	} else {
		$is_modplayer_plugin = $is_modplayer_extra_plugin_list;
		unset($is_modplayer_flashvars['plugins']);
		$is_modplayer_flashvars['plugins'] = $is_modplayer_plugin;
	}
}

// array replace if botr combine is set
if ($is_modplayer_playlist_select =='4') {
	// verify is botr combine is not set
	if ($is_modplayer_playlist_botr_display == '1' || $is_modplayer_playlist_botr_display == '2') {
		if ((!(empty($is_modplayer_plugin_botr))) && (!(empty($is_modplayer_plugin)))) {
			$is_modplayer_plugin = $is_modplayer_plugin.",".$is_modplayer_plugin_botr;
			unset($is_modplayer_flashvars['plugins']);
			$is_modplayer_flashvars['plugins'] = $is_modplayer_plugin;
		} else if (!(empty($is_modplayer_plugin_botr))) {
			unset($is_modplayer_flashvars['plugins']);
			$is_modplayer_flashvars['plugins'] = $is_modplayer_plugin_botr;
		}
	}
}

//create plugin flashvars array for HTML5 embedder
if ($jw_html5 == '1' && !(empty($is_modplayer_flashvars["plugins"]))) {
	$is_modplayer_plugin_array = explode(',', $is_modplayer_flashvars["plugins"]);
}

// set array item
if ($is_modplayer_playlist_item != '' && $is_modplayer_playlist_item != '0') {
	$is_modplayer_flashvars["item"] = $is_modplayer_playlist_item;
}

// set array flashvars for pop-up
if ($is_modplayer_popup_enabled == '1') {
	$is_modplayer_flashvars_popup = $is_modplayer_flashvars;
	// Size choice
	if ($is_modplayer_popup_sizechoice == '1') {
		$is_modplayer_flashvars_popup["width"] = $is_modplayer_playlist_popupwidth;
		$is_modplayer_flashvars_popup["height"] = $is_modplayer_playlist_popupheight;
		$is_modplayer_flashvars_popup["playlistsize"] = $is_modplayer_playlist_popupsize;
	}
}
	
//Load share video meta for facebook
$module_meta_sfx = $params->get('Playlistmetaload');
// set variable for false
$facebook_video_sharing = '0';
$module_meta_sfx_founded = '0';
if ((($is_modplayer_playlist_select !='4') || ($is_modplayer_playlist_select =='4' && $is_modplayer_playlist_botr_display != '0' )) && (($is_modplayer_sharing_enabled != '') || $is_modplayer_Facebook_enabled == '1')) {
	if ($module_meta_sfx == '2') {
		// getting module head section datas
		unset($headDataply);
		$headDataply = $document->getHeadData();
		// generate keys of link rel section
		$headDataply_keys = array_keys($headDataply["metaTags"]["standard"]);
		// searching phrase swf in link rel paths
		for ($i = 0;$i < count($headDataply_keys); $i++) {
			if (preg_match('/video_type/i', $headDataply_keys[$i])) {
				// if founded set variable to true and break loop
				$module_meta_sfx_founded = '1';
				break;
			}
		}
	} else if ($module_meta_sfx == '1')	{
		$module_meta_sfx_founded = '0';
	} else {
		$module_meta_sfx_founded = '1';
	}
	//set facebook sharing
	if ($module_meta_sfx_founded == '0') {
		if ($is_modplayer_sharing_enabled != '') {
			//set facebook sharing
			if ($is_modplayer_sharinglink_enabled == '1' && $is_modplayer_sharinglink_thumb != '') {
				$facebook_video_sharing = '1';
				$facebook_video_sharing_thumbnail = $is_modplayer_sharinglink_thumb;
			}
		}
		if ($is_modplayer_Facebook_enabled == '1') {
			//set facebook sharing
			if ($is_modplayer_Facebook_thumbnail != '') {
				$facebook_video_sharing = '1';
				$facebook_video_sharing_thumbnail = $is_modplayer_Facebook_thumbnail;
			}
		}
		if ($facebook_video_sharing == '1') {
			//set player metatag
			$player_metatag = $moduleswf_player.$moduleswf_signplayer."&amp;".$is_modplayer_playlisttype."=".$is_modplayer_playlist3;
			$i = 1;
			while (list($key, $value) = each($is_modplayer_flashvars)) {
				$player_metatag .="&amp;".$key."=".$value;
				$i++;
			}
			reset($is_modplayer_flashvars);
			// remove playlist display if width is > 420 px or if height > 280 px
			if ($is_modplayer_flashvars["height"] > 280 && ($is_modplayer_playlist_position == 'bottom' || $is_modplayer_playlist_position == 'top')) {
				$is_modplayer_playlist_height_facebook = $is_modplayer_flashvars["height"] - $is_modplayer_flashvars["playlistsize"];
				$player_metatag = str_replace( "&amp;height=".$is_modplayer_flashvars["height"], "&amp;height=".$is_modplayer_playlist_height_facebook, $player_metatag );
				$is_modplayer_playlist_width_facebook = $is_modplayer_flashvars["width"];
				//remove playlist flashvars
				$player_metatag = str_replace( "&amp;playlist.position=".$is_modplayer_playlist_position, "", $player_metatag );
				$player_metatag = str_replace( "&amp;playlistsize=".$is_modplayer_flashvars["playlistsize"], "", $player_metatag );
			} else if ($is_modplayer_flashvars["width"] > 420 && ($is_modplayer_playlist_position == 'right' || $is_modplayer_playlist_position == 'left'))	{
				$is_modplayer_playlist_height_facebook = $is_modplayer_flashvars["height"];
				$is_modplayer_playlist_width_facebook = $is_modplayer_flashvars["width"] - $is_modplayer_flashvars["playlistsize"];
				$player_metatag = str_replace( "&amp;width=".$is_modplayer_flashvars["width"], "&amp;width=".$is_modplayer_playlist_width_facebook, $player_metatag );
				//remove playlist flashvars
				$player_metatag = str_replace( "&amp;playlist.position=".$is_modplayer_playlist_position, "", $player_metatag );
				$player_metatag = str_replace( "&amp;playlistsize=".$is_modplayer_flashvars["playlistsize"], "", $player_metatag );
			} else {
				$is_modplayer_playlist_height_facebook = $is_modplayer_flashvars["height"];
				$is_modplayer_playlist_width_facebook = $is_modplayer_flashvars["width"];
			}
		}
	}
}

require( JModuleHelper::getLayoutPath( 'mod_playerjr_ad' ));