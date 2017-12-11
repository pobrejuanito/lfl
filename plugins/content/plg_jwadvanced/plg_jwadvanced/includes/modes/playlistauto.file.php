<?php
/**
*Jw Player Plugin Advanced : plg_jwadvanced
* @version plg_jwadvanced$Id$
* @package plg_jwadvanced
* @subpackage playlistauto.file.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//playlist autogenerate is ask

$is_plgplayer_playlist_auto_share = "1";
$count = 23;
$index1 = "playlistauto.file";
$index2 = "playlistauto.trackposition";
$index_defaut2 = '0';
$index3 = "playlistauto.titleposition";
$index_defaut3 = '3';
$index4 = "playlistauto.authorposition";
$index_defaut4 = '1';
$index5 = "playlistauto.descposition";
$index_defaut5 = '2';
$index6 = "playlistauto.description";
$index_defaut6 = 'description';
$index7 = "playlistauto.separator";
$index_defaut7 = '_-_';
$index8 = "playlistauto.thumb";
$index_defaut8 = '';
$index9 = "playlistauto.sort";
$index_defaut9 = 'krsort';
$index10 = "playlistauto.duration";
$index_defaut10 = '00:30';
$index11 = "playlistauto.title";
$index_defaut11 = 'simple';
$index12 = "playlistauto.playlistimage";
$index_defaut12 = '';
// true false
$index13 = "playlistauto.allowlink";
$index_defaut13 = '1';
$index14 = "playlistauto.allowjpg";
$index_defaut14 = '1';
$index15 = "playlistauto.allowpng";
$index_defaut15 = '1';
$index16 = "playlistauto.allowgif";
$index_defaut16 = '1';
$index17 = "playlistauto.allowflv";
$index_defaut17 = '1';
$index18 = "playlistauto.allowmp3";
$index_defaut18 = '1';
$index19 = "playlistauto.allowmp4";
$index_defaut19 = '1';
$index20 = "playlistauto.allowm4a";
$index_defaut20 = '1';
$index21 = "playlistauto.allowmov";
$index_defaut21 = '1';
$index22 = "playlistauto.allowm4v";
$index_defaut22 = '1';
for ($i = 1; $i < $count; $i++) {
	if (!(empty($is_plgplayer_flashvars[${'index'.$i}]))) {
		if (!(empty($is_plgplayer_flashvars[$index1]))) {
			// set slash Playlist auto
			$is_plgplayer_playlist_auto_first_slash = strpos ( $is_plgplayer_flashvars[$index1] , "/");
			if ($is_plgplayer_playlist_auto_first_slash == '0')	{
				$is_plgplayer_flashvars[$index1] = "first".$is_plgplayer_flashvars[$index1];
				$is_plgplayer_flashvars[$index1] = preg_replace('#first/#', '', $is_plgplayer_flashvars[$index1]);
			}
			$is_plgplayer_playlist_auto_last_slash = strrpos ( $is_plgplayer_flashvars[$index1] , "/");
			$length_is_plgplayer_playlist_auto = strlen($is_plgplayer_flashvars[$index1]);
			if ($is_plgplayer_playlist_auto_last_slash != ($length_is_plgplayer_playlist_auto - 1))	{
				$is_plgplayer_flashvars[$index1] = $is_plgplayer_flashvars[$index1]."/";
			}
		}
		${"is_plgplayer_playlist_auto".(str_replace( "playlistauto.", '', ${'index'.$i}))} = $is_plgplayer_flashvars[${'index'.$i}];
		unset($is_plgplayer_flashvars[${'index'.$i}]);
	} else if ((empty($is_plgplayer_flashvars[${'index'.$i}])) && ($i > 1))	{
		$is_plgplayer_playlist_var = ${'index'.$i};
		$is_plgplayer_playlist_var2 = str_replace( "playlistauto.", '', $is_plgplayer_playlist_var);
		$is_plgplayer_playlist_var = str_replace( "playlistauto.", 'mod_plauto', $is_plgplayer_playlist_var);
		$is_plgplayer_playlist_defaut = ${'index_defaut'.$i};
		if ($i > 12) {
			${"is_plgplayer_playlist_auto".$is_plgplayer_playlist_var2} = ($params->get($is_plgplayer_playlist_var, $is_plgplayer_playlist_defaut)) ? 'true' : 'false';
		} else {
			${"is_plgplayer_playlist_auto".$is_plgplayer_playlist_var2} = $params->get($is_plgplayer_playlist_var, $is_plgplayer_playlist_defaut);
		}
	} else {
		${"is_plgplayer_playlist_auto".(str_replace( "playlistauto.", '', ${'index'.$i}))} = "";
	}
}
if ($jwversion == '5') {
	$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = urlencode($plug_pathway."autogenerate_playlist".$jwversion.".php?dir=".$is_plgplayer_playlist_autofile."&url=".JURI::base()."&sor=".base64_encode($is_plgplayer_playlist_autosort)."&tyt=".$is_plgplayer_playlist_autotitle."&tdes=".$is_plgplayer_playlist_autodescription."&sep=".$is_plgplayer_playlist_autoseparator."&tp=".$is_plgplayer_playlist_autotitleposition."&ap=".$is_plgplayer_playlist_autoauthorposition."&thu=".$is_plgplayer_playlist_autothumb."&img=".$is_plgplayer_playlist_autoplaylistimage."&dur=".$is_plgplayer_playlist_autoduration."&trp=".$is_plgplayer_playlist_autotrackposition."&li=".$is_plgplayer_playlist_autoallowlink."&jpg=".$is_plgplayer_playlist_autoallowjpg."&png=".$is_plgplayer_playlist_autoallowpng."&gif=".$is_plgplayer_playlist_autoallowgif."&flv=".$is_plgplayer_playlist_autoallowflv."&mp3=".$is_plgplayer_playlist_autoallowmp3."&mp4=".$is_plgplayer_playlist_autoallowmp4."&m4a=".$is_plgplayer_playlist_autoallowm4a."&m4v=".$is_plgplayer_playlist_autoallowm4v."&mov=".$is_plgplayer_playlist_autoallowmov."&dp=".$is_plgplayer_playlist_autodescposition."&jv=".$jversion);
} else if ($jwversion == '') {
	$is_plgplayer_flashvars[$is_plgplayer_playlisttype] = urlencode($plug_pathway."autogenerate_playlist".$jwversion.".php?dir=".$is_plgplayer_playlist_autofile."&url=".JURI::base()."&sor=".base64_encode($is_plgplayer_playlist_autosort)."&tyt=".$is_plgplayer_playlist_autotitle."&tdes=".$is_plgplayer_playlist_autodescription."&sep=".$is_plgplayer_playlist_autoseparator."&tp=".$is_plgplayer_playlist_autotitleposition."&ap=".$is_plgplayer_playlist_autoauthorposition."&thu=".$is_plgplayer_playlist_autothumb."&dur=".$is_plgplayer_playlist_autoduration."&trp=".$is_plgplayer_playlist_autotrackposition."&li=".$is_plgplayer_playlist_autoallowlink."&jpg=".$is_plgplayer_playlist_autoallowjpg."&png=".$is_plgplayer_playlist_autoallowpng."&gif=".$is_plgplayer_playlist_autoallowgif."&flv=".$is_plgplayer_playlist_autoallowflv."&mp3=".$is_plgplayer_playlist_autoallowmp3."&mp4=".$is_plgplayer_playlist_autoallowmp4."&m4a=".$is_plgplayer_playlist_autoallowm4a."&m4v=".$is_plgplayer_playlist_autoallowm4v."&mov=".$is_plgplayer_playlist_autoallowmov."&dp=".$is_plgplayer_playlist_autodescposition."&jv=".$jversion);
}