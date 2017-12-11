<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version $Id$
* @package mod_playerjr_ad
* @subpackage CHANGELOG.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
1. Copyright and disclaimer
---------------------------
This application is opensource software released under the GPL.  Please
see source code and the JoomlaRuleZ! License Guidelines
http://www.joomlarulez.com/joomlarulez-license.html


2. Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
JW Player Module Advanced 2.14.0, including beta and release candidate versions.
Our thanks to all those people who've contributed bug reports and
code fixes.

Legend:

* -> Security Fix
# -> Bug Fix
$ -> Language fix or change
+ -> Addition
^ -> Change
- -> Removed
! -> Note

-------------------- JW Player Module Advanced 2.14.0 02 April 2012 ------------------

^ Upgrade to JW Flash Player 5.9.2156.
^ Upgrade to jwplayer.js 5.9.2156.
^ Upgrade to api botr 1.4.
^ Upgrade xml skin : beelden, bekle, five, glow, minima, modieus, stijl, stormtrooper.
^ Upgrade to jquery 1.7.2.

+ Add external JSON playlist file support.

# Load only one time gapro-2 js in html head.
# load botr template when combine mode is used.
# remove default value in xml file for gaproidstring in J1.5 only.
# list zip skin only, not xml if not it will be list twice.
# some index.html missing
# declare botr class only once.

-------------------- JW Player Module Advanced 2.13.0 02 February 2012 ------------------

+ Add Joomla 2.5 support.
+ Add JSON playlist menu with JSON playlist, Levels playlist and mode playlist support.
+ Add javascript Events support.
+ Add hd file and captions fle support with playlist editor in html5 mode.
+ Add GAP-2 plugin, HTML5 and flash mode.
+ Add flow.backgroundcolor flashvar, background color or the plugin.
+ Add gapro.idstring flashvar, Controls the string sent to Google Analytics to identify your video.
+ Add controlbar.forcenextprev flashvar, config option to allow users to force the next/prev buttons even if the playlist is visible.

^ Upgrade to JW Flash Player 5.9.2118.
^ Upgrade to jwplayer.js 5.9.2118.
^ Upgrade to jquery 1.7.1.
^ Upgrade skin : bekle, minima.
^ prepare php code for jw player plugin and joomla component.
^ Set skin type by default to xml as swf is deprecated and not html5 compatible.
^ Set default swf and xml skin to none.
^ change xml name flashvars this for optimize script, this mean dev have to check those flashvars after upgrade :
gapro.accountid, gapro.tracktime, gapro.trackpercentage, gapro.trackstarts.
^ unload true-false flashvars when set to default for dabber, flow, captions, hd, gapro, viral
^ default flashvar logo.linktarget to _blank.
^ default flashvar flow.showtext to false.
^ default flashvar captions.state to true.
^ default flashvar viral.onpause to true, viral.oncomplete to true, viral.matchplayercolors to true, 
viral.emailfooter to www.longtailvideo.com, viral.emailsubject to Check out this video!.

# flashvar adtimage.onpause not load.
# remover url encode for tipjar email when html5 is set.

-------------------- JW Player Module Advanced 2.12.0 28 October 2011 ------------------

^ Upgrade to JW Flash Player 5.8.2011.
^ Upgrade to jwplayer.js 5.8.2011.
^ Hide prev/next buttons when playlist is visible.
^ Use JHTML::stylesheet for jwbox css.
^ Upgrade to jquery 1.6.4.
^ reduce size of the license.php file.
^ change xml name flashvars this for optimize script, this mean dev have to check those flashvars after upgrade :
logo.link, logo.hide, logo.timeout, logo.pos, multiple titlelength
^ Upgrade skin : beelden, bekle, five, glow, minima, modieus, stijl, stormtrooper.

+ Add new skin : fs41 and fs48.
+ Add display show mute flashvar.
+ Add mute flashvar.
+ Add http start params flashvar.
+ Add http DVR flashvar.

+ Add HD-2 plugin, HTML5 and flash mode.
+ Add Flow-2 plugin, HTML5 and flash mode.

