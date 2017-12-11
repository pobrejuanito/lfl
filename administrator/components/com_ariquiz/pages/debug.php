<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminPageBase');

class debugAriPage extends AriAdminPageBase
{
	function execute()
	{
		$dbDate = $this->getDbUTCDate();
		$phpDate = ArisDate::getDbUTC();
		
		$this->addVar('dbDate', $dbDate);
		$this->addVar('phpDate', $phpDate);
		
		$this->setTitle('Debug');
		
		parent::execute();
	}
	
	function getDbUTCDate()
	{
		$database =& JFactory::getDBO();
		
		$query = 'SELECT UNIX_TIMESTAMP(UTC_TIMESTAMP())';
		$database->setQuery($query);
		$ts = $database->loadResult();
		
		return date('Y-m-d H:i:s', $ts);
	}
}
?>