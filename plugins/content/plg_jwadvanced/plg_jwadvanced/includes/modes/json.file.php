<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage json.file.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//json file is ask
if (!(empty($is_plgplayer_flashvars["json.file"]))) {
	$is_plgplayer_playlist_json_file = $is_plgplayer_flashvars["json.file"];
	// set slash file
	$is_plgplayer_playlist_json_file_first_slash = strpos($is_plgplayer_playlist_json_file , "/");
	if ($is_plgplayer_playlist_json_file_first_slash == '0') {
		$is_plgplayer_playlist_json_file = "first".$is_plgplayer_playlist_json_file;
		$is_plgplayer_playlist_json_file = preg_replace('#first/#', '', $is_plgplayer_playlist_json_file);
	}
	if (file_exists($is_plgplayer_playlist_json_file) && is_readable($is_plgplayer_playlist_json_file) && (strpos($is_plgplayer_playlist_json_file , ".json") || strpos($is_plgplayer_playlist_json_file , ".txt"))) {
		$is_plgplayer_playlist_json_field = file_get_contents(JURI::base().$is_plgplayer_playlist_json_file);
	}
	//check if modes or level or playlist is set
	if ((strpos($is_plgplayer_playlist_json_field , "'modes':")) !== false) {
		$is_plgplayer_playlist_json_field = preg_replace("#'modes':#", "", $is_plgplayer_playlist_json_field);
		$is_plgplayer_flashvars["modes"] = $is_plgplayer_playlist_json_field;
	} else if ((strpos($is_plgplayer_playlist_json_field , "'levels':")) !== false) {
		$is_plgplayer_playlist_json_field = preg_replace("#'levels':#", "", $is_plgplayer_playlist_json_field);
		$is_plgplayer_flashvars["levels"] = $is_plgplayer_playlist_json_field;
	} else if ((strpos($is_plgplayer_playlist_json_field , "'playlist':")) !== false) {
		$is_plgplayer_playlist_json_field = preg_replace("#'playlist':#", "", $is_plgplayer_playlist_json_field);
		$is_plgplayer_flashvars["playlist.json"] = $is_plgplayer_playlist_json_field;
	}
	unset($is_plgplayer_flashvars["json.file"]);
}