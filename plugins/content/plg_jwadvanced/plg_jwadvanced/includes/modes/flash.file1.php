<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage flash.file1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//fallback playlist editor file ask

$is_plgplayer_playlist_auto_share = "1";
$count2 = 51;
$i2 = 1;
$count = 15;
$index_flash1 = 'flash.file1';
$index_html1 = 'html5.file1';
$index_download1 = 'download.file1';
while ((!(empty($is_plgplayer_flashvars[$index_flash1]))) && ($i2 < $count2)) {
	// set JSON playlist for flash
	${'is_plgplayer_playlist_json_flash_'.$i2} = array();
	$index1 = "file".$i2;
	$index_flash2 = "flash.title".$i2;
	$index2 = "title".$i2;
	$index_flash3 = "flash.description".$i2;
	$index3 = "description".$i2;
	$index_flash4 = "flash.author".$i2;
	$index4 = "author".$i2;
	$index_flash5 = "flash.image".$i2;
	$index5 = "image".$i2;
	$index_flash6 = "flash.link".$i2;
	$index6 = "link".$i2;
	$index_flash7 = "flash.start".$i2;
	$index7 = "start".$i2;
	$index_flash8 = "flash.streamer".$i2;
	$index8 = "streamer".$i2;
	$index_flash9 = "flash.duration".$i2;
	$index9 = "duration".$i2;
	$index_flash10 = "flash.provider".$i2;
	$index10 = "provider".$i2;
	$index_flash11 = "flash.tags".$i2;
	$index11 = "tags".$i2;
	$index_flash12 = "flash.hd.file".$i2;
	$index12 = "hd.file".$i2;
	$index_flash13 = "flash.sharing.link".$i2;
	$index13 = "sharing.link".$i2;
	$index_flash14 = "flash.captions.file".$i2;
	$index14 = "captions.file".$i2;
	
	$count = 15;
	for ($i = 1; $i < $count; $i++)	{
		$is_plgplayer_playlist_var_index = str_replace( $i2, "", ${'index'.$i});
		if ((empty($is_plgplayer_flashvars[${'index_flash'.$i}])) && ($i < 12)) {
			$is_plgplayer_playlist_var = $params->get("mod_pl".$is_plgplayer_playlist_var_index, '');
			if ($is_plgplayer_playlist_var != '') {
				${'is_plgplayer_playlist_json_flash_'.$i2}[$is_plgplayer_playlist_var_index] = ${'is_plgplayer_playlist_'.${'index'.$i}} = $is_plgplayer_playlist_var;
			} else {
				${'is_plgplayer_playlist_'.${'index'.$i}} = "";
			}
		} else if (!(empty($is_plgplayer_flashvars[${'index_flash'.$i}]))) {
			${'is_plgplayer_playlist_json_flash_'.$i2}[$is_plgplayer_playlist_var_index] = ${'is_plgplayer_playlist_'.${'index'.$i}} = $is_plgplayer_flashvars[${'index_flash'.$i}];
			unset($is_plgplayer_flashvars[${'index_flash'.$i}]);
		} else {
			${'is_plgplayer_playlist_'.${'index'.$i}} = "";
		}
	}

	//Thanks to http://wessite.com/labs/vimeoplugin for JW 4 version
	//Thanls to http://jwplayervimeo.sourceforge.net/ for JW5 version
	//vimeo provider
	if (!(empty(${'is_plgplayer_playlist_json_flash_'.$i2}["provider"]))) {
		if (${'is_plgplayer_playlist_json_flash_'.$i2}["provider"] == "vimeo")	{
			${'is_plgplayer_playlist_json_flash_'.$i2}["provider"] = $plug_pathway."vimeo.swf";
		}
	} else if ( (strpos( ${'is_plgplayer_playlist_json_flash_'.$i2}["file"] , 'http://vimeo.com/' )) !== false ) {
		${'is_plgplayer_playlist_json_flash_'.$i2}["provider"] = $plug_pathway."vimeo.swf";
	}
	
	// set JSON playlist for HTML5
	if (!(empty($is_plgplayer_flashvars[$index_html1]))) {
		${'is_plgplayer_playlist_json_html_'.$i2} = array();
		$index_html2 = "html5.image".$i2;
		$index2 = "image".$i2;
		$index_html3 = "html5.duration".$i2;
		$index3 = "duration".$i2;
		$index_html4 = "html5.provider".$i2;
		$index4 = "provider".$i2;
		$count = 5;
		for ($i = 1; $i < $count; $i++)	{
			$is_plgplayer_playlist_var_index = str_replace( $i2, "", ${'index'.$i});
			if (!(empty($is_plgplayer_flashvars[${'index_html'.$i}]))) {
				${'is_plgplayer_playlist_json_html_'.$i2}[$is_plgplayer_playlist_var_index] = $is_plgplayer_flashvars[${'index_html'.$i}];
				unset($is_plgplayer_flashvars[${'index_html'.$i}]);
			}
		}
	} else {
		${'is_plgplayer_playlist_json_html_'.$i2} = ${'is_plgplayer_playlist_json_flash_'.$i2};
	}
	
	// set JSON playlist for download
	if (!(empty($is_plgplayer_flashvars[$index_download1]))) {
		${'is_plgplayer_playlist_json_download_'.$i2} = array();
		$index_download2 = "download.image".$i2;
		$index2 = "image".$i2;
		$index_download3 = "download.provider".$i2;
		$index3 = "provider".$i2;
		$count = 4;
		for ($i = 1; $i < $count; $i++)	{
			if (!(empty($is_plgplayer_flashvars[${'index_download'.$i}]))) {
				$is_plgplayer_playlist_var_index = str_replace( $i2, "", ${'index'.$i});
				${'is_plgplayer_playlist_json_download_'.$i2}[$is_plgplayer_playlist_var_index] = $is_plgplayer_flashvars[${'index_download'.$i}];
				unset($is_plgplayer_flashvars[${'index_download'.$i}]);
			}
		}
	} else {
		${'is_plgplayer_playlist_json_download_'.$i2} = ${'is_plgplayer_playlist_json_flash_'.$i2};
	}
	
	$i2++;
	$index_flash1 = "flash.file".$i2;
	$index_html1 = "html5.file".$i2;
	$index_download1 = "download.file".$i2;
}
//build playlist for embed code
$i3 = 1;
$is_plgplayer_playlist_auto = $plug_pathway."playlist5.php?";
while ($i3 < $i2) {
	$is_plgplayer_playlist_auto = $is_plgplayer_playlist_auto."&pf".$i3."=".base64_encode(${'is_plgplayer_playlist_file'.$i3})."&pd".$i3."=".base64_encode(${'is_plgplayer_playlist_description'.$i3})."&pc".$i3."=".base64_encode(${'is_plgplayer_playlist_author'.$i3})."&pth".$i3."=".base64_encode(${'is_plgplayer_playlist_image'.$i3})."&tg".$i3."=".base64_encode(${'is_plgplayer_playlist_tags'.$i3})."&pt".$i3."=".base64_encode(${'is_plgplayer_playlist_title'.$i3})."&pl".$i3."=".base64_encode(${'is_plgplayer_playlist_link'.$i3})."&st".$i3."=".${'is_plgplayer_playlist_start'.$i3}."&str".$i3."=".base64_encode(${'is_plgplayer_playlist_streamer'.$i3})."&cap".$i3."=".base64_encode(${'is_plgplayer_playlist_captions.file'.$i3})."&dur".$i3."=".${'is_plgplayer_playlist_duration'.$i3}."&pfo".$i3."=".${'is_plgplayer_playlist_provider'.$i3}."&hd".$i3."=".base64_encode(${'is_plgplayer_playlist_hd.file'.$i3})."&sh".$i3."=".base64_encode(${'is_plgplayer_playlist_sharing.link'.$i3});
	$i3++;
}
$is_plgplayer_playlist_auto = urlencode($is_plgplayer_playlist_auto);
$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = $is_plgplayer_playlist_auto;