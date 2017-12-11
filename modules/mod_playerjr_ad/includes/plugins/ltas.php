<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage ltas.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_playlist_adsenabled = $params->get('AdsolutionPluginEnabled');
	
	
	
		
	
	$is_modplayer_playlist_adschannelcode = $params->get('AdsolutionChannelcode');
	
	
	
	
	
	
	
	
	
	
	$is_modplayer_playlist_adspremsenabled = $params->get('AdsolutionPremiumEnabled', "0");
	
if($is_modplayer_playlist_adsenabled == '1' && $is_modplayer_playlist_adschannelcode != '') {
	$is_modplayer_playlist_adsenabled = true;
	$is_modplayer_plugin_array[] = 'ltas';
	$is_modplayer_flashvars["ltas.cc"] = $is_modplayer_playlist_adschannelcode;
	if ($is_modplayer_playlist_adspremsenabled == '1') {
		$is_modplayer_flashvars["ltas.mediaid"] = $moduleclasspl_sfx.".flv";
	}
	if($is_modplayer_playlist_adspremsenabled =='1' && $is_modplayer_playlist_select =='1')	{
		$is_modplayer_flashvars['title'] = ${"is_modplayer_playlist_title".($is_modplayer_playlist_item + 1 )};
		$is_modplayer_flashvars['description'] = ${"is_modplayer_playlist_description".($is_modplayer_playlist_item + 1 )};
		$is_modplayer_flashvars['title']= preg_replace('#\'#', '&#39;', $is_modplayer_flashvars['title']);
		$is_modplayer_flashvars['description'] = preg_replace('#\'#', '&#39;', $is_modplayer_flashvars['description']);
	}
} else {
	$is_modplayer_playlist_adsenabled = false;
}