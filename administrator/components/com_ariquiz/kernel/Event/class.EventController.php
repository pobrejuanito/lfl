<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriEventController extends AriObject
{
	function raiseEvent($event, $params)
	{
		$params = array($params);
		$mainframe =& JFactory::getApplication('site');
		$mainframe->triggerEvent($event, $params);
	}
}
?>