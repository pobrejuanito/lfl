<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/resultScale.base.php';

class resultscale_updateAriPage extends resultScaleAriPage
{
	function execute()
	{
		$this->setTitle(
			AriWebHelper::translateResValue('Title.ResultScale') . ' : ' . AriWebHelper::translateResValue('Label.UpdateItem'));
		
		$scaleId = $this->_getScaleId();
		
		$this->addVar('scaleId', $scaleId);
			
		parent::execute();
	}
	
	function _getScale()
	{
		if (is_null($this->_scale))
		{
			$this->_scale = $this->_scaleController->call('getScale', $this->_getScaleId());
		}
		
		return $this->_scale;
	}
	
	function _getScaleId()
	{
		return @intval(AriRequest::getParam('scaleId', 0), 10);
	} 
}
?>