<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage file.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//simple file is ask
$index1 = "author";
$index2 = "image";
$index3 = "link";
$index4 = "start";
$index5 = "streamer";
$index6 = "duration";
$index7 = "provider";
$index8 = "tags";
$count = 9;
for ($i = 1; $i < $count; $i++)	{
	if (empty($is_plgplayer_flashvars[${'index'.$i}])) {
		$is_plgplayer_playlist_var = $params->get("mod_pl".${'index'.$i}, '');
		if ($is_plgplayer_playlist_var != '')	{
			$is_plgplayer_flashvars[${'index'.$i}] = $is_plgplayer_playlist_var;
		}
	}
}

//Thanks to http://wessite.com/labs/vimeoplugin for JW 4 version
//Thanks to http://jwplayervimeo.sourceforge.net/ for JW5 version
//vimeo provider
if (!(empty($is_plgplayer_flashvars["provider"]))) {
	if ($is_plgplayer_flashvars["provider"] == "vimeo")	{
		$is_plgplayer_flashvars["provider"] = $plug_pathway."vimeo.swf";
	}
} else if ( (strpos( $is_plgplayer_flashvars["file"] , 'http://vimeo.com/' )) !== false ) {
	$is_plgplayer_flashvars["provider"] = $plug_pathway."vimeo.swf";
}