<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version mod_playerjr_ad$Id$
* @package mod_playerjr_ad
* @subpackage gapro-2.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );







	$is_modplayer_gapro_enabled = $params->get('GaProPluginEnabled', "0");
	//set version of the plugin
	$is_modplayer_gapro_version = $params->get('GaProPluginversion', "gapro-2");

if($is_modplayer_gapro_enabled == '1' && $is_modplayer_gapro_version == "gapro-2") {
	$is_modplayer_plugin_array[] = $is_modplayer_gapro_version;
	$count = '7';
	$index2 = 'accountid';
	$index_defaut2 = '';
	$index3 = 'idstring';
	$index_defaut3 = '||streamer||/||file||';
	$index4 = 'trackstarts';
	$index_defaut4 = '1';
	$index5 = 'trackpercentage';
	$index_defaut5 = '1';
	$index6 = 'tracktime';
	$index_defaut6 = '1';
	for ($i = 2; $i < $count; $i++)	{
		if (empty($is_modplayer_flashvars["gapro.".${"index".$i}]))	{
			$is_modplayer_playlist_var = $params->get("GaPro".${"index".$i}, ${"index_defaut".$i});
			if($is_modplayer_playlist_var != ${"index_defaut".$i}) {
				if ($i > 3) {
					$is_modplayer_flashvars["gapro.".${"index".$i}] = $is_modplayer_playlist_var ? 'true' : 'false';
				} else {
					$is_modplayer_flashvars["gapro.".${"index".$i}] = $is_modplayer_playlist_var;
				}
			}
		}
	}
	if (!(empty($is_modplayer_flashvars["gapro.accountid"]))) {
		$modulefieldAsynchronous_Tracking_sfx =
			"
			<script type=\"text/javascript\">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '".$is_modplayer_flashvars["gapro.accountid"]."']);
				_gaq.push(['_trackPageview']);
				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>
			";
		$is_modplayer_gapro_accountid = $is_modplayer_flashvars["gapro.accountid"];
		unset ($is_modplayer_flashvars["gapro.accountid"]);
	}
}