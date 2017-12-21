<?php
/**
*Jw Player Module Advanced : mod_playerjr_ad
* @version $Id$
* @package mod_playerjr_ad
* @subpackage autogenerate_playlist.php
* @author joomlarulez.
* @copyright (C) www.joomlarulez.com
* @license Limited  http://www.gnu.org/licenses/gpl.html
* @final 2.14.0
*/

//Extension Filters
$filterjpg = '.jpg';
$filterpng = '.png';
$filtergif = '.gif';
$filtersrt = '.srt';
$filterxml = '.xml';

if ($_GET['flv'] == '1') {
	$filterflv = '.flv';
} else {
	$filterflv = '.dzfdyzt';
}
if ($_GET['mp3'] == '1') {
	$filtermp3 = '.mp3';
} else {
	$filtermp3 = '.dzfdyzt';
}
if ($_GET['mp4'] == '1') {
	$filtermp4 = '.mp4';
} else {
	$filtermp4 = '.dzfdyzt';
}
if ($_GET['m4a'] == '1') {
	$filterm4a = '.m4a';
} else {
	$filterm4a = '.dzfdyzt';
}
if (!(empty($_GET['m4v']))) {
	if ($_GET['m4v'] == 'true')	{
		$filterm4v = '.m4v';
	} else {
		$filterm4v = '.dzfdyzt';
	}
} else {
	$filterm4v = '.dzfdyzt';
}
if ($_GET['mov'] == '1') {
	$filtermov = '.mov';
} else {
	$filtermov = '.dzfdyzt';
}

// Directory to scan for files
$directory = "../../".$_GET['dir'];

//websiteurl
$url = $_GET['url'].$_GET['dir'];

// Sort type
$sort = base64_decode($_GET['sor']);
if ($sort == 'asort' || $sort == 'arsort' || $sort == 'shuffle') {
	$file_print = 'filesize';
} else {
	$file_print = 'filemtime';
}
//Scan the directory and filter files to an array
$scan_result = dir($directory);
$items = array();
if ($scan_result != '') {
	while($entry = $scan_result->read()) {
		$length = ((strlen($entry)) - 4);
		$condition = (($length === (strpos(strtolower($entry), $filterflv))) || ($length === (strpos(strtolower($entry), $filtermp3))) || ($length === (strpos(strtolower($entry), $filtermp4))) || ($length === (strpos(strtolower($entry), $filterm4a))) || ($length === (strpos(strtolower($entry), $filterm4v))) || ($length === (strpos(strtolower($entry), $filtermov))) || ($length === (strpos(strtolower($entry), $filterjpg))) || ($length === (strpos(strtolower($entry), $filterpng))) || ($length === (strpos(strtolower($entry), $filtergif))) || ($length === (strpos(strtolower($entry), $filtersrt))) || ($length === (strpos(strtolower($entry), $filterxml))) );
		if ($condition === true) {
			$date = $file_print($directory.$entry);
			$items[$date] = $entry;
		}
	}
	$scan_result->close();
	// Sort
	$sort($items);
}

//xml header and opening tags
header("content-type:text/xml;charset=utf-8");

echo <<<END
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:jwplayer="http://developer.longtailvideo.com/trac/wiki/FlashFormats">
<channel>
END;

