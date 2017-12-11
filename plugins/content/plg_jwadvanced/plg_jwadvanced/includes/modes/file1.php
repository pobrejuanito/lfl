<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage file1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//playlisteditor is ask

$is_plgplayer_playlist_auto_share = "1";
$count2 = 51;
$i2 = 1;
$count = 15;
$index1 = 'file1';
while ((!(empty($is_plgplayer_flashvars[$index1]))) && ($i2 < $count2))	{
	$index2 = "captions.file".$i2;
	$index3 = "title".$i2;
	$index4 = "description".$i2;
	$index5 = "author".$i2;
	$index6 = "image".$i2;
	$index7 = "link".$i2;
	$index8 = "start".$i2;
	$index9 = "streamer".$i2;
	$index10 = "duration".$i2;
	$index11 = "provider".$i2;
	$index12 = "tags".$i2;
	$index13 = "hd.file".$i2;
	$index14 = "sharing.link".$i2;

	//vimeo provider
	if (!(empty($is_plgplayer_flashvars[$index11]))) {
		if ($is_plgplayer_flashvars[$index11] == "vimeo") {
			$is_plgplayer_flashvars[$index11] = $plug_pathway."vimeo.swf";
		}
	} else if ( (strpos( $is_plgplayer_flashvars[$index1] , 'http://vimeo.com/' )) !== false ) {
		$is_plgplayer_flashvars[$index11] = $plug_pathway."vimeo.swf";
	}

	for ($i = 1; $i < $count; $i++)	{
		// build variable playlist
		if (!(empty($is_plgplayer_flashvars[${'index'.$i}]))) {
			${'is_plgplayer_playlist_'.${'index'.$i}} = $is_plgplayer_flashvars[${'index'.$i}];
			unset($is_plgplayer_flashvars[${'index'.$i}]);
		} else if ((empty($is_plgplayer_flashvars[${'index'.$i}])) && $i > 4) {
			$is_plgplayer_playlist_var = str_replace( $i2, "", ${'index'.$i});
			${'is_plgplayer_playlist_'.${'index'.$i}} = $params->get("mod_pl".$is_plgplayer_playlist_var, '');
		} else {
			${'is_plgplayer_playlist_'.${'index'.$i}} = "";
		}
	}

	$i2++;
	$index1 = "file".$i2;
}
//build playlist
$i3 = 1;
$is_plgplayer_playlist_auto = $plug_pathway."playlist5.php?";
while ($i3 < $i2) {
	$is_plgplayer_playlist_auto = $is_plgplayer_playlist_auto."&pf".$i3."=".base64_encode(${'is_plgplayer_playlist_file'.$i3})."&pd".$i3."=".base64_encode(${'is_plgplayer_playlist_description'.$i3})."&pc".$i3."=".base64_encode(${'is_plgplayer_playlist_author'.$i3})."&pth".$i3."=".base64_encode(${'is_plgplayer_playlist_image'.$i3})."&tg".$i3."=".base64_encode(${'is_plgplayer_playlist_tags'.$i3})."&pt".$i3."=".base64_encode(${'is_plgplayer_playlist_title'.$i3})."&pl".$i3."=".base64_encode(${'is_plgplayer_playlist_link'.$i3})."&st".$i3."=".${'is_plgplayer_playlist_start'.$i3}."&str".$i3."=".base64_encode(${'is_plgplayer_playlist_streamer'.$i3})."&cap".$i3."=".base64_encode(${'is_plgplayer_playlist_captions.file'.$i3})."&dur".$i3."=".${'is_plgplayer_playlist_duration'.$i3}."&pfo".$i3."=".${'is_plgplayer_playlist_provider'.$i3}."&hd".$i3."=".base64_encode(${'is_plgplayer_playlist_hd.file'.$i3})."&sh".$i3."=".base64_encode(${'is_plgplayer_playlist_sharing.link'.$i3});
	$i3++;
}
$is_plgplayer_playlist_auto = urlencode($is_plgplayer_playlist_auto);
$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = $is_plgplayer_playlist_auto;