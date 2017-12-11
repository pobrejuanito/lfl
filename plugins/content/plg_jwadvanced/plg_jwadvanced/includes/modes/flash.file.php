<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage flash.file.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//fallback file is ask

// set JSON playlist for flash
$is_plgplayer_playlist_json_flash_1 = array();
$index_flash1 = 'flash.file';
$index1 = 'file';
$index_flash2 = "flash.author";
$index2 = "author";
$index_flash3 = "flash.image";
$index3 = "image";
$index_flash4 = "flash.link";
$index4 = "link";
$index_flash5 = "flash.start";
$index5 = "start";
$index_flash6 = "flash.streamer";
$index6 = "streamer";
$index_flash7 = "flash.duration";
$index7 = "duration";
$index_flash8 = "flash.provider";
$index8 = "provider";
$index_flash9 = "flash.tags";
$index9 = "tags";
$count = 10;
for ($i = 1; $i < $count; $i++)	{
	if (empty($is_plgplayer_flashvars[${'index_flash'.$i}])) {
		$is_plgplayer_playlist_var = $params->get("mod_pl".${'index'.$i}, '');
		if ($is_plgplayer_playlist_var != '') {
			$is_plgplayer_playlist_json_flash_1[${'index'.$i}] = $is_plgplayer_playlist_var;
			// set flashvars for embed code
			$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_json_flash_1[${'index'.$i}];
		}
	} else {
		$is_plgplayer_playlist_json_flash_1[${'index'.$i}] = $is_plgplayer_flashvars[${'index_flash'.$i}];
		// set flashvars for embed code
		$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_flashvars[${'index_flash'.$i}];
		unset($is_plgplayer_flashvars[${'index_flash'.$i}]);
	}
}

//Thanks to http://wessite.com/labs/vimeoplugin for JW 4 version
//Thanls to http://jwplayervimeo.sourceforge.net/ for JW5 version
//vimeo provider
if (!(empty($is_plgplayer_playlist_json_flash_1["provider"]))) {
	if ($is_plgplayer_playlist_json_flash_1["provider"] == "vimeo")	{
		$is_plgplayer_playlist_json_flash_1["provider"] = $plug_pathway."vimeo.swf";
		// set flashvars for embed code
		$is_plgplayer_flashvars["provider"] = $is_plgplayer_playlist_json_flash_1["provider"];
	}
} else if ( (strpos( $is_plgplayer_playlist_json_flash_1["file"] , 'http://vimeo.com/' )) !== false ) {
	$is_plgplayer_playlist_json_flash_1["provider"] = $plug_pathway."vimeo.swf";
	// set flashvars for embed code
	$is_plgplayer_flashvars["provider"] = $is_plgplayer_playlist_json_flash_1["provider"];
}

$index_html1 = 'html5.file';
$index1 = 'file';
if (!(empty($is_plgplayer_flashvars[$index_html1]))) {
	// set JSON playlist for HTML5
	$is_plgplayer_playlist_json_html_1 = array();
	$index_html2 = "html5.image";
	$index2 = "image";
	$index_html3 = "html5.duration";
	$index3 = "duration";
	$index_html4 = "html5.provider";
	$index4 = "provider";
	$count = 5;
	for ($i = 1; $i < $count; $i++)	{
		if (!(empty($is_plgplayer_flashvars[${'index_html'.$i}]))) {
			$is_plgplayer_playlist_json_html_1[${'index'.$i}] = $is_plgplayer_flashvars[${'index_html'.$i}];
			unset($is_plgplayer_flashvars[${'index_html'.$i}]);
		}
	}
} else {
	$is_plgplayer_playlist_json_html_1 = $is_plgplayer_playlist_json_flash_1;
}

$index_download1 = 'download.file';
$index1 = 'file';
if (!(empty($is_plgplayer_flashvars[$index_download1]))) {
	// set JSON playlist for Download
	$is_plgplayer_playlist_json_download_1 = array();
	$index_download2 = "download.image";
	$index2 = "image";
	$index_download3 = "download.provider";
	$index3 = "provider";
	$count = 4;
	for ($i = 1; $i < $count; $i++)	{
		if (!(empty($is_plgplayer_flashvars[${'index_download'.$i}]))) {
			$is_plgplayer_playlist_json_download_1[${'index'.$i}] = $is_plgplayer_flashvars[${'index_download'.$i}];
			unset($is_plgplayer_flashvars[${'index_download'.$i}]);
		}
	}
} else {
	$is_plgplayer_playlist_json_download_1 = $is_plgplayer_playlist_json_flash_1;
}