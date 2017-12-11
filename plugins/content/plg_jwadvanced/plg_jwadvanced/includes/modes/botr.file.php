<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage botr.file.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// set true botr
$is_plgplayer_playlist_botr = true;

//check  what kind of playlist botr is ask
$index1 = 'botr.display';
if (empty($is_plgplayer_flashvars[$index1])) {
	$is_plgplayer_playlist_botr_display = $params->get('mod_plbotrdisplay', 'botr');
} else {
	$is_plgplayer_playlist_botr_display = $is_plgplayer_flashvars[$index1];
	unset($is_plgplayer_flashvars[$index1]);
}

//botr file is ask
$index1 = 'botr.file';
$is_plgplayer_playlist_botr_file = $is_plgplayer_flashvars[$index1];
$index2 = 'botr.secret';
if (empty($is_plgplayer_flashvars[$index2])) {
	$secret = $params->get('mod_plbotrsecretkey', '');
} else {
	$secret = $is_plgplayer_flashvars[$index2];
	unset($is_plgplayer_flashvars[$index2]);
}
$index3 = 'botr.timeout';
if (empty($is_plgplayer_flashvars[$index3])) {
	$timeout = $params->get('mod_plbotrtimeout', '3600');
} else {
	$timeout = $is_plgplayer_flashvars[$index3];
	unset($is_plgplayer_flashvars[$index3]);
}
$index4 = 'botr.apikey';
if (empty($is_plgplayer_flashvars[$index4])) {
	$apikey = $params->get('mod_plbotrapikey', '');
} else {
	$apikey = $is_plgplayer_flashvars[$index4];
	unset($is_plgplayer_flashvars[$index4]);
}
$index5 = 'botr.player';
if (empty($is_plgplayer_flashvars[$index5])) {
	$playerid = $params->get('mod_plbotrdefaultplayer', '');
} else {
	$playerid = $is_plgplayer_flashvars[$index5];
	unset($is_plgplayer_flashvars[$index5]);
}

// check video joomlarulez web adresss
$checkvideojoomlarulez = stripos($is_plgplayer_playlist_botr_file, 'video.joomlarulez.com');

