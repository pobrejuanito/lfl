<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage ltas.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

if(in_array('ltas', $is_plgplayer_plugin_array)) {
	$is_plgplayer_playlist_adsenabled = '1';
	$key = array_search( 'ltas' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_playlist_adsenabled = $params->get('AdsolutionPluginEnabled', "0");
}
if (!(empty($is_plgplayer_flashvars['ltas.cc'])))	{
	$is_plgplayer_playlist_adschannelcode = $is_plgplayer_flashvars['ltas.cc'];
	unset($is_plgplayer_flashvars['ltas.cc']);
} else {
	$is_plgplayer_playlist_adschannelcode = $params->get('AdsolutionChannelcode', "");
}
if (in_array('ltaspremium_off', $is_plgplayer_plugin_array)) {
	$is_plgplayer_playlist_adspremsenabled = '0';
	$key = array_search( 'ltaspremium_off' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else if (in_array('ltaspremium_on', $is_plgplayer_plugin_array)) {
	$is_plgplayer_playlist_adspremsenabled = '1';
	$key = array_search( 'ltaspremium_on' , $is_plgplayer_plugin_array);
	unset($is_plgplayer_plugin_array[$key]);
} else {
	$is_plgplayer_playlist_adspremsenabled = $params->get('AdsolutionPremiumEnabled', "0");
}
if($is_plgplayer_playlist_adsenabled == '1' && $is_plgplayer_playlist_adschannelcode != '')	{
	$is_plgplayer_playlist_adsenabled = true;
	$is_plgplayer_plugin_array[] = 'ltas';
	$is_plgplayer_flashvars["ltas.cc"] = $is_plgplayer_playlist_adschannelcode;
	if ($is_plgplayer_playlist_adspremsenabled == '1') {
		$is_plgplayer_flashvars["ltas.mediaid"] = $pluginclasspl_sfx.".flv";
	}
} else {
	$is_plgplayer_playlist_adsenabled = false;
}