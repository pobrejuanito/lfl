<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Toolbar.ToolbarFactory');

class AriToolbar extends AriObject
{
	var $_toolbar = null;
	
	function __construct()
	{
		$this->_toolbar = AriToolbarFactory::createInstance();
	}
	
	function showToolbar($task)
	{
		if (!empty($task) && method_exists($this, $task . 'Toolbar'))
		{
			$task .= 'Toolbar';
			$this->$task();
		}
	}
}
?>