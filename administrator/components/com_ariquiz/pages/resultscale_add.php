<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/resultScale.base.php';

class resultscale_addAriPage extends resultScaleAriPage
{
	function _init()
	{
		$this->_updateTask = 'resultscale_update';
		
		parent::_init();
	}
	
	function execute()
	{
		$this->setTitle(
			AriWebHelper::translateResValue('Title.ResultScale') . ' : ' . AriWebHelper::translateResValue('Label.AddItem'));
		
		parent::execute();
	}	
}
?>