//Loop through the array
foreach ($items as $value) {

	//link
	if ($_GET['li'] == '1')	{
		$link = $url.$value;
	} else {
		$link = '';
	}

	//Search if there is audio/video file with thumbnail associate
	$value2 = substr($value, 0, strlen($value) - 4);// remove file extension
	if (in_array($value2.$filterjpg, $items)) {
	    $value3 = $url.$value2.$filterjpg;
	} else if (in_array($value2.$filterpng, $items)) {
	    $value3 = $url.$value2.$filterpng;
	} else if (in_array($value2.$filtergif, $items)) {
	    $value3 = $url.$value2.$filtergif;
	} else {
		$value3 = $_GET['thu'];
	}
	
	//Search if there is  audio/video file with caption associate
	if (in_array($value2.$filterxml, $items)) {
	    $value4 = $url.$value2.$filterxml;
	} else if (in_array($value2.$filtersrt, $items)) {
	    $value4 = $url.$value2.$filtersrt;
	} else {
		$value4 = "";
	}
	// Select what type of filter for title, author, description.
	if ($_GET['tyt'] == "1") {
		//Filter occurence for title, author, description.
		$title1 = substr($value, 0, strlen($value) - 4);// remove file extension
		$analyse = explode($_GET['sep'], $title1);
		if (empty($analyse[$_GET['tp']])) {
			$title = '';
		} else {
			$title = $analyse[$_GET['tp']];
			$title = preg_replace('#_#', ' ', $title); // change underscores to spaces
			$title = preg_replace('#%20#', ' ', $title); // change %20 to spaces
			$title = preg_replace('#%26#', '&', $title); // change %26 to &
			$title = ucfirst($title); // capitalize first letter of first words
		}
		if (empty($analyse[$_GET['ap']])) {
			$author = '';
		} else {
			$author = $analyse[$_GET['ap']];
			$author = preg_replace('#_#', ' ', $author); // change underscores to spaces
			$author = preg_replace('#%20#', ' ', $author); // change %20 to spaces
			$author = preg_replace('#%26#', '&', $author); // change %26 to &
			$author = ucfirst($author); // capitalize first letter of first words
		}
		if (empty($analyse[$_GET['dp']])) {
			$description1 = '';
		} else {
			$description1 = $analyse[$_GET['dp']];
			$description1 = preg_replace('#_#', ' ', $description1); // change underscores to spaces
			$description1 = preg_replace('#%20#', ' ', $description1); // change %20 to spaces
			$description1 = preg_replace('#%26#', '&', $description1); // change %26 to &
			$description1 = ucfirst($description1); // capitalize first letter of first words
		}
		if (empty($analyse[$_GET['trp']])) {
			$track = '';
		} else {
			$track = $analyse[$_GET['trp']];
			$track = preg_replace('#_#', '', $track); // change underscores to none
			$track = preg_replace('#%20#', '', $track); // change %20 to none
		}
		if ($_GET['tdes'] == "0") {
			$description = $description1;
		} else if ($_GET['tdes'] == "1") {
			$description = $author." ".$description1;
		} else if ($_GET['tdes'] == "2") {
			$description = $author." ".$title." ".$description1;
		} else {
			$description = $track." ".$author." ".$title." ".$description1;
		}
	} else {
		//Chop off the extension to create the title, author, description.
		$title = substr($value, 0, strlen($value) - 4);// remove file extension
		$title = preg_replace('#_#', ' ', $title); // change underscores to spaces
		$title = preg_replace('#%20#', ' ', $title); // change %20 to spaces
		$title = preg_replace('#%26#', '&', $title); // change %26 to &
		$title = ucfirst($title); // capitalize first letter of first words
		$author = $title;
		$description = $title;
	}
	// Assigne duration for image file
	if (strpos(strtolower($value), $filterjpg) || strpos(strtolower($value), $filterpng) || strpos(strtolower($value), $filtergif)) {
		$duration = $_GET['dur'];
	} else {
		$duration = "";
	}

	//search if there is picture file associate with audio/video file and display if not
	if (!((strpos(strtolower($value), $filterjpg) || strpos(strtolower($value), $filterpng) || strpos(strtolower($value), $filtergif)) && (in_array($value2.$filtermp3, $items) || in_array($value2.$filtermp4, $items) || in_array($value2.$filtermov, $items) || in_array($value2.$filterflv, $items) || in_array($value2.$filterm4a, $items) || in_array($value2.$filterm4v, $items)))) {
		if (!((strpos(strtolower($value), $filterjpg) && ($_GET['jpg'] == '0')) || (strpos(strtolower($value), $filterpng) && ($_GET['png'] == '0')) || (strpos(strtolower($value), $filtergif) && ($_GET['gif'] == '0')))) {
			//search if there is caption file associate with audio/video file and not display if not
			if (!($value4 == $url.$value)) {
				echo "\n\t<item>\n";
				if (!(empty($title))) {
					echo "\t\t<title>".$title."</title>\n";
				}
				if (!(empty($description)))	{
					echo "\t\t<description>".$description."</description>\n";
				}
				if (!(empty($author))) {
					echo "\t\t<media:credit role=\"author\">".$author."</media:credit>\n";
				}
				echo "\t\t<media:content url=\"".$url.$value."\"";
				if (!(empty($duration))) {
					echo" duration=\"".$duration."\" />\n";
				} else {
					echo" />\n";
				}
				if (!(empty($value3))) {
					echo "\t\t<media:thumbnail url=\"".$value3."\" />\n";
				}
				if (!(empty($value4))) {
					echo "\t\t<jwplayer:captions>".$value4."</jwplayer:captions>\n";
				}
				if (!(empty($link))) {
					echo "\t\t<link>".$link."</link>\n";
				}
				echo "\t</item>\n";
			}
		}
	}
}
//Closing tags
echo <<<END
</channel>
</rss>
END;
?>