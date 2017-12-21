<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.ResultController');
AriKernel::import('Components.AriQuiz.Util');
AriKernel::import('Web.Controls.ListBox');

class resultsAriPage extends AriAdminSecurePageBase 
{
	var $_resultController;
	var $_lbFilterQuiz;
	var $_lbFilterUser;
	var $_filter;
	var $_quizId;
	var $_persistanceKey = 'dtResults';

	function _init()
	{
		$this->_resultController = new AriQuizResultController();
		$this->_quizId = AriRequest::getParam('quizId', 0);
		
		parent::_init();
	}
	
	function execute()
	{
		$dataTable = $this->_createDataTable($this->_quizId);
		
		$this->_bindFilters();
		
		$this->addVar('dataTable', $dataTable);
		$this->addVar('quizId', $this->_quizId);

		$this->setResTitle('Title.QuizResultList');

		parent::execute();
	}
	
	function _createDataTable($quizId)
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getResults&quizId=' . $quizId;		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'StatisticsInfoId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Quiz'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuiz')),
			new AriDataTableControlColumn(array('key' => 'Name', 'label' => AriWebHelper::translateResValue('Label.User'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatUser')),
			new AriDataTableControlColumn(array('key' => 'Login', 'label' => AriWebHelper::translateResValue('Label.Login'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatUser')),
			new AriDataTableControlColumn(array('key' => 'Email', 'label' => AriWebHelper::translateResValue('Label.Email'), 'sortable' => true/*, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatUser'*/)),
			new AriDataTableControlColumn(array('key' => 'StartDate', 'label' => AriWebHelper::translateResValue('Label.StartDate'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatUtcToLocal')),
			new AriDataTableControlColumn(array('key' => 'EndDate', 'label' => AriWebHelper::translateResValue('Label.EndDate'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatUtcToLocal')),
			new AriDataTableControlColumn(array('key' => 'UserScore', 'label' => '', 'hidden' => true)),
			new AriDataTableControlColumn(array('key' => 'MaxScore', 'label' => '', 'hidden' => true)),
			//new AriDataTableControlColumn(array('key' => 'PercentScore', 'label' => '', 'hidden' => true)),
			new AriDataTableControlColumn(array('key' => 'PercentScore',  'label' => AriWebHelper::translateResValue('Label.Score'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatResultScore', 'className' => 'dtNoWrap dtCenter')),
			new AriDataTableControlColumn(array('key' => 'Passed', 'label' => AriWebHelper::translateResValue('Label.Passed'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatPassed', 'className' => 'dtCenter')),
			new AriDataTableControlColumn(array('key' => 'QuizId',  'label' => '', 'hidden' => true)),
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.Details'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatResultDetails', 'className' => 'dtNoWrap dtCenter')),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('tohtml', 'clickToHtml');
		$this->_registerEventHandler('toword', 'clickToWord');
		$this->_registerEventHandler('toexcel', 'clickToExcel');
		$this->_registerEventHandler('tocsv', 'clickToCSV');
	}
	
	function clickToCSV($eventArgs)
	{
		$statisticsId = AriRequest::getParam('StatisticsInfoId', array());

		$result = $this->_resultController->call('getCSVView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.csv'));
		exit();
	}
	
	function clickToHtml($eventArgs)
	{
		$statisticsId = AriRequest::getParam('StatisticsInfoId', array());

		$result = $this->_resultController->call('getHtmlView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.html'));
		exit();
	}
	
	function clickToWord($eventArgs)
	{
		$statisticsId = AriRequest::getParam('StatisticsInfoId', array());

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
		$statisticsId = AriRequest::getParam('StatisticsInfoId', array());

		$result = $this->_resultController->call('getExcelView', $statisticsId,
			array('Anonymous' => AriWebHelper::translateResValue('Label.Guest'),
			'Passed' => AriWebHelper::translateResValue('Label.Passed'),
			'NoPassed' => AriWebHelper::translateResValue('Label.NoPassed')),
			AriQuizUtils::getShortPeriods());
		AriResponse::sendContentAsAttach($result,
			sprintf('result.xls'));
		exit();
	}

	function _getQuizList()
	{
		$quizList = $this->_resultController->call('getFinishedQuizList');
		
		return $quizList;
	}
	
	function _getUserList()
	{
		$userList = $this->_resultController->call('getFinishedUserList', $this->_quizId, true, array('Anonymous' => AriWebHelper::translateResValue('Label.Guest')));

		return $userList;
	}
	
	function _createControls()
	{
		$this->_lbFilterQuiz =& new AriListBoxWebControl('lbFilterQuiz');

		$this->_lbFilterUser =& new AriListBoxWebControl('lbFilterUser');

		$this->_filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'StartDate', 'dir' => 'desc'), 
			false, 
			'dtResults');
		$this->_filter->restore();

		$this->_bindControls();
	}
	
	function _bindFilters()
	{
		$filterPredicates = $this->_filter->getConfigValue('filter');

		if (isset($filterPredicates['QuizId'])) $this->_lbFilterQuiz->setSelectedValue($filterPredicates['QuizId']);
		$this->_lbFilterUser->setSelectedValue(isset($filterPredicates['UserId']) ? $filterPredicates['UserId'] : -1);
		
		$startDate = !empty($filterPredicates['StartDate']) ? $filterPredicates['StartDate'] : null;
		$endDate = !empty($filterPredicates['EndDate']) ? $filterPredicates['EndDate'] : null;
		
		$this->addVar('startDate', $startDate);
		$this->addVar('endDate', $endDate);
	}
	
	function _bindControls()
	{
		if (empty($this->_quizId))
		{
			$this->_lbFilterQuiz->setEmptyRow(AriWebHelper::translateResValue('Label.AllQuiz'), 0);
			$this->_lbFilterQuiz->dataBind($this->_getQuizList(), 'QuizName', 'QuizId');
		}
		else
		{
			$this->_lbFilterQuiz->setVisible(false);
		}
		
		$this->_lbFilterUser->setEmptyRow(AriWebHelper::translateResValue('Label.AllUser'), -1);
		$this->_lbFilterUser->dataBind($this->_getUserList(), 'Name', 'Id');
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getResults', 'ajaxGetResults');
		$this->_registerAjaxHandler('filters', 'ajaxFilters');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
		$this->_registerAjaxHandler('deleteAll', 'ajaxDeleteAll');
	}
	
	function ajaxDeleteAll()
	{
		$result = ($this->_resultController->call('deleteAllResult') && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxDelete()
	{
		$result = ($this->_resultController->call('deleteResult', AriRequest::getParam('StatisticsInfoId', array())) && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxFilters()
	{	
		$this->loadControls();
		$filterPredicates = array('QuizId' => $this->_lbFilterQuiz->getSelectedValue(),
			'UserId' => $this->_lbFilterUser->getSelectedValue());

		$startDate = intval(AriRequest::getParam('hidStartDate'), 10);
		$endDate = intval(AriRequest::getParam('hidEndDate'), 10);
		
		if ($startDate > 0)
		{
			$dateInfo = getdate($startDate);
			$filterPredicates['StartDate'] = mktime(0, 0, 1, $dateInfo['mon'], $dateInfo['mday'], $dateInfo['year']);
		}
			
		if ($endDate > 0)
		{
			$dateInfo = getdate($endDate);
			$filterPredicates['EndDate'] = mktime(23, 59, 59, $dateInfo['mon'], $dateInfo['mday'], $dateInfo['year']);
		}
		
		$filter =& $this->_filter;
		$filter->setConfigValue('filter', $filterPredicates);
		$filter->store();

		AriResponse::sendJsonResponse(true);
	}
	
	function ajaxGetResults()
	{
		$quizId = @intval(AriRequest::getParam('quizId', 0), 10);
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'StartDate', 'dir' => 'desc'), 
			true, 
			$this->_persistanceKey);

		$totalCnt = $this->_resultController->call('getResultsCount', $quizId, null, $filter);
		$filter->fixFilter($totalCnt);

		$results = $this->_resultController->call('getResults', $quizId, null, $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($results, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>