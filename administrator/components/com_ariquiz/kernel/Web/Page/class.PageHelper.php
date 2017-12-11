<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriPageHelper extends AriObject 
{
	var $currentPage;
	
	function &getInstance()
	{
		static $instance = null;
		
		if (is_null($instance))
		{
			$instance = new AriPageHelper(); 
		}
		
		return $instance;
	}
	
	function setCurrentPage(&$page)
	{
		$this->currentPage =& $page;
	}
	
	function &getCurrentPage()
	{
		return $this->currentPage;
	}
}
?>