<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage flow-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );







	$is_modplayer_Flow_enabled = $params->get('FlowPluginEnabled');
	//set version of the plugin
	$is_modplayer_flow_version = $params->get('FlowPluginversion', "flow-2");

if($is_modplayer_Flow_enabled == '1' && $is_modplayer_flow_version == "flow-2") {
	$is_modplayer_plugin_array[] = $is_modplayer_flow_version;
	$count = '18';
	$index3 = 'coverheight';
	$index_defaut3 = '100';
	$index4 = 'size';
	$index_defaut4 = '100';
	$index5 = 'position';
	$index_defaut5 = '';
	$index6 = 'defaultcover';
	$index_defaut6 = '';
	$index7 = 'titleoffset';
	$index_defaut7 = '5';
	$index8 = 'descriptionoffset';
	$index_defaut8 = '25';
	$index9 = 'font';
	$index_defaut9 = 'Arial Rounded MT Bold';
	$index10 = 'fontsize';
	$index_defaut10 = '12';
	$index11 = 'color';
	$index_defaut11 = 'f1f1f1';
	$index12 = 'tweentime';
	$index_defaut12 = '0.6';
	$index13 = 'rotatedelay';
	$index_defaut13 = '2500';
	$index14 = 'backgroundcolor';
	$index_defaut14 = '000000';
	//true false flasvars
	$index15 = 'showtext';
	$index_defaut15 = '1';
	$index16 = 'autorotate';
	$index_defaut16 = '0';
	$index17 = 'controlbaricon';
	$index_defaut17 = '0';
	for ($i = 3; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["flow.".${"index".$i}])) {
			$is_modplayer_playlist_var = $params->get("FlowPlugin".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 14) {
					$is_modplayer_flashvars["flow.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["flow.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
}