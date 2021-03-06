<?php
/**
*Jw Player Module Advanced : playlist5
* @version $Id$
* @package mod_playerjr_ad
* @subpackage playlist5.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/
header("content-type:text/xml;charset=utf-8");
echo "<rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:jwplayer=\"http://developer.longtailvideo.com/trac/wiki/FlashFormats\">\n\t<channel>\n";
$count = 6;
for ($i = 1; $i < $count; $i++) {
	if (!(empty($_GET["pf".$i]))) {
		echo "\t\t<item>\n";
		if (!(empty($_GET["pt".$i]))) {
			echo "\t\t\t<title>".base64_decode($_GET["pt".$i])."</title>\n";
		}
		if (!(empty($_GET["pd".$i]))) {
			echo "\t\t\t<description>".base64_decode($_GET["pd".$i])."</description>\n";
		}
		if (!(empty($_GET["pc".$i]))) {
			echo "\t\t\t<media:credit role=\"author\">".base64_decode($_GET["pc".$i])."</media:credit>\n";
		}
		echo "\t\t\t<media:content url=\"".base64_decode(str_replace(' ','+',$_GET["pf".$i]))."\"";
		if (!(empty($_GET["dur".$i]))) {
			echo" duration=\"".$_GET["dur".$i]."\" />\n";
		} else {
			echo" />\n";
		}
		if (!(empty($_GET["pfo".$i]))) {
			echo "\t\t\t<jwplayer:provider>".$_GET["pfo".$i]."</jwplayer:provider>\n";
		}
		if (!(empty($_GET["str".$i]))) {
			echo "\t\t\t<jwplayer:streamer>".base64_decode(str_replace(' ','+',$_GET["str".$i]))."</jwplayer:streamer>\n";
		}
		if (!(empty($_GET["st".$i]))) {
			echo "\t\t\t<jwplayer:start>".$_GET["st".$i]."</jwplayer:start>\n";
		}
		if (!(empty($_GET["cap".$i]))) {
			echo "\t\t\t<jwplayer:captions>".base64_decode(str_replace(' ','+',$_GET["cap".$i]))."</jwplayer:captions>\n";
		}
		if (!(empty($_GET["hd".$i]))) {
			echo "\t\t\t<jwplayer:hd.file>".base64_decode(str_replace(' ','+',$_GET["hd".$i]))."</jwplayer:hd.file>\n";
		}
		if (!(empty($_GET["pth".$i]))) {
			echo "\t\t\t<media:thumbnail url=\"".base64_decode(str_replace(' ','+',$_GET["pth".$i]))."\" />\n";
		}
		if (!(empty($_GET["tg".$i]))) {
			echo "\t\t\t<media:keywords>".base64_decode($_GET["tg".$i])."</media:keywords>\n";
		}
		if (!(empty($_GET["pl".$i]))) {
			echo "\t\t\t<link>".base64_decode($_GET["pl".$i])."</link>\n";
		}
		echo "\t\t</item>\n";
	}
}
echo "\t</channel>\n</rss>\n";
?>