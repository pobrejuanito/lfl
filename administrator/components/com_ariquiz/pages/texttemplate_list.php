<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('TextTemplates.TextTemplateController');

class texttemplate_listAriPage extends AriAdminSecurePageBase
{	
	var $_persistanceKey = 'dtTextTemplates';
	
	function execute()
	{
		$dataTable = $this->_createDataTable();
		
		$this->setResTitle('Title.TemplateList');
		$this->addVar('dataTable', $dataTable);

		parent::execute();
	}
	
	function _createDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getTextTemplateList';		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'TemplateId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'TemplateName', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatTextTemplate')),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getTextTemplateList', 'ajaxGetTextTemplateList');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
	}
	
	function ajaxDelete()
	{
		$templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
		$result = ($templateController->call(
			'deleteTemplate', 
			AriRequest::getParam('TemplateId', 0), 
			AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName())) && !$this->_isError());
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxGetTextTemplateList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'TemplateName', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$entityKey = AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName());
		$templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
		$totalCnt = $templateController->call('getTemplateCount', $entityKey, $filter);
		$filter->fixFilter($totalCnt);

		$templates = $templateController->call('getTemplateList', $entityKey, $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($templates, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>