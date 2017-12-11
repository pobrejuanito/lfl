<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.ResultController');
AriKernel::import('TextTemplates.TextTemplateController');
AriKernel::import('Components.AriQuiz.Util');
AriKernel::import('Web.Controls.ListBox');

class resultAriPage extends AriAdminSecurePageBase 
{
	var $_resultController;
	var $_lbTextTemplates;
	var $_persistanceKey = 'dtQuizResult';
	
	function _init()
	{
		$this->_resultController = new AriQuizResultController();
		
		parent::_init();
	}

	function execute()
	{
		$quizId = AriRequest::getParam('quizId', 0);
		$statisticsInfoId = AriRequest::getParam('statisticsInfoId', 0);
		$dataTable = $this->_createDataTable($statisticsInfoId);
		
		$this->_bindControls();
		
		$this->addVar('quizId', $quizId);
		$this->addVar('statisticsInfoId', $statisticsInfoId);
		$this->addVar('dataTable', $dataTable);

		$this->setResTitle('Title.Result');
		
		parent::execute();
	}
	
	function _createDataTable($statisticsInfoId)
	{
		global $option;

		$resultController = new AriQuizResultController();
		$totalCnt = $resultController->call('getStatCount', $statisticsInfoId);
		
		$rowsPerPage = array(1);
		if ($totalCnt > 1)
		{
			$pageCnt = floor($totalCnt / 5);
			for ($i = 0; $i < $pageCnt; $i++)
			{
				$rowsPerPage[] = 5 * ($i + 1); 
			}
			
			if ($totalCnt % 5 > 0) $rowsPerPage[] = $totalCnt;
		}
		$pagRowsPerPage = $totalCnt < 5 ? $totalCnt : 5; 

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQuizResultList&statisticsInfoId=' . $statisticsInfoId;

		$columns = array(
			new AriDataTableControlColumn(array('key' => 'QuestionData', 'label' => AriWebHelper::translateResValue('Label.QuizStatistics'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuestionStatData')),
			new AriDataTableControlColumn(array('key' => 'QuestionIndex', 'label' => '', 'hidden' => true)),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl),
			array('rowsPerPageOptions' => $rowsPerPage, 'rowsPerPage' => $pagRowsPerPage));

		return $dataTable;
	}
	
	function _getTextTemplateList()
	{
		$templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
		$templateList = $templateController->call('getTemplateList', AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName()));

		return $templateList;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('tohtml', 'clickToHtml');
		$this->_registerEventHandler('toword', 'clickToWord');
		$this->_registerEventHandler('toexcel', 'clickToExcel');
		$this->_registerEventHandler('tocsv', 'clickToCSV');
	}
	
	function clickToHtml($eventArgs)
	{
		$statisticsId = AriRequest::getParam('statisticsInfoId', array());

		$result = $this->_resultController->call('getHtmlView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.html'));
		exit();
	}
	
	function clickToCSV($eventArgs)
	{
		$statisticsId = AriRequest::getParam('statisticsInfoId', array());

		$result = $this->_resultController->call('getCSVView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.csv'));
		exit();
	}
	
	function clickToWord($eventArgs)
	{
		$statisticsId = AriRequest::getParam('statisticsInfoId', array());

		$result = $this->_resultController->call('getWordView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.doc'));
		exit();
	}
	
	function clickToExcel($eventArgs)
	{
		$statisticsId = AriRequest::getParam('statisticsInfoId', array());

		$result = $this->_resultController->call('getExcelView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.xls'));
		exit();
	}
	
	function _createControls()
	{
		$this->_lbTextTemplates =& new AriListBoxWebControl('lbTextTemplates');
	}
	
	function _bindControls()
	{
		$this->_lbTextTemplates->dataBind($this->_getTextTemplateList(), 'TemplateName', 'TemplateId');
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getQuizResultList', 'ajaxGetQuizResultList');
	}

	function ajaxGetQuizResultList()
	{
		$sid = AriRequest::getParam('statisticsInfoId', 0);		
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 5, 'sortField' => 'QuestionIndex', 'dir' => 'asc'), 
			true,
			$this->_persistanceKey,
			array('QuestionIndex'));

		$totalCnt = $this->_resultController->call('getStatCount', $sid, $filter);
		if ($totalCnt < $filter->getConfigValue('limit')) $filter->setConfigValue('limit', $totalCnt);
		
		$filter->fixFilter($totalCnt);
		
		$questions = $this->_resultController->call('getJsonStatList', $sid, $filter, false);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>