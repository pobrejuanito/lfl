<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage playlistfile1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//multiple playlist is ask
$index = 'playlistfile1';
$i = 1;
$count = 20;
$multiple_playlist = array();
while ((!(empty($is_plgplayer_flashvars[$index]))) && ($i < $count)) {
	$multiple_playlist[$i-1] = $is_plgplayer_flashvars[$index];
	unset($is_plgplayer_flashvars[$index]);
	$i++;
	$index = "playlistfile".$i;
}
$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = $multiple_playlist[0];
$is_plgplayer_playlist_auto_share = $is_plgplayer_playlist_multiple_dropdown = "1";
$multiple_playlist_title = $multiple_playlist;

//check if specfic conf for the dropdown is ask
$index1 = 'dropdowntitle';
$index2 = 'dropdowntitlelength';
$index3 = 'dropdownstyle';
$index4 = 'dropdownclass';
for($i = 1; $i < 5; ++$i) {
	if (empty($is_plgplayer_flashvars[${'index'.$i}])) {
		${'is_plgplayer_playlist_multiple_'.${'index'.$i}} = $params->get('mod_plmulti'.${'index'.$i});
	} else {
		${'is_plgplayer_playlist_multiple_'.${'index'.$i}} = $is_plgplayer_flashvars[${'index'.$i}];
		unset($is_plgplayer_flashvars[${'index'.$i}]);
	}
}

//Assign title for playlist
if ($is_plgplayer_playlist_multiple_dropdowntitle == '2' || $is_plgplayer_playlist_multiple_dropdowntitle == 'curl') {
	$is_player_curlinstall = function_exists('curl_version') ? 'Enabled' : 'Disabled';
	// Check if title is available
	if ($is_player_curlinstall == 'Enabled') {
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
				if ((strlen($checktitle)) > $is_plgplayer_playlist_multiple_dropdowntitlelength) {
					$checktitle = substr($checktitle, 0 , $is_plgplayer_playlist_multiple_dropdowntitlelength - 3);
					$checktitle = $checktitle."...";
				}
				$multiple_playlist_title[$i] = $checktitle;
			} else if ( $checktitlebalisestart_youtube != false) {
				$checktitlebalisestop = stripos($checktitle, '</title>');
				$checktitle = substr($checktitle, $checktitlebalisestart_youtube , $checktitlebalisestop - $checktitlebalisestart_youtube);
				$checktitle = str_replace("<title type='text'>","",$checktitle);
				if ((strlen($checktitle)) > $is_plgplayer_playlist_multiple_dropdowntitlelength) {
					$checktitle = substr($checktitle, 0 , $is_plgplayer_playlist_multiple_dropdowntitlelength - 3);
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
				if ((strlen($multiple_playlist_title[$i])) > $is_plgplayer_playlist_multiple_dropdowntitlelength) {
					$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_plgplayer_playlist_multiple_dropdowntitlelength - 3);
					$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
				}
			}
		}
		// close curl resource to free up system resources
		curl_close($ch);
	}
} else if ($is_plgplayer_playlist_multiple_dropdowntitle == '1' || $is_plgplayer_playlist_multiple_dropdowntitle == 'on') {
	for($i = 0; $i < sizeof($multiple_playlist_title); ++$i) {
		$multiple_playlist_title[$i] = strrchr( $multiple_playlist_title[$i] , '/');
		$multiple_playlist_title[$i] = preg_replace('#/#', '', $multiple_playlist_title[$i]);
		$pos = strripos ( $multiple_playlist_title[$i]  , '.');
		if ($pos != false) {
			$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0, $pos);
		}
		$multiple_playlist_title[$i] = preg_replace('#_#', ' ', $multiple_playlist_title[$i]);
		$multiple_playlist_title[$i] = preg_replace('#%20#', ' ', $multiple_playlist_title[$i]);
		$multiple_playlist_title[$i] = preg_replace('#%3F#', '?', $multiple_playlist_title[$i]);
		$multiple_playlist_title[$i] = preg_replace('#%3D#', '=', $multiple_playlist_title[$i]);
		$multiple_playlist_title[$i] = preg_replace('#%26#', '&', $multiple_playlist_title[$i]);
		$multiple_playlist_title[$i] = ucfirst($multiple_playlist_title[$i]);
		if ((strlen($multiple_playlist_title[$i])) > $is_plgplayer_playlist_multiple_dropdowntitlelength) {
			$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_plgplayer_playlist_multiple_dropdowntitlelength - 3);
			$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
		}
	}
} else if ($is_plgplayer_playlist_multiple_dropdowntitle == '0' || $is_plgplayer_playlist_multiple_dropdowntitle == 'off') {
	for($i = 0; $i < sizeof($multiple_playlist_title); ++$i) {
		if ((strlen($multiple_playlist_title[$i])) > $is_plgplayer_playlist_multiple_dropdowntitlelength) {
			$multiple_playlist_title[$i] = substr($multiple_playlist_title[$i], 0 , $is_plgplayer_playlist_multiple_dropdowntitlelength - 3);
			$multiple_playlist_title[$i] = $multiple_playlist_title[$i]."...";
		}
	}
}

//Assign class for the dropdown list
if ($is_plgplayer_playlist_multiple_dropdownstyle == '0' || $is_plgplayer_playlist_multiple_dropdownstyle == 'default') {
	$is_plgplayer_playlist_multiple_dropdownclass = "style=\"width:".$is_plgplayer_flashvars["width"]."px\"";
	if ($is_plgplayer_playlist_popup != 'none' && $is_plgplayer_playlist_popup != 'off') {
		if($is_plgplayer_popup_sizechoice == 'adjust') {
			$is_plgplayer_playlist_multiple_dropdownclass_popup = "style=\"width:".$is_plgplayer_playlist_popupwidth."px\"";
		} else {
			$is_plgplayer_playlist_multiple_dropdownclass_popup = $is_plgplayer_playlist_multiple_dropdownclass;
		}
	}
} else if ($is_plgplayer_playlist_multiple_dropdownstyle == '1' || $is_plgplayer_playlist_multiple_dropdownstyle == 'classfield')	{
	$is_plgplayer_playlist_multiple_dropdownclass_popup = "class=\"pop".$is_plgplayer_playlist_multiple_dropdownclass."\"";
	$is_plgplayer_playlist_multiple_dropdownclass = "class=\"".$is_plgplayer_playlist_multiple_dropdownclass."\"";
} else {
	$is_plgplayer_playlist_multiple_dropdownclass = $is_plgplayer_playlist_multiple_dropdownclass_popup = "";
}