<?php
/**
* Jw Player Plugin Advanced :  plg_jwadvanced
* @package plg_jwadvanced
* @subpackage CHANGELOG.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* final 1.13.0
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
JW Player Plugin Advanced 1.13.0, including beta and release candidate versions.
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

-------------------- JW Player Plugin Advanced 1.13.0 02 April 2012 ------------------

^ Upgrade to JW Flash Player 5.9.2156.
^ Upgrade to jwplayer.js 5.9.2156.
^ Upgrade to api botr 1.4.
^ Upgrade xml skin : beelden, bekle, five, glow, minima, modieus, stijl, stormtrooper.
^ Upgrade to jquery 1.7.2.

+ Add external JSON playlist file support.

# Load only one time gapro-2 js in html head.
# hd version not set correctly by default in J2.5 xml
# some index.html missing
# load botr template when combine mode is used.
# used botr player when combine botr override local.
# list zip skin only, not xml if not it will be list twice.
# declare botr class only once.
# Load language description with first time install under J2.5.

-------------------- JW Player Plugin Advanced 1.12.0 02 February 2012 ------------------

+ Add Joomla 2.5 support.
+ Add javascript Events support.
+ Add GAP-2 plugin, HTML5 and flash mode.
+ Add gapro.idstring flashvar, Controls the string sent to Google Analytics to identify your video.
+ Add flow.backgroundcolor flashvar, background color or the plugin.
+ Add controlbar.forcenextprev flashvar, config option to allow users to force the next/prev buttons even if the playlist is visible.

^ Upgrade to JW Flash Player 5.9.2118.
^ Upgrade to jwplayer.js 5.9.2118.
^ Upgrade to jquery 1.7.1.
^ Upgrade skin : bekle, minima.
^ Set skin type by default to xml as swf is deprecated and not html5 compatible.
^ default flashvar logo.linktarget to _blank.
^ don't display logo flashvar if empty.
^ default flashvar viral.emailfooter to www.longtailvideo.com, viral.emailsubject to Check out this video!.

# flashvar adtimage.onpause not load.
# remover url encode for tipjar email when html5 is set. 

-------------------- JW Player Plugin Advanced 1.11.0 28 October 2011 ------------------

^ Upgrade to JW Flash Player 5.8.2011.
^ Upgrade to jwplayer.js 5.8.2011.
^ Hide prev/next buttons when playlist is visible.
^ prepare php code for jw player modes and joomla component.
^ prepare php code for jw player plugin and joomla component.
^ use the return variable as tmpl/default file.
^ change default bakend name for multiple titlelength, this for optimize php script.
^ Use JHTML::stylesheet for jwbox css.
^ Upgrade to jquery 1.6.4.
^ reduce size of the license.php file.
^ Upgrade skin : beelden, bekle, five, glow, minima, modieus, stijl, stormtrooper.

+ Add new skin : fs41 and fs48.

- remove skins for reduce size package, like this the package size is less then 2MB,
those skins still can be download from longtail video website and upload to the skin directory,
swf skins are more impact as it's a deprecate format.
swf skin : atomicred, traganja, 3dpixelstyle, grungetape, pearlized, controlpanel, fashion, festival, metarby10, playcasso, silverywhite.
xml skin : cassette, witch, sbl, anoto, darksunset, plexi, selena, moderngreen, sea.

+ Add display show mute flashvar.
+ Add mute flashvar.
+ Add http start params flashvar.
+ Add http DVR flashvar.
+ Add HD-2 plugin, HTML5 and flash mode.
+ Add Flow-2 plugin, HTML5 and flash mode.

# logo.margin, logo.over and logo.out was not correctly load.
# Fix Backend selection Sharing V3 with J1.6-J1.7.
# Fix jwversion strip tag to html5_5.

-------------------- JW Player Plugin Advanced 1.10.0 19 July 2011 ------------------

+ Add Joomla! 1.7 Support.
+ Add JWBox pop-up in HTML5 mode.
+ Add levels, playlist and modes support in JSON playlist.
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
+ Add player and js embedder different location (beta).

^ Upgrade to JW Flash Player 5.7.1896.
^ Upgrade to jwplayer.js 5.7.1896.
^ Upgrade to jquery 1.6.2.
^ Upgrade to api botr 1.3.
^ Set JW embedder by default.
^ Change multiple playlist to JW 5 api.
^ Optmize fallback mode in plg_jwadvanced.php script.
^ Remove Line Feed and carrier return in meta tag.
^ Set by default plugin caption, grid and sharing to their last version.

# When mode is enabled with rtmp file remove double streamer/provider load as it is already done.
# Fix layout in the backend under safari/chrome and IE.
# change all players block to modes block.
# Fix default rows, horizontalmargin and verticalmargin flashvars for Grid plugin V2.
# Fix error with playlist editor and Tilde characters in url.

-------------------- JW Player Plugin Advanced 1.9.0 12 May 2011 ------------------

^ Upgrade to JW Player 5.6.1768.
^ Upgrade jwplayer.js.

+ Audio file support in HTML5.
+ Integrate support for ActionScript 3 YouTube API.
+ Accept JSON string input in Flash mode.

+ Add html5 file and download file fallback in playlist editor and single file.

+ Add 2 new skin : anoto and etv.
^ Update xml skin : darksunset.

^ Coding style and standards for all php files.

- remove playlist component position js setting as it will be set by a plugin in html5 mode.

# Fix plugins setting with new JS 5.6 embedder.
# Fix viral embed code when JSON playlist is set in html5 mode.
# Fix escape issue when apostrophe is set in playlist editor in html5 mode.

-------------------- JW Player Plugin Advanced 1.8.0 03 April 2011 ------------------

^ Upgrade to JW Player 5.5.1641.
^ Upgrade jwplayer.js.

+ Add Vimeo support (only with JW 5.x). (Based on project http://jwplayervimeo.sourceforge.net)

+ HD files switching support for playlist editor (JSON and XML), auto generate playlist and xml playlist (only with JW 5.x).
+ sharink.link for JSON and XML playlist editor.
+ captions.file, author, link for JSON playlist editor.

+ Add logo.margin flashvar, Licensee only.
+ Add logo.over flashvar, Licensee only.
+ Add logo.out flashvar, Licensee only.

^ Upgrade to jquery 1.5.2.

^ Optimize plg_jwadvanced.php script, reducing code size around 21%.
^ Optimize playlist editor php script and auto generate php script.
^ Optimize true - false flashvars 
^ Optimize xml skin size : trekkie, minimal, chrome, videosmartclassic, norden, slim, polishedmetal, 
ruby, lightrv5, darkrv5, metal, smooth, grol, aero, rowafed, niion, lava, alien and cassette

^ BOTR : support url already sign.

- Remove Rate-it / vote-it as it's not longuer support by rateitall.com.

# Fix popup.overidetext issue when popup.overideimage is also set.
# Fix controlbar default value when HTML5 is on.
# Fix double set plugins name for captions-2, grid-2, basic-1 and carousel-1 plugin.

-------------------- JW Player Plugin Advanced 1.7.1 30 January 2011 ------------------

# Fix language file for J1.6 support.
# Fix PHP 5.3.x warning error.
^ xml layout for playlist editor.

-------------------- JW Player Plugin Advanced 1.7.0 13 January 2011 ------------------

+ Add Joomla! 1.6 Support.
^ Modify xml config file for J1.6 support.
^ Modify ini language file for J1.6 support.
+ Add sys.ini language file for J1.6 support. 

^ change method mootools load for J!1.6.
^ change directory scan path with autogenerate playlist for J!1.6.

^ Upgrade to JW Player 5.4.1530.
^ Upgrade jwplayer.js.

-------------------- JW Player Plugin Advanced 1.6.0 19 December 2010 ------------------

^ Upgrade to JW Player 5.4.1492

+ Add JW Player for HTML5 1.0. Beta (Only with single file and playlist editor).
+ HTML5 : Add Autedetect or not jwplayer.js load.
+ HTML5 : Add Download fallback option.

^ Upgrade jwplayer.js.
^ Update xml skin : stijl.
^ Update to JQuery 1.4.4.
^ Allow playlist flashvar left.
^ Re Introduce link, displayclick flashvars since JW 5.3 (not official).
^ Re Introduce link flashvars in playlist editor and autogenerate playlist since JW 5.3 (not official).
^ Change backend Layout.
^ xml layout for playlist editor.

+ Add Captions Plugin Version 2.
+ Add Dabber The Grid Plugin Version 2.
+ Add Dabber Basic Plugin.
+ Add Dabber Carousel Plugin

+ Dabber Plugins : Add titles, titles_position, titles_font, fade_titles, start_distance, focus_distance, dof_blur, dof_fade, outside reflections and border flashvars.
+ Add controlbar.idlehide flashvar.
+ Add logo.timeout flashvar. (licensee only)

+ Add 13 new xml skin : simple, carbon, copper, facebook, graphite, lionslight, mare, moderngreen, nature01, plexi, rowafed, sbl, vector01.

# Change playlist flashvar to playlist.position this for next jwplayer.js compatibility.
# Use default skin swf if jwversion is set to 4 even the default skin mode is set to xml.
# Check when botr.file is not set that the file is really a js before assign to botr mode.
# Remove playlist from the body of the embed player when facebook video sharing is set and size of the player is automatically resizing.
# fix error with popup size.

-------------------- JW Player Plugin Advanced 1.5.1 29 October 2010 ------------------

^ Upgrade to JW Player 5.3.1397
^ Upgrade jwplayer.js

-------------------- JW Player Plugin Advanced 1.5.0 23 October 2010 ------------------

^ Upgrade to JW Player 5.3.1356.

+ Add thumbnail automatically for youtube video.
+ Add jwplayer.js.

+ Add 12 new xml skin : aero, alien, darkrv5, lava, lightrv5, metal, minimal, ruby, slim, smooth, audioglow and stijl

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
^ Modify jwbox.css for compatibilty with OAV companion.
^ replace video.flv by video.mp4.

# Fix sign player when botr override local is set.
# Fix skin format when botr override local is set.
# Fix error with default value adtext and advideo.

-------------------- JW Player Plugin Advanced 1.4.0 12 September 2010 ------------------

+ Add video.joomlarulez.com - Botr support, our streaming video platform based on Bits On The Run server.

+ Botr web interface, upload (web or ftp), manage and publish single videos.
+ Botr web interface, create, manage and publish channels (playlists of videos).
+ Botr web interface, create and manage players (the widgets that play your video).
+ Botr web interface, statistics, analyze how your videos perform. Track views, pageviews, hours viewed and engagement.
+ Botr web interface, Account management, you can track your content and traffic balance and edit your account settings.

+ Botr Backend plugin, Set default Api Key Player.
+ Botr Backend plugin, Choose streaming display : Botr, combine botr to Local, combine local to botr, Local.
+ Botr Backend plugin, Sign url, your content is secure by signing link trough your secret api key.
+ Botr Backend plugin, Set time out for sign url.

+ Add api botr.

+ Add support for playlist.image in PlaylistItem in auto generate playlist.
+ Add support m4v in auto generate playlist.

^ xml layout for autogenerate playlist.

# Fix default value of playlist size at 0.
# Fix list file error in autogenerate playlist when some extension file match in the name file.
# Fix unset flashvars variable with popup.
# Fix error for assign position of description in auto generate playlist.
# Fix error in concatenate extra plugin and plugin.

-------------------- JW Player Plugin Advanced 1.3.0 17 July 2010 ------------------

^ Upgrade to JW Player 5.2.1151.
^ Upgrade to JW Player 4.7.1128.

+ Add Extra Plugin Features, this allow all plugins support like Dart, Yume, SpotXChange, Tremor and ScanScout for example.
+ Add Extra Flashvars Features.
+ Add Extra Javascript Features.

+ Add 7 new xml skin : Metall, Glatt, jump, sea, spirit, sun and witch.

+ Add _parent, _top to logo.linktarget flashvars, Licensee only.
+ Add Flash Debug Mode flashvars.
+ Add alternative image trigger, img, this for JCE clean up compatibility.

-------------------- JW Player Plugin Advanced 1.2.1 27 June 2010 ------------------

# Fix error when youtube and caption file is call without file syntax.

-------------------- JW Player Plugin Advanced 1.2.0 14 June 2010 ------------------

^ Upgrade to JW Player 5.2.1065.

+ Add new 30 xml skin : fs28, fs29, fs31, fs33, fs33aqua, fs34, fs35, fs36, fs37, fs38,
cassette, chrome, darksunset, eleganttwilight, glow, grol, iskin, nexus, niion, norden, rana, rime,
selena, simplicity, skewd, tiby, trekkie, videosmartclassic, whotube and xero.

+ Add, Licensed version: allow for logo.linktarget flashvar.
+ Add, Licensed version: allow for abouttext flashvar, Right-Click Menu Configuration.
+ Add, Licensed version: allow for aboutlink flashvar, Right-Click Menu Configuration.
+ Add top Playlist position flashvars.

^ Update xml skin : lulu, five, classic, stormtrooper, beelden
^ Verify when autogenerate playlist is set that slashes are correctly set.

- Remove RTMP general settings, as it display flashvars only if need, it's no longuer need.

# Fix error path to skin.

-------------------- JW Player Plugin Advanced 1.1.1 16 May 2010 ------------------

+ Add Container setting for JW Box.

^ Set Fix Mootools Conflict to yes by default.
^ Set dock to true automatically if tweeter-it or facebook-it is use.

# Set alt text to default for popup.image if alt text not set.

-------------------- JW Player Plugin Advanced 1.1.0 02 May 2010 ------------------

^ Upgrade swf skin : bekle, bluemetal, grungetape, icecreamsneaka, kleur, modieus, nacht, playcasso, schoon, snel and stijl.
^ Change xml file (folderlist) listing by zip xml file listing (filelist).
^ Set css jwbox field empty, this to prevent 403 error in some server.
^ strip tag function before rendering player setting between trigger

+ Add title youtube playlist support for multiple playlist, using curl library.
+ Add 2 new swf skin : five, classic.
+ Add xml zip support.
+ Add 15 new xml skin : bluemetal, icecreamsneaka, five, kleur, modieus, classic, playcasso, snel, bekle, grungetape, lulu, nacht, schoon, polishedmetal and stormtrooper.

+ Add The Adtonomy Text Ads Plugin.
+ Add The Adtonomy Video Ads Plugin.

# Fix ftp folderlist and filelist issue.
# Ignore index from skin swf and xml list.
# Set default as true fo viral.onpause and viral.oncomplete

-------------------- JW Player Plugin Advanced 1.0.3 12 April 2010 ------------------

# Fix issue with length name in mutiple playlist.

-------------------- JW Player Plugin Advanced 1.0.2 10 April 2010 ------------------

# Fix issue with single youtube video link.

-------------------- JW Player Plugin Advanced 1.0.1 04 April 2010 ------------------

# Fix issue under chrome and safari browser, when using mootools in a template with JW Box activate.
^ Change xml installer by an upgrade installer

-------------------- JW Player Plugin Advanced 1.0.0 27 March 2010 ------------------

Initial version