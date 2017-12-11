<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('TextTemplates.TextTemplateController');
AriKernel::import('Controllers.FileController');

class templatesAriPage extends AriAdminSecurePageBase 
{
	var $_fileController;
	var $_persistanceKey = 'dtCssTemplates';
	
	function _init()
	{
		$this->_fileController = new AriFileController();
		
		parent::_init();
	}
	
	function execute()
	{
		$dataTable = $this->_createDataTable();
		
		$this->addVar('dataTable', $dataTable);

		$this->setResTitle('Title.TemplateList');
		
		parent::execute();
	}
	
	function _createDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getCssList';		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'FileId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'ShortDescription', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatCssTemplate')),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}

	function _clearCacheFiles($fileIdList)
	{
		global $option; 
		
		if (!empty($fileIdList) && is_array($fileIdList))
		{
			$cssGroup = AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName());
			foreach ($fileIdList as $id)
			{
				$id = intval($id, 10);
				@unlink(JPATH_ROOT . '/administrator/components/' . $option . '/cache/files/' . $cssGroup . '/' . $id . '.css');
			}
		}
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getCssList', 'ajaxGetCssList');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
	}
	
	function ajaxDelete($eventArgs)
	{
		$fileIdList = AriRequest::getParam('FileId', array());
		$result = ($this->_fileController->call('deleteFile', $fileIdList, AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName())) && !$this->_isError());
		if ($result)
		{
			$this->_clearCacheFiles($fileIdList);
		}
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxGetCssList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'ShortDescription', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$group = AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName());
		$totalCnt = $this->_fileController->call('getFileCount', $group, null, $filter);
		$filter->fixFilter($totalCnt);

		$templates = $this->_fileController->call('getFileList', $group, null, false, $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($templates, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>