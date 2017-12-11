<?php
/**
 *Jw Player Plugin Advanced : plg_jwadvanced
 * @version plg_jwadvanced$Id$
 * @package plg_jwadvanced
 * @subpackage default.php
 * @author joomlarulez.
 * @copyright (C) www.joomlarulez.com
 * @license Limited  http://www.gnu.org/licenses/gpl.html
 * final 1.13.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if ( preg_match('/tvstream/',$is_plgplayer_flashvars['streamer']) ) {
    $file = "http://tvdown.sostvnetwork.com/".$is_plgplayer_flashvars['file'];
    $hdfile = "http://tvdown.sostvnetwork.com/".$is_plgplayer_flashvars['hd.file'];
} else {
    $file = "http://netdown.sostvnetwork.com/".$is_plgplayer_flashvars['file'];
    $hdfile = "http://netdown.sostvnetwork.com/".$is_plgplayer_flashvars['hd.file'];
}
$return .= '<div id="jwplayer'.$pluginclasspl_sfx.'">Loading the player...</div>';
$return .= '<script type="text/javascript">';
$return .= 'jQuery(document).ready(function($) {';
$return .= "jwplayer('jwplayer".$pluginclasspl_sfx."').setup({
                'primary':'html5',
                'sources': [{
                    'file': '".$file."',
                    'label': 'SD'
                 }";
if ( $$is_plgplayer_flashvars['hd.file'] != "" ) {
$return .=       ",{
                    'file': '".$hdfile."',
                    'label': 'HD'
                 }";
}
$return .=      "],   
                'image': '/templates/yoo_umag/images/lighthouse.jpg',
                'width': '100%',
                'height':'450'
            });";
$return .= '});';
$return .= '</script>';
//  return
return $return . '<div id="jwplayerid" playerid="jwplayer'.$pluginclasspl_sfx.'" style="display: none"></div>';