if ($checkvideojoomlarulez != false) {
	//replace video.joomlarulez.com by content.bitsontherun.com for secret
	if ($checkvideojoomlarulez != false) {
		$is_plgplayer_playlist_botr_file = str_replace( 'video.joomlarulez.com', 'content.bitsontherun.com', $is_plgplayer_playlist_botr_file );
	}
	
	// set js array
	$is_plgplayer_playlist_botr_file = str_replace( 'http://', '', $is_plgplayer_playlist_botr_file );
	$is_plgplayer_playlist_botr_file_array = explode("/", $is_plgplayer_playlist_botr_file);
	
	// botr url already sign
	if (stripos($is_plgplayer_playlist_botr_file, '/previews/')) {
		$is_plgplayer_playlist_botr_file_array[1] = str_replace( 'previews', 'players', $is_plgplayer_playlist_botr_file_array[1] );
		$botr_file_array_2_balisestop = stripos($is_plgplayer_playlist_botr_file_array[2], '?');
		$botr_file_array_2_length = strlen($is_plgplayer_playlist_botr_file_array[2]);
		$is_plgplayer_playlist_botr_file_array[2] = substr($is_plgplayer_playlist_botr_file_array[2], 0 , ($botr_file_array_2_length - ($botr_file_array_2_length - $botr_file_array_2_balisestop)));
		$is_plgplayer_playlist_botr_file_array[2] = str_replace( '?', '', $is_plgplayer_playlist_botr_file_array[2] );
	}

	// find video ID
	$videoid = str_replace( '.js', '', $is_plgplayer_playlist_botr_file_array[2] );
	$videoidbalisestop = stripos($videoid, '-');
	$videoidlength = strlen  ($videoid);
	$videoid = substr($videoid, 0 , ($videoidlength - $videoidbalisestop));
	$videoid = str_replace( '-', '', $videoid );

	// find player ID
	if ($playerid == '') {
		$playerid = str_replace( '.js', '', $is_plgplayer_playlist_botr_file_array[2] );
		$playeridbalisestart = stripos($playerid, '-');
		$playerid = substr($playerid, $playeridbalisestart , $videoidlength);
		$playerid = str_replace( '-', '', $playerid );
	} else if ($is_plgplayer_playlist_botr_display == 'botr') {
		// replace player ID in file js adress file if botr diplay is ask
		$playerid2 = str_replace( '.js', '', $is_plgplayer_playlist_botr_file_array[2] );
		$playeridbalisestart = stripos($playerid2, '-');
		$playerid2 = substr($playerid2, $playeridbalisestart , $videoidlength);
		$playerid2 = str_replace( '-', '', $playerid2 );
		$is_plgplayer_playlist_botr_file_array[2] = str_replace( $playerid2, $playerid, $is_plgplayer_playlist_botr_file_array[2] );
	}

	// set js secret
	$expires = time() + $timeout;
	$signature = md5($is_plgplayer_playlist_botr_file_array[1].'/'.$is_plgplayer_playlist_botr_file_array[2].':'.$expires.':'.$secret);
	$is_plgplayer_playlist_botr_file = 'http://'.$is_plgplayer_playlist_botr_file_array[0].'/'.$is_plgplayer_playlist_botr_file_array[1].'/'.$is_plgplayer_playlist_botr_file_array[2].'?exp='.$expires.'&sig='.$signature;

	// set xml secret
	$signature = md5('jwp/'.$videoid.'.xml:'.$expires.':'.$secret);
	$is_plgplayer_playlist_botr_xml = "http://content.bitsontherun.com/jwp/".$videoid.".xml?exp=".$expires."&sig=".$signature;

	//replace video.joomlarulez.com by content.bitsontherun.com for secret
	//if ($checkvideojoomlarulez != false) {
	//	$is_plgplayer_playlist_botr_file = str_replace( 'content.bitsontherun.com', 'video.joomlarulez.com', $is_plgplayer_playlist_botr_file );
	//}

	// setting display and source
	if ($is_plgplayer_playlist_botr_display == 'combinebotr' || $is_plgplayer_playlist_botr_display == 'combinelocal') {
		// Call api if class not set
		if (!(class_exists('BotrAPI'))) {
			if ($jversion != "1.5") {
				require_once(JPATH_BASE.DS.'plugins'.DS.'content'.DS.'plg_jwadvanced'.DS.'plg_jwadvanced'.DS.'script'.DS.'api.php');
			} else {
				require_once(JPATH_BASE.DS.'plugins'.DS.'content'.DS.'plg_jwadvanced'.DS.'script'.DS.'api.php');
			}
		}

		// Set api
		$botr_api = new BotrAPI($apikey, $secret);

		// set flashvars
		$is_plgplayer_flashvars_botr = ($botr_api->call("/players/show", array('player_key' => $playerid)));
		$is_plgplayer_flashvars_botr_status = $is_plgplayer_flashvars_botr["status"];
		if ($is_plgplayer_flashvars_botr_status == 'ok') {
			$is_plgplayer_flashvars_botr = $is_plgplayer_flashvars_botr["player"];
			unset($is_plgplayer_flashvars_botr["name"]);
			unset($is_plgplayer_flashvars_botr["views"]);
			unset($is_plgplayer_flashvars_botr["key"]);
			// if template Id  is not empty set  a new xml secret
			if (!(empty($is_plgplayer_flashvars_botr["template"]["key"]))) {
				$templateid = $is_plgplayer_flashvars_botr["template"]["key"];
				// set xml secret
				$signature = md5('jwp/'.$videoid.'-'.$templateid.'.xml:'.$expires.':'.$secret);
				$is_plgplayer_playlist_botr_xml = "http://content.bitsontherun.com/jwp/".$videoid."-".$templateid.".xml?exp=".$expires."&sig=".$signature;	
			}
			unset($is_plgplayer_flashvars_botr["template"]);

			// set custom flasvars
			if (!(empty($is_plgplayer_flashvars_botr["custom_flashvars"])))	{
				// set custom flashvars as array
				$is_plgplayer_flashvars_botr_custom_flashvars = $is_plgplayer_flashvars_botr["custom_flashvars"];
				unset($is_plgplayer_flashvars_botr["custom_flashvars"]);

				$tab = explode('&', $is_plgplayer_flashvars_botr_custom_flashvars);
				$is_plgplayer_flashvars_botr_custom_flashvars2 = array();
				foreach ($tab as $ligne) {
					$a = explode('=', $ligne);
					$is_plgplayer_flashvars_botr_custom_flashvars2[$a[0]] = $a[1];
				}
				$is_plgplayer_flashvars_botr_custom_flashvars = $is_plgplayer_flashvars_botr_custom_flashvars2;

				// add custom flashvars array player flashvars
				$is_plgplayer_flashvars_botr = $is_plgplayer_flashvars_botr + $is_plgplayer_flashvars_botr_custom_flashvars;
			}

			// set skin
			if (!(empty($is_plgplayer_flashvars_botr["skin"])))	{
				$is_plgplayer_flashvars_botr_skin = $is_plgplayer_flashvars_botr["skin"]["key"];
				unset($is_plgplayer_flashvars_botr["skin"]);
				// set format skin
				$is_plgplayer_flashvars_botr_skin_info = ($botr_api->call("/accounts/skins/show", array('skin_key' => $is_plgplayer_flashvars_botr_skin)));
				$is_plgplayer_flashvars_botr_skin_status = $is_plgplayer_flashvars_botr_skin_info["status"];
				//check status
				if ($is_plgplayer_flashvars_botr_skin_status == 'ok') {
					$is_plgplayer_flashvars_botr_skin_info_format = $is_plgplayer_flashvars_botr_skin_info["skin"]["format"];
					//load skin
					$is_plgplayer_flashvars_botr_skin = "http://content.bitsontherun.com/skins/".$is_plgplayer_flashvars_botr_skin.".".$is_plgplayer_flashvars_botr_skin_info_format;
					$is_plgplayer_flashvars_botr["skin"] = $is_plgplayer_flashvars_botr_skin;
				}
			}

			// set plugins
			if ((!(empty($is_plgplayer_flashvars_botr["ltas_channel"]))) && ($is_plgplayer_playlist_botr_display == 'combinelocal')) {
				$is_plgplayer_plugin_botr = 'ltas';
				$is_plgplayer_flashvars_botr["ltas.cc"] = $is_plgplayer_flashvars_botr["ltas_channel"];
				unset($is_plgplayer_flashvars_botr["ltas_channel"]);

				if (!(empty($is_plgplayer_flashvars_botr["plugins"]))) {
					$is_plgplayer_plugin_botr = $is_plgplayer_flashvars_botr["plugins"].",".$is_plgplayer_plugin_botr;
					unset($is_plgplayer_flashvars_botr["plugins"]);
				}
			} else if (!(empty($is_plgplayer_flashvars_botr["plugins"]))) {
				$is_plgplayer_plugin_botr = $is_plgplayer_flashvars_botr["plugins"];
				unset($is_plgplayer_flashvars_botr["plugins"]);
			}

			// unset empty flashvars
			foreach($is_plgplayer_flashvars_botr AS $indice => $valeur)	{
				if ($valeur == "") {
					unset($is_plgplayer_flashvars_botr[$indice]);
				}
			}

			//set xml file
			$is_plgplayer_playlist_botr_file = $is_plgplayer_playlist_botr_xml;

			// $check player if combinebotr is ask
			if ($is_plgplayer_playlist_botr_display == 'combinebotr') {
				// set player secret
				$signature = md5("players/".$videoid."-".$playerid.".swf:".$expires.":".$secret);
				$plgswf_player_botr = "http://content.bitsontherun.com/players/".$videoid."-".$playerid.".swf?exp=".$expires."&sig=".$signature;
				//set   for sign player
				$plgswf_signplayer = "";
				//replace player local by botr player for html5 mode
				$jw_fallback1 = str_replace( $plgswf_player, $plgswf_player_botr, $jw_fallback1 );
				$jw_fallback2 = str_replace( $plgswf_player, $plgswf_player_botr, $jw_fallback2 );
				//replace player local by botr player for embed code
				$plgswf_player = $plgswf_player_botr;
			}
		} else {
			$is_plgplayer_playlist_botr_display = 'botr';
		}
	}
	if ($is_plgplayer_playlist_botr_display == 'local')	{
		$is_plgplayer_playlist_botr_file = $is_plgplayer_playlist_botr_xml;
	}
	if ($is_plgplayer_playlist_botr_display == 'botr') {
		$is_plgplayer_playlist_botr_file = "<script type=\"text/javascript\" src=\"".$is_plgplayer_playlist_botr_file."\"></script>";
		$plgplayerswf_sfx_founded = '1';
	}
} else {
	$is_plgplayer_playlist_botr_file = 'http://www.joomlarulez.com/images/stories/playlist/big_buck_bunny/big_buck_bunny.xml';
	$is_plgplayer_playlist_botr = false;
}

if ($is_plgplayer_playlist_botr_display != 'botr') {
	// url encode
	$is_plgplayer_playlist_botr_file = urlencode($is_plgplayer_playlist_botr_file);
}

// set playlistfile
$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = $is_plgplayer_playlist_botr_file;
unset($is_plgplayer_flashvars[$index1]);

// verify is botr combine is not set
if ($is_plgplayer_playlist_botr_display == 'combinebotr') {
	if (!(empty($is_plgplayer_flashvars_botr['width']))) {
		$is_plgplayer_flashvars['width'] = $is_plgplayer_flashvars_botr['width'];
	}
	if (!(empty($is_plgplayer_flashvars_botr[$index1]))) {
		$is_plgplayer_flashvars['height'] = $is_plgplayer_flashvars_botr['height'];
	}
}