- remove skins for reduce size package, like this the package size is less then 2MB,
those skins still can be download from longtail video website and upload to the skin directory,
swf skins are more impact as it's a deprecate format.
swf skin : atomicred, traganja, 3dpixelstyle, grungetape, pearlized, controlpanel, fashion, festival, metarby10, playcasso, silverywhite.
xml skin : cassette, witch, sbl, anoto, darksunset, plexi, selena, moderngreen, sea.

# logo.margin, logo.over and logo.out default value was not correctly set.

-------------------- JW Player Module Advanced 2.11.0 19 July 2011 ------------------

+ Add Joomla! 1.7 Support.
+ Add JWBox pop-up in HTML5 mode.
+ Add The Adtonomy Image Ads Plugin.
+ Add Sharing V3 Plugin, HTML5 and flash mode.
+ Playlist UI element, Add playlist control in HTML5 mode.
+ Add iScroll 4.1.7, this for html5 playlist scrolling under iOS.
+ HTML5 : Add Autedetect or not iScroll.js load.
+ Add XML Playlist support in HTML5 mode (XML Playlist RSS and mRSS only, Autogenerate Playlist, Multiple playlist).
+ Add provider in autogenerate playlist.
+ Add image.duration flashvar. (With a default image duration, the player can be used for slideshows of e.g. Flickr feeds. )
+ Alias provider="audio" to provider="sound".
+ Add 4 new skin : nemesis, newtube, solidgold and minima.

^ Upgrade to JW Flash Player 5.7.1896.
^ Upgrade to jwplayer.js 5.7.1896.
^ Upgrade to jquery 1.6.2.
^ Upgrade to api botr 1.3.
^ Set JW embedder by default.
^ Change multiple playlist to JW 5 api.
^ Set by default plugin caption, grid and sharing to their last version.

# Fix provider embed modes for sound, video and image in playlist editor.
# change all players block to modes block.
# Fix error with playlist editor and Tilde characters in url.

-------------------- JW Player Module Advanced 2.10.1 18 May 2011 ------------------

# fix xml name flashvars under J1.6 : wmode, rtmp.loadbalance, rtmp.subscribe, playlist position, debug

-------------------- JW Player Module Advanced 2.10.0 12 May 2011 ------------------

^ Upgrade to JW Player 5.6.1768.
^ Upgrade jwplayer.js.
^ Update xml skin : darksunset.
^ Optimize true - false flashvars.
^ Optimize mod_playerjr_ad.php script, reducing code size around 24%.
^ Optimize playlist editor php script and auto generate php script.
^ change xml name flashvars this for optimize script, this mean dev have to check those flashvars after upgrade :
wmode, rtmp.loadbalance, rtmp.subscribe, playlist position, debug
^ Coding style and standards for all php files.

+ Audio file support in HTML5.
+ Integrate support for ActionScript 3 YouTube API.
+ Accept JSON string input in Flash mode.
+ Add html5 file and download file fallback in playlist editor.
+ Add 2 new skin : anoto and etv.

- remove video.mp4 and preview.jpg this for reducing package size.
- remove playlist component position js setting as it will be set by a plugin in html5 mode.

# Fix plugins setting with new JS 5.6 embedder.
# Fix viral embed code when JSON playlist is set in html5 mode.
# Fix escape issue when apostrophe is set in playlist editor in html5 mode.

-------------------- JW Player Module Advanced 2.9.0 03 April 2011 ------------------

^ Upgrade to JW Player 5.5.1641.
^ Upgrade jwplayer.js.
^ Upgrade to jquery 1.5.2.
^ Optimize mod_playerjr_ad.php script.
^ Optimize playlist editor php script and auto generate php script.
^ Optimize xml skin size : trekkie, minimal, chrome, videosmartclassic, norden, slim, polishedmetal, 
ruby, lightrv5, darkrv5, metal, smooth, grol, aero, rowafed, niion, lava, alien and cassette.
^ BOTR : support url already sign.

