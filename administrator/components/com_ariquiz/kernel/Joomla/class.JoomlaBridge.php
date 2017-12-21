<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriJoomlaBridge extends AriObject
{	
	function getLink($link, $xhtml = false, $clearItemId = true, $addTmpl = true)
	{
		$app = &JFactory::getApplication();
		$router = &$app->getRouter();
		// Hack
		if($router->getMode() == JROUTER_MODE_SEF && $clearItemId) 
		{
			$itemidPos = strpos($link, 'Itemid');
			if ($itemidPos !== false)
			{
				$link = preg_replace('/Itemid(?:=[^&;]*)?/', '', $link);
			}
		}
		
		if ($addTmpl && strpos($link, 'tmpl=') === false)
		{
			$tmpl = AriRequest::getParam('tmpl');
			if ($tmpl)
			{
				if (strpos($link, '&') !== false) $link .= '&';
				else if (strpos($link, '?') === false) $link .= '?';

				$link .= 'tmpl=' . $tmpl;
			}
		}
		$link = JRoute::_($link, $xhtml);
		
		return $link;
	}
	
	function doCompatibility()
	{    	
	    	// permissions
	    	$acl =& JFactory::getACL();
	    	$GLOBALS['acl'] =& $acl;
	}
	
	function isAdmin()
	{
		$mainframe =& JFactory::getApplication();
		
		return $mainframe->isAdmin();
	}
	
	function loadOverlib()
	{
		JHTML::_('behavior.tooltip');
	}
	
	function toolTip($tooltip, $title = '', $width = '', $image = 'tooltip.png', $text = '', $href = '', $link = 1)
	{
		static $init;
		if (!$init)
		{
			JHTML::_('behavior.tooltip');
			$init = true;
		}

		return JHTML::_('tooltip', $tooltip, $title, $image, $text, $href, $link);			
	}
	
	function sendMail($from, $fromname, $recipient, $subject, $body, $mode = 0, $cc = null, $bcc = null, $attachment = null, $replyto = null, $replytoname = null)
	{
		if ($recipient && is_string($recipient)) 
			$recipient = explode(';', $recipient);

		return JUTility::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname);
	}
	
	function getDate($date)
	{
		return $date;
	}
}

AriJoomlaBridge::doCompatibility();
?>