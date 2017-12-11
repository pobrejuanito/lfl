<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage tweetit-1.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );






	$is_modplayer_Tweeter_enabled = $params->get('TweetPluginEnabled');

if($is_modplayer_Tweeter_enabled == '1') {
	$is_modplayer_plugin_array[] = 'tweetit-1';
	$is_modplayer_flashvars["dock"] = "true";
	$is_modplayer_Tweeter_altlink = $params->get('TweetPlugintweetitlink');
	if($is_modplayer_Tweeter_altlink != '')	{
		$is_modplayer_flashvars['tweetit.link'] = $is_modplayer_Tweeter_altlink;
	}
}