+ Add Vimeo support (only with JW 5.x). (Based on project http://jwplayervimeo.sourceforge.net)
+ HD files switching support for playlist editor (JSON and XML), auto generate playlist and xml playlist (only with JW 5.x).
+ captions.file, author, link for JSON playlist editor.
+ Add logo.margin flashvar, Licensee only.
+ Add logo.over flashvar, Licensee only.
+ Add logo.out flashvar, Licensee only.

- Remove Rate-it / vote-it as it's not longuer support by rateitall.com.

# Fix controlbar default value when HTML5 is on.
# Fix description issue in JSON playlist when HTML5 is on.

-------------------- JW Player Module Advanced 2.8.1 30 January 2011 ------------------

# fix language error under J1.6.
^ xml layout for playlist editor.

-------------------- JW Player Module Advanced 2.8.0 13 January 2011 ------------------

+ Add Joomla! 1.6 Support.
+ Add sys.ini language file for J1.6 support.

^ Modify xml config file for J1.6 support.
^ Modify ini language file for J1.6 support.
^ change default autogenerate playlist folder to images/ for J!1.6
^ Remove load in body css and js when cache is enabled for J!1.6
^ change method mootools load for J!1.6
^ Upgrade to JW Player 5.4.1530.
^ Upgrade jwplayer.js.

-------------------- JW Player Module Advanced 2.7.0 19 December 2010 ------------------

^ Upgrade to JW Player 5.4.1492
^ Upgrade jwplayer.js.
^ Update xml skin : stijl.
^ Update to JQuery 1.4.4.
^ Allow playlist flashvar left.
^ Re Introduce link, displayclick flashvars since JW 5.3 (not official).
^ Re Introduce link flashvars in playlist editor and autogenerate playlist since JW 5.3 (not official).
^ Change backend Layout.
^ xml layout for autogenerate playlist and playlist editor.

+ Add JW Player for HTML5 1.0. Beta (Only with single file and playlist editor).
+ HTML5 : Add Autedetect or not jwplayer.js load.
+ HTML5 : Add Download fallback option.
+ Add Captions Plugin Version 2.
+ Add Dabber The Grid Plugin Version 2.
+ Add Dabber Basic Plugin.
+ Add Dabber Carousel Plugin
+ Dabber Plugins : Add titles, titles_position, titles_font, fade_titles, start_distance, focus_distance, dof_blur, dof_fade, outside reflections and border flashvars.
+ Add controlbar.idlehide flashvar.
+ Add logo.timeout flashvar. (licensee only)
+ Add 13 new xml skin : simple, carbon, copper, facebook, graphite, lionslight, mare, moderngreen, nature01, plexi, rowafed, sbl, vector01.
+ Add Extra Javascript Features.

# Change playlist flashvar to playlist.position this for next jwplayer.js compatibility.
# Remove playlist from the body of the embed player when facebook video sharing is set and size of the player is automatically resizing.

-------------------- JW Player Module Advanced 2.6.1 29 October 2010 ------------------

^ Upgrade to JW Player 5.3.1397
^ Upgrade jwplayer.js

-------------------- JW Player Module Advanced 2.6.0 24 October 2010 ------------------

^ Upgrade to JW Player 5.3.1356.

+ Add thumbnail automatically for youtube video.
+ Add jwplayer.js.
+ Add 12 new xml skin : aero, alien, darkrv5, lava, lightrv5, metal, minimal, ruby, slim, smooth, audioglow and stijl.
+ Add all flashvars support for pop-up windows.
+ Add all flashvars support for sharing embed.
+ Add Sharing PLugin Version 2.
+ Add Facebook embed videoplayer feature with Sharing Plugin Or Facebook It.
+ Add Load Meta and Link in HTML Head for Sharing the videoplayer on Facebook : Automatic, force to yes, force to no.
+ Add Open Video Ads (OVA) Plugin.
+ Add OVA companion banner.
+ Add OVA companion banner Div Position.
+ Add OVA companion banner CSS Source.
+ Add OVA companion banner Pre configure CSS width.
+ Add OVA companion banner Pre configure CSS height.
+ Add OVA companion banner Pre configure CSS background color.
+ Add OVA companion banner and player Pre configure CSS float position.
+ Add OVA companion banner Pre configure CSS margin and position margin.
+ Add OVA companion banner CSS Fields.
+ Add OVA companion Player CSS Fields.
+ Add OVA companion CSS file.
+ Add config flashvars, location of a XML file with flashvars.

^ Update xml skin : beelden, bekle, bluemetal, classic, five, glow, grungetape, icecreamsneaka, kleur, modieus, nacht, playcasso, schoon and snel
^ Item flashvar optimization, this for assign content ID feature.
^ Modify jwbox.css for compatibilty with OAV companion.
^ replace video.flv by video.mp4.

- remove undefined default variable for Logo and logolink flashvars.
- remove 0 default variable for sharing link flashvars.
- remove some pop-up windows variable no longuer needs.

# Fix flashvar playlistsize error for pop-up.
# Fix embed code error with sharing on the JW Box Pop-up.
# Fix sign player when botr override local is set.
# Fix skin format when botr override local is set.

-------------------- JW Player Module Advanced 2.5.0 12 September 2010 ------------------

+ Add video.joomlarulez.com - Botr support, our streaming video platform based on Bits On The Run server.

+ Botr web interface, upload (web or ftp), manage and publish single videos.
+ Botr web interface, create, manage and publish channels (playlists of videos).
+ Botr web interface, create and manage players (the widgets that play your video).
+ Botr web interface, statistics, analyze how your videos perform. Track views, pageviews, hours viewed and engagement.
+ Botr web interface, Account management, you can track your content and traffic balance and edit your account settings.

+ Botr Backend Module, Choose streaming display : Botr, combine botr to Local, combine local to botr, Local.
+ Botr Backend Module, Sign url, your content is secure by signing link trough your secret api key.
+ Botr Backend Module, Set time out for sign url.

+ Add api botr.

+ Add support for playlist.image in PlaylistItem in auto generate playlist.
+ Add support m4v in auto generate playlist.
+ Add repeat flashvars for pop-up windows.

^ xml layout for autogenerate playlist.

# Fix list file error in autogenerate playlist when some extension file match in the name file.
# Fix default value of playlist size at 0.

-------------------- JW Player Module Advanced 2.4.0 13 July 2010 ------------------

+ Add Extra Plugin Features, this allow all plugins support like Dart, Yume, SpotXChange and ScanScout for example.
+ Add Extra Flashvars Features.

+ Add 2 new xml skin : Metall and Glatt

+ Add _parent, _top to logo.linktarget flashvars, Licensee only.
+ Add fbit.link flashvars to Facebook-it plugin.
+ Add tweetit.link flashvars to Tweeter-it plugin.
+ Add Flash Debug Mode flashvars.

-------------------- JW Player Module Advanced 2.3.0 14 June 2010 ------------------

^ Upgrade to JW Player 5.2.1065.

+ Add new 30 xml skin : fs28, fs29, fs31, fs33, fs33aqua, fs34, fs35, fs36, fs37, fs38,
cassette, chrome, darksunset, eleganttwilight, glow, grol, iskin, nexus, niion, norden, rana, rime,
selena, simplicity, skewd, tiby, trekkie, videosmartclassic, whotube and xero.

+ Add, Licensed version: allow for logo.linktarget flashvar.
+ Add, Licensed version: allow for abouttext flashvar, Right-Click Menu Configuration.
+ Add, Licensed version: allow for aboutlink flashvar, Right-Click Menu Configuration.
+ Add top Playlist position flashvars.

^ Display flashvars only if need.
^ Prepare code for video.joomlarulez.com support.
^ Prepare code for JW Player for HTML5 1.0 support.
^ Update xml skin : lulu, five, classic, stormtrooper, beelden

^ Verify when autogenerate playlist is set that slashes are correctly set.

# When multiple playlist set, defaut playlist set to first one.

- Remove RTMP general settings, as it display flashvars only if need, it's no longuer need.

-------------------- JW Player Module Advanced 2.2.1 16 May 2010 ------------------

+ Add Container setting for JW Box.

^ Set Fix Mootools Conflict to yes by default.
^ Set dock to true automatically if tweeter-it or facebook-it is use.

-------------------- JW Player Module Advanced 2.2.0 02 May 2010 ------------------

^ Upgrade swf skin : bekle, bluemetal, grungetape, icecreamsneaka, kleur, modieus, nacht, playcasso, schoon, snel and stijl.
^ Change xml file (folderlist) listing by zip xml file listing (filelist).
^ Set css jwbox field empty, this to prevent 403 error in some server.

+ Add title youtube playlist support for multiple playlist, using curl library.
+ Add 2 new swf skin : five, classic.
+ Add xml zip support.
+ Add 15 new xml skin : bluemetal, icecreamsneaka, five, kleur, modieus, classic, playcasso, snel, bekle, grungetape, lulu, nacht, schoon, polishedmetal and stormtrooper.

+ Add The Adtonomy Text Ads Plugin.
+ Add The Adtonomy Video Ads Plugin.

# Ignore index from skin swf and xml list.
# Set span container for JW Box text and/or image override.
# hide logo.link flashvars if undefined.

-------------------- JW Player Module Advanced 2.1.3 12 April 2010 ------------------

# Fix issue with length name in mutiple playlist.

-------------------- JW Player Module Advanced 2.1.2 04 April 2010 ------------------

# Fix issue under chrome and safari browser, when using mootools in a template with JW Box activate.
^ Change xml installer by an upgrade installer

-------------------- JW Player Module Advanced 2.1.1 20 March 2010 ------------------

^ Upgrade to JW Player 5.1.897.

-------------------- JW Player Module Advanced 2.1.0 08 March 2010 ------------------

^ Upgrade to JW Player 5.1.854.

^ Update to jquery 1.4.2.

+ Add Multiple Playlist Features with a lot of parameters :
	Appears with a dropdown List under the player.
	Assign a content ID to a playlist.
	Playlist Titles for Dropdown List choice (adress of the link, clean name of the file, or title of the rss link using curl library).
	Length Max of Playlist title for Dropdown List.
	Dropdown Style choice (defaut or using css class).

+ Add The Grid Plugin.

+ Add In Flow Plugin defaultcover flashvars.
+ Add In Flow Plugin titleoffset flashvars.
+ Add In Flow Plugin descriptionoffset flashvars.
+ Add In Flow Plugin font flashvars.
+ Add In Flow Plugin fontsize flashvars.
+ Add In Flow Plugin color flashvars.
+ Add In Flow Plugin tweentime flashvars.
+ Add In Flow Plugin autorotate flashvars.
+ Add In Flow Plugin rotatedelay flashvars.
+ Add In Flow Plugin controlbaricon flashvars.

-------------------- JW Player Module Advanced 2.0.5 13 February 2010 ------------------

^ Add link to documentation in backend
$ adjust other parameters layout according to documentation

-------------------- JW Player Module Advanced 2.0.4 07 February 2010 ------------------

^ Update to jquery 1.4.1.

-------------------- JW Player Module Advanced 2.0.3 24 January 2010 ------------------

+ Add Load jquery.jwbox.js Automatic, force to yes, force to no.

^ Optimize playlist editor, only generate items and flaswars needs.
^ Optimize autogenerate playlist, only generate items and flaswars needs.
^ Update to jquery 1.4.

-------------------- JW Player Module Advanced 2.0.2 9 January 2010 ------------------

# Fix Tipjar error
# Fix error with Jw 4.6

- Remove link flashvars for JW 5.x (deprecated), not for JW 4.6

+ Add Tweet-It v1.0 Plugin

-------------------- JW Player Module Advanced 2.0.1 31 December 2009 ------------------

$ Description help for item 5 in playlist editor doesn't appear correctly.
# Fix issue code with sharing embed plugin.
# Fix issue code with viral embed plugin.
# Fix issue code with assign ID.
# HTML Errors.
^ Field RSS Link only work with real playlist field no more with single file, for single file use playlist editor.
^ HD Plugin file field move under field of first file of playlist editor.

-------------------- JW Player Module Advanced 2.0.0 20 December 2009 ------------------

^ Upgrade to JW Player 5.0.753.

^ Upgrade to swfobject 2.2.

+ Add Select JW Player Version and by the way add automatic switch flashvars parameters according JW version.
+ Add Load Swfobject Automatic, force to yes, force to no.

+ Plugin : Add Facebook Plugin.

+ Pop-Up : Add size, height, width configurable.
+ Pop-Up : Add Image link.
+ Pop-Up : Add Overide Player with text or image link.
+ Pop-Up : Add Highslide Effect.
+ Pop-Up : Add JWBox (Lightbox) Effect.
+ Pop-Up : Add Autedetect or not Jquery load for JWBox.
+ Pop-Up : Add Load CSS or not for JWBox.

+ Add XML Skin support, only with JW 5.x.
+ Add Choice type of skin, SWF or XML.
+ Skin : Add beelden xml.

- Behavior : Remove displayclick for  JW 5.x Version, deprecated.
- Behavior : Remove displaytitle for  JW 5.x Version, Currently not implemented.

- Layout : Remove logo for  JW 5.x Version.

+ Plugin : Add Vote-it for JW 5.x Version, (for JW 4.x always Rate-It available), Licensed players only.

- Remove Fix Mootools and Jquery Conflict, not longuer need since upgrade to swfobject 2.2.

+ Layout : Add logo.file for JW 5.x Version, Licensed players only.
+ Layout : Add logo.link for JW 5.x Version, Licensed players only.
+ Layout : Add logo.hide for JW 5.x Version, Licensed players only.
+ Layout : Add logo.position for JW 5.x Version, Licensed players only.

+ Add en-GB.ini Language Backend.

^ Clean up Code.
^ Reduce variables set when unused, RAM server optimization.
^ Change XML Layout.

-------------------- JW Player Module Advanced 1.5.3 28 November 2009 ------------------

# Fix Issue with GAP Plugin

-------------------- JW Player Module Advanced 1.5.2 15 November 2009 ------------------

^ Upgrade to the new Adsolution Channel Code

-------------------- JW Player Module Advanced 1.5.1 13 November 2009 ------------------

^ Upgrade to JW Player 4.6.485

# Fix error notice Undefined variable, when fixmootools and fixjquery is force to no

-------------------- JW Player Module Advanced 1.5.0 30 October 2009 ------------------

^ Upgrade to JW Player 4.6

+ Add Pop-up Player

+ Add Flow Plugin

+ Add RTMP General settings : Prepend, Load Balance, Subscribe.

- Removed expressInstall.swf in the package (no longuer need)

+ Add Top Position for Control Bar
+ Add Behaviour : Bandwidth, available bandwidth for streaming the file.

# Fix some bugs In autogenerate playlist
# Fix error in embed code for sharing plugin

-------------------- JW Player Module Advanced 1.4.0 30 September 2009 ------------------

^ Viral Plugin 2.0

+ Add Revolt Plugin

+ Add Captions Plugin (work also with autogenerate Playlist and Playlist Editor)

+ Add premium Ads Support for Plugin Adsolution

+ Add Dynamic Playlist Item Start according to specific Content ID :
	Assign One Article/Section/Category to an Specific Item in a playlist generate By an XML link.
	Assign One Article/Section/Category to an Specific Item in a playlist generate By the autogenerate playlist.
	Assign One or more Article/Section/Category to an Specific Item in the playlist Editor.

+ Add Auto detect mootools/jquery use (Always have choice to force prevent conflict to Yes or No)

+ Add In HD Plugin Bitrate settings for RTMP stream
+ Add In HD Plugin Fullscreen flashvars
+ Add In HD Plugin State start flashvars

+ Select what type of file can list in Auto Generate Playlist (this not influence thumbnail only stream file)
+ Allow or not Link in Auto Generate Playlist

+ Change in ID Field of tipjar plugin, @ by is html code (this for prevent breaking code if script against spambot is use)

- Remove ID example for adsolution plugin (this for prevent some missunderstood, ID example are only in description)
- Remove email example for tipjar plugin (this for prevent some missunderstood, email example are only in description)

^ Verify when adsolution plugin is enabled that all field are not empty

+ Add Auto detect Viral embed Link
+ Add some Link helper in xml package
+ Add automaticly sort in the Skin selection list you own skin upload in the skin directory
^ Change layout in xml package
^ Change Field "List" for skin slection by Field "Filelist" by this way it detect automaticly if there is a skin select or not

# Allow  playlist editor  with HD Plugin (single file on File 1)

# Fix conflict with jquery


-------------------- JW Player Module Advanced 1.3.0 18 August 2009 ------------------

+ Add Auto Generate Playlist, Scan files (flv, mp3, mp4, m3u, jpg, png, gif) in a directory and generate a playlist :
	Sort by date, alphabetical, random.
	Assign automaticly thumbnail file (jpg, png, gif) with audio/video file (flv, mp3, mp4, m3u) associate (same name).
	Assign defaut thumbnail (or not) with file with no thumbnail associate.
	Assign duration for image file, useful for a playlist with a lot of picture alone like gallery.
	Occurence filters for analyse name file for generate track number, title, description and author.

+ Add Plugin HD
+ Add Plugin Sharing

+ Add Tag/Keywords support (Playlist Editor)
+ Add RTMP/HTTP Streamer support (Playlist Editor)
+ Add Start RTMP/HTTP (Playlist Editor)
^ Change and add Type (Playlist Editor)
^ GET name (Playlist Editor)

^ Automatic Module Setting Suffix

+ Add Behaviour : Display Click
+ Add Behaviour : Link Target

+ Add Layout : Dock

-------------------- JW Player Module Advanced 1.2.1 28 July 2009 ------------------

+ Add Behaviour : Display Title
+ Add CDATA information during install

# Add Module class SFX

^ Change old Field "Module Class SFX" by "Module Setting SFX"

-------------------- JW Player Module Advanced 1.2.0 19 July 2009 ------------------

^ Update JW Player to 4.5

+ Add Plugin Google Analytics Pro

+ Add multiple plugin on same player (viral, rateit, tipjar, adsolution, Google Analytics Pro)

+ Add Skin seawave.swf
+ Add Skin chelseaskin.swf

+ Add expressInstall.swf in package

+ Add LICENSES.php
+ Add CREDITS.php

# Now support multiple Youtube link in playlist editor

# Fix error xml with an apostrophe ' in playlist editor field

# Fix midroll error in Adsolution Plugin

$ Change Field name "Local Playlist" by "Playlist Editor"

-------------------- JW Player Module Advanced 1.1.2 27 May 2009 ------------------

^ Change Player Unbranded by a Branded player, License Holders have to upload by FTP the player Unbranded, See How-To here :
http://www.joomlarulez.com/faq/44-faq/56-how-to-install-your-personal-license-player.html

# Fix Internal Playlist error, UTF-8 without BOM

-------------------- JW Player Module Advanced 1.1.1 19 May 2009 ------------------

# Fix Mootools conflict under IE7

^ Put JS in HTML Head

+ Add Multiple Player support on same page with adsolution plugin activate

+ Add Choose Link display to Adobe Flash Player if not installed


-------------------- JW Player Module Advanced 1.1.0 06 May 2009 ------------------

+ Ad Solution Plugin Full Support : No Hack

+ Youtube Link support for External RSS Link

^ License-holders can download an unbranded player
with their Licence number and replace themself
the player in the directory of JW Module Player.

+ Layout : Transparence of the Playlist

+ Behaviour : Auto Start
+ Behaviour : Buffer Length
+ Behaviour : Icon
+ Behaviour : Logo
+ Behaviour : Repeat
+ Behaviour : Resizing
+ Behaviour : Shuffle
+ Behaviour : Smoothing
+ Behaviour : Stretching
+ Behaviour : Volume

+ Changelog : Package include changelog.php

-------------------- JW Player Module Advanced 1.0.1 01 May 2009 ------------------

# Fix XML Error

-------------------- JW Player Module Advanced 1.0 20 March 2009 ------------------
Public Release