<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version $Id$
* @package mod_playerjr_ad
* @subpackage helper.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class modplayerjr_adHelper
{
  /**
     *
     * @param array $params An object containing the module parameters
     * @access public
     */    
    function getParams(&$params)
    {
		//Joomla version
		$jversion = new JVersion;
		$jversion = $jversion->RELEASE;
		
		// JW Version
		$params->def('PlaylistJWVersion', 'JW5_HTML5');
		
		// Module Parameters
		$params->def('cache', '0');
		$params->def('PlaylistSwfobject', '1');
		$params->def('Playlistmetaload', '2');
		$params->def('PlaylistjqueryLoad', '2');
		$params->def('PlaylistjqueryjwboxLoad', '2');
		$params->def('PlaylistjwplayerLoad', '2');
		$params->def('Playlistfallbackdownload', '1');
		$params->def('PlaylistiscrollLoad', '2');
		$params->def('Playlistjquerymootoolsconflict', '1');
		$params->def('Playlistjwboxcontainer', 'span');
		$params->def('PlaylistcssLoad', '1');
		$params->def('mod_css', '');
		$params->def('Playlistdebug', 'none');
		$params->def('PlaylistFlashinstall', '1');
		$params->def('Playlistconfig', '');
		$params->def('Playlistplaylist', 'bottom');
		$params->def('PlaylistControlbar', 'bottom');
		$params->def('Playlistcontrolbaridlehide', '0');
		$params->def('Playlistcontrolbarforcenextprev', '0');
		$params->def('Playlistdisplayshowmute', '0');
		$params->def('Playlistdock', '0');
		$params->def('PlaylistSize', '180');
		$params->def('PlaylistHeight', '400');
		$params->def('PlaylistWidth', '280');
		$params->def('PlaylistBackcolor', '');
		$params->def('PlaylistFrontcolor', '');
		$params->def('PlaylistLightcolor', '');
		$params->def('PlaylistScreencolor', '');
		$params->def('Playlistwmode', 'opaque');
		$params->def('PlaylistAutostart', '0');
		$params->def('Playlistbandwidth', '5000');
		$params->def('PlaylistBufferlength', '1');
		$params->def('Playlistdisplayclick', 'play');
		$params->def('Playlistdisplaytitle', '0');
		$params->def('Playlistmute', '0');
		$params->def('Playlistlinktarget', '_blank');
		$params->def('PlaylistIcons', '1');
		$params->def('PlaylistLogo', '');
		$params->def('Playlistlogolink', '');
		$params->def('Playlistlogohide', '1');
		$params->def('Playlistlogotimeout', '3');
		$params->def('Playlistlogoposition', 'bottom-left');
		$params->def('Playlistlogolinktarget', '_blank');
		$params->def('Playlistlogomargin', '8');
		$params->def('Playlistlogoover', '1');
		$params->def('Playlistlogoout', '0.5');
		$params->def('Playlistabouttext', '');
		$params->def('Playlistaboutlink', '');
		$params->def('PlaylistRepeat', 'none');
		$params->def('PlaylistResizing', '1');
		$params->def('PlaylistShuffle', '0');
		$params->def('PlaylistSmoothing', '1');
		$params->def('PlaylistStretching', 'uniform');
		$params->def('PlaylistVolume', '90');
		
		//javascript
		$params->get('Playlistevents', '');
		$params->get('extrajsname', '');
		
		//pop -up
		$params->def('Playlistpopupenabled', '0');
		$params->def('Playlistpopupsizechoice', '0');
		$params->def('PlaylistpopupSize', '180');
		$params->def('PlaylistpopupHeight', '400');
		$params->def('PlaylistpopupWidth', '280');
		$params->def('Playlistpopuplinkchoice', '0');
		$params->def('Playlistpopuptextlink', 'Click to watch the player in a Pop-Up');
		$params->def('Playlistpopupimagelink', '');
		$params->def('Playlistpopuphighslide', '0');
		// RTMP general settings
		$params->def('Playlistrtmpprepend', '1');
		$params->def('Playlistrtmploadbalance', '0');
		$params->def('Playlistrtmpsubscribe', '0');
		// HTTP pseudo streaming general settings
		$params->def('Playlisthttpstartparam', 'start');
		$params->def('Playlisthttpdvr', '0');
		//skin
		$params->def('PlaylistSkintype', '1');
		$params->def('PlaylistSkin', '-1');
		$params->def('PlaylistSkinxml', '-1');
		// viral
		$params->def('ViralPluginEnabled', '0');
		$params->def('ViralPluginonpause', '1');
		$params->def('ViralPluginoncomplete', '1');
		$params->def('ViralPluginfunctions', 'embed,link');
		$params->def('ViralPluginrecommendations', '');
		$params->def('ViralPluginemailsubject', 'Check out this video!');
		$params->def('ViralPluginemailfooter', 'www.longtailvideo.com');
		$params->def('ViralPluginmatchplayercolors', '1');
		$params->def('ViralPluginfgcolor', 'FFFFFF');
		$params->def('ViralPluginbgcolor', '333333');
		$params->def('ViralPluginallowmenu', '1');
		$params->def('ViralPluginallowdock', '0');
		$params->def('ViralPluginmultidock', '0');
		//sharing
		$params->def('SharingPluginversion', '3');
		$params->def('SharingPluginembedEnabled', '0');
		$params->def('SharingPluginlinkEnabled', '0');
		$params->def('SharingPluginlink', '');
		$params->def('SharingPluginthumbnail', '');
		//Tipjar
		$params->def('TipJarPluginEnabled', '0');
		$params->def('TipJartitle', '');
		$params->def('TipJartext', '');
		$params->def('TipJarbusiness', '');
		$params->def('TipJaramount', '5');
		$params->def('TipJarcurrency_code', 'EUR');
		$params->def('TipJarimage_url', '');
		$params->def('TipJarreturn_url', '');
		//Adsolution
		$params->def('AdsolutionPluginEnabled', '0');
		$params->def('AdsolutionChannelcode', '');
		$params->def('AdsolutionPremiumEnabled', '0');
		//HD
		$params->def('HDPluginEnabled', '0');
		$params->def('HDPluginversion', '2');
		$params->def('HDbitrate', '1500');
		$params->def('HDfullscreen', '0');
		$params->def('HDstate', '1');
		//Google A Pro
		$params->def('GaProPluginversion', 'gapro-2');
		$params->def('GaProPluginEnabled', '0');
		$params->def('GaProaccountid', '');
		$params->def('GaProtrackstarts', '1');
		$params->def('GaProtrackpercentage', '1');
		$params->def('GaProtracktime', '1');
		$params->def('GaProidstring', '||streamer||/||file||');
		//Revolt
		$params->def('RevoltPluginEnabled', '0');
		$params->def('RevoltPlugingain', '1');
		$params->def('RevoltPlugintimeout', '10');
		//Captions
		$params->def('CaptionsPluginversion', '2');
		$params->def('CaptionsPluginEnabled', '0');
		$params->def('Captionsback', '0');
		$params->def('Captionsfontsize', '14');
		$params->def('Captionsstate', '1');
		//Flow
		$params->def('FlowPluginEnabled', '0');
		$params->def('FlowPluginversion', 'flow-2');
		$params->def('FlowPlugincoverheight', '100');
		$params->def('FlowPluginsize', '100');
		$params->def('FlowPluginshowtext', '1');
		$params->def('FlowPlugindefaultcover', '');
		$params->def('FlowPlugintitleoffset', '5');
		$params->def('FlowPlugindescriptionoffset', '25');
		$params->def('FlowPluginfont', 'Arial Rounded MT Bold');
		$params->def('FlowPluginfontsize', '12');
		$params->def('FlowPlugincolor', 'f1f1f1');
		$params->def('FlowPluginbackgroundcolor', '000000');
		$params->def('FlowPlugintweentime', '0.6');
		$params->def('FlowPluginautorotate', '0');
		$params->def('FlowPluginrotatedelay', '2500');
		$params->def('FlowPlugincontrolbaricon', '0');
		//Facebook
		$params->def('FacePluginEnabled', '0');
		$params->def('FacePluginfbitlink', '');
		$params->def('FacePluginfbitthumbnail', '');
		//Tweeter
		$params->def('TweetPluginEnabled', '0');
		$params->def('TweetPlugintweetitlink', '');
		//The Grid
		$params->def('GridPluginversion', 'grid-2');
		$params->def('GridPluginEnabled', '0');
		$params->def('GridPluginrows', '4');
		$params->def('GridPlugintilt', '8');
		$params->def('GridPlugindistance', '50');
		$params->def('GridPluginglow', '1');
		$params->def('GridPluginthumbnailwidth', '480');
		$params->def('GridPluginthumbnailheight', '270');
		$params->def('GridPluginhorizontalmargin', '100');
		$params->def('GridPluginverticalmargin', '150');
		$params->def('GridPluginstart_distance', '500');
		$params->def('GridPluginfocus_distance', '200');
		$params->def('GridPluginreflections', '0');
		$params->def('GridPluginoutside', '0');
		$params->def('GridPlugintitles', '1');
		$params->def('GridPlugintitles_position', 'over');
		$params->def('GridPlugintitles_font', '_sans');
		$params->def('GridPluginfade_titles', '1');
		$params->def('GridPluginborder', '0');
		$params->def('GridPlugindof_blur', '0');
		$params->def('GridPlugindof_fade', '0');
		//Adtonomy Text ads
		$params->def('adttextEnabled', '0');
		$params->def('adttextconfig', '');
		//Adtonomy Video ads
		$params->def('adtvideoEnabled', '0');
		$params->def('adtvideoconfig', '');
		//Adtonomy Image ads
		$params->def('adtimageEnabled', '0');
		$params->def('adtimagegraphic', '');
		$params->def('adtimagelink', '');
		$params->def('adtimagepositions', 'pre,post');
		$params->def('adtimageonpause', '0');
		//OVA
		$params->def('ovaEnabled', '0');
		$params->def('ovajson', '');
		$params->def('ovacompanion', '0');
		$params->def('ovacompanionposition', 'after');
		$params->def('ovacompanioncsssrc', 'preconfigure');
		$params->def('ovacompanionbg', 'CCCCCC');
		$params->def('ovacompanionwidth', '200');
		$params->def('ovacompanionheight', '240');
		$params->def('ovacompanionfloat', 'left');
		$params->def('ovaplayerfloat', 'left');
		$params->def('ovacompanionmargin', '5');
		$params->def('ovacompanionmarginpos', 'left');
		$params->def('ovaplayercss', 'after');
		$params->def('ovacompanioncss', 'after');
		//Extra Plugin
		$params->def('extrapluginlist', '');
		$params->def('extrapluginflashvarslist', '');
		
		// Playlist Parameters
		$params->def('mod_plselect', '0');
		
		$params->def('mod_plfile', 'http://www.joomlarulez.com/images/stories/playlist/big_buck_bunny/big_buck_bunny.xml');
		$params->def('mod_plfilecontentID', '');
		
		$params->def('mod_plfilemulti', '');
		$params->def('mod_plfilecontentIDmulti', '');
		$params->def('mod_plmultidropdownlist', '1');
		$params->def('mod_plmultidropdowntitle', '1');
		$params->def('mod_plmultidropdowntitlelength', '43');
		$params->def('mod_plmultidropdownstyle', '0');
		$params->def('mod_plmultidropdownclass', '');
		
		$params->def('mod_plbotrfile', '');
		$params->def('mod_plbotrdisplay', '0');
		$params->def('mod_plbotrapikey', '');
		$params->def('mod_plbotrsecretkey', '');
		$params->def('mod_plbotrtimeout', '3600');
		
		if ($jversion != "1.5")	{
			$params->def('mod_plauto', 'images/stories/');
		} else {
			$params->def('mod_plauto', 'images/');
		}
		$params->def('mod_plautosort', 'krsort');
		$params->def('mod_plautocontentID', '');
		$params->def('mod_plautodefthumb', '');
		$params->def('mod_plautoplaylistimage', '');
		$params->def('mod_plautoduration', '00:30');
		$params->def('mod_plautotypetitle', '0');
		$params->def('mod_plautotypedescription', '0');
		$params->def('mod_plautoallowlink', '1');
		$params->def('mod_plautoallowjpg', '1');
		$params->def('mod_plautoallowpng', '1');
		$params->def('mod_plautoallowgif', '1');
		$params->def('mod_plautoallowflv', '1');
		$params->def('mod_plautoallowmp3', '1');
		$params->def('mod_plautoallowmp4', '1');
		$params->def('mod_plautoallowm4a', '1');
		$params->def('mod_plautoallowm4v', '1');
		$params->def('mod_plautoallowmov', '1');
		$params->def('mod_plautoseparator', '_-_');
		$params->def('mod_plautotrackposition', '0');
		$params->def('mod_plautotitleposition', '3');
		$params->def('mod_plautoauthorposition', '1');
		$params->def('mod_plautodescposition', '2');
		
		$params->def('mod_plfile1', '');
		$params->def('mod_plhdfile1', '');
		$params->def('mod_plfilecontentID1', '');
		$params->def('mod_pltitle1', '');
		$params->def('mod_pldesc1', '');
		$params->def('mod_plcredit1', '');
		$params->def('mod_plthumbnail1', '');
		$params->def('mod_plcaption1', '');
		$params->def('mod_pllink1', '');
		$params->def('mod_plstart1', '');
		$params->def('mod_plstreamer1', '0');
		$params->def('mod_pltag1', '');
		$params->def('mod_plduration1', '');
		$params->def('mod_plformat1', '');
		
		$params->def('mod_plfile2', '');
		$params->def('mod_plhdfile2', '');
		$params->def('mod_plfilecontentID2', '');
		$params->def('mod_pltitle2', '');
		$params->def('mod_pldesc2', '');
		$params->def('mod_plcredit2', '');
		$params->def('mod_plthumbnail2', '');
		$params->def('mod_plcaption2', '');
		$params->def('mod_pllink2', '');
		$params->def('mod_plstart2', '');
		$params->def('mod_plstreamer2', '0');
		$params->def('mod_pltag2', '');
		$params->def('mod_plduration2', '');
		$params->def('mod_plformat2', '');

		$params->def('mod_plfile3', '');
		$params->def('mod_plhdfile3', '');
		$params->def('mod_plfilecontentID3', '');
		$params->def('mod_pltitle3', '');
		$params->def('mod_pldesc3', '');
		$params->def('mod_plcredit3', '');
		$params->def('mod_plthumbnail3', '');
		$params->def('mod_plcaption3', '');
		$params->def('mod_pllink3', '');
		$params->def('mod_plstart3', '');
		$params->def('mod_plstreamer3', '0');
		$params->def('mod_pltag3', '');
		$params->def('mod_plduration3', '');
		$params->def('mod_plformat3', '');
		
		$params->def('mod_plfile4', '');
		$params->def('mod_plhdfile4', '');
		$params->def('mod_plfilecontentID4', '');
		$params->def('mod_pltitle4', '');
		$params->def('mod_pldesc4', '');
		$params->def('mod_plcredit4', '');
		$params->def('mod_plthumbnail4', '');
		$params->def('mod_plcaption4', '');
		$params->def('mod_pllink4', '');
		$params->def('mod_plstart4', '');
		$params->def('mod_plstreamer4', '0');
		$params->def('mod_pltag4', '');
		$params->def('mod_plduration4', '');
		$params->def('mod_plformat4', '');
		
		$params->def('mod_plfile5', '');
		$params->def('mod_plhdfile5', '');
		$params->def('mod_plfilecontentID5', '');
		$params->def('mod_pltitle5', '');
		$params->def('mod_pldesc5', '');
		$params->def('mod_plcredit5', '');
		$params->def('mod_plthumbnail5', '');
		$params->def('mod_plcaption5', '');
		$params->def('mod_pllink5', '');
		$params->def('mod_plstart5', '');
		$params->def('mod_plstreamer5', '0');
		$params->def('mod_pltag5', '');
		$params->def('mod_plduration5', '');
		$params->def('mod_plformat5', '');
		
		//JONS playlist
		$params->def('mod_plfilesrc', '0');
		$params->def('mod_plfilejson', '');
		$params->def('mod_plfileextjson', '');

		return $params;
    }
}