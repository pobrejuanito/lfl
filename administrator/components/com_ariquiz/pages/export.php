<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminPageBase');
AriKernel::import('Controllers.AriQuiz.QuizController');
AriKernel::import('Controllers.AriQuiz.QuestionBankCategoryController');
AriKernel::import('Controllers.AriQuiz.ExportController');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Web.Controls.ListBox');

class exportAriPage extends AriAdminPageBase
{
	var $_quizController;
	var $_exportController;
	var $_bankCategoryContoller;
	var $_lbQuizExportResults;
	var $_lbBankCategory;
	var $_profile;
	var $_profileId;

	function _init()
	{
		$this->_quizController = new AriQuizController();
		$this->_exportController = new AriQuizExportController();
		$this->_bankCategoryContoller = new AriQuizQuestionBankCategoryController();
		
		parent::_init();
	}
	
	function execute()
	{
		$this->setResTitle('Title.ExportData');
		$profile = $this->_getProfile();
		
		$this->_bindControls($profile);
		
		$queDataTable = $this->_createQuestionDataTable();
		$quizDataTable = $this->_createQuizDataTable();
		$availQuizDataTable = $this->_createAvailQuizDataTable();
		$availQueDataTable = $this->_createAvailQuestionDataTable();
		
		$this->addVar('profile', $profile);
		$this->addVar('quizDataTable', $quizDataTable);
		$this->addVar('queDataTable', $queDataTable);
		$this->addVar('availQuizDataTable', $availQuizDataTable);
		$this->addVar('availQueDataTable', $availQueDataTable);
		
		parent::execute();
	}
	
	function _createControls()
	{
		$this->_lbQuizExportResults =& new AriListBoxWebControl('lbQuizExportResults',
			array('name' => 'zProfile[ExportQuizResults]', 'translateText' => false));
			
		$this->_lbBankCategory =& new AriListBoxWebControl('lbBankCategories',
			array('name' => 'BankCategoryId'));
	}
	
	function _bindControls($profile)
	{	
		$ynList = $this->_getYesNoList();
		$this->_lbQuizExportResults->dataBind($ynList);
		$this->_lbQuizExportResults->setSelectedValue(AriUtils::getParam($profile, 'ExportQuizResults', true) ? 1 : 0);
		
		$this->_lbBankCategory->setEmptyRow(AriWebHelper::translateResValue('Label.AllCategory'), -1);
		$this->_lbBankCategory->dataBind($this->_getBankCategoryList(true), 'CategoryName', 'CategoryId');
		$this->_lbBankCategory->setSelectedValue(-1);
	}
	
	function _getBankCategoryList($addUncategory = false)
	{
		$categoryList = $this->_bankCategoryContoller->call('getCategoryList');
		if ($addUncategory)
		{
			if (empty($categoryList)) $categoryList = array();
			
			$uncategory = new stdClass();
			$uncategory->CategoryId = 0;
			$uncategory->CategoryName = AriWebHelper::translateResValue('Category.Uncategory');
			array_unshift($categoryList, $uncategory);
		}
		
		return $categoryList;
	}
	
	function _getYesNoList()
	{
		$list = array(0 => AriWebHelper::translateResValue('Label.No'), 1 => AriWebHelper::translateResValue('Label.Yes'));
		
		return $list;
	}
	
	function _createQuizDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQuizList&profileId=' . $this->_getProfileId();		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuiz')),
			new AriDataTableControlColumn(array('key' => 'ExportResults', 'label' => sprintf('<div><div id="phQuizMenu" style="float: right;"></div><div id="quizMenuToggler" class="aq-export-result-menu"> </div><div style="padding-right: 22px;">%s</div></div>', AriWebHelper::translateResValue('Label.ExportResults'), AriWebHelper::translateResValue('Label.Yes'), AriWebHelper::translateResValue('Label.No')), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatExportQuizResults', 'className' => 'dtCenter dtColMin')),
		);

		$dataTable = new AriMultiPageDataTableControl(
			'dtExportQuiz',
			$columns, 
			array('dataUrl' => $dsUrl),
			null);

		return $dataTable;
	}
	
	function _createAvailQuizDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getAvailQuizList&profileId=' . $this->_getProfileId();		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter', 'width' => 15)),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter', 'width' => 20)),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuiz', 'width' => 570)),
		);

		$dataTable = new AriMultiPageDataTableControl(
			'dtExportAvailQuiz',
			$columns, 
			array('dataUrl' => $dsUrl, 'width' => '685px', 'height' => '390px'),
			null,
			true,
			false);

		return $dataTable;
	}
	
	function _createQuestionDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQueList&profileId=' . $this->_getProfileId();		
		$columns = array(
			new AriDataTableControlColumn(array('key' => 'Num', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'Question', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatBankQuestions')),
			new AriDataTableControlColumn(array('key' => 'QuestionType', 'label' => AriWebHelper::translateResValue('Label.QuestionType'), 'sortable' => true)),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.Category'), 'sortable' => true))
		);

		$dataTable = new AriMultiPageDataTableControl(
			'dtExportQuestion',
			$columns, 
			array('dataUrl' => $dsUrl),
			null);

		return $dataTable;
	}
	
	function _createAvailQuestionDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getAvailQueList&profileId=' . $this->_getProfileId();
		$columns = array(
			new AriDataTableControlColumn(array('key' => 'Num', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter', 'width' => 15)),
			new AriDataTableControlColumn(array('key' => 'BankQuestionId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter', 'width' => 20)),
			new AriDataTableControlColumn(array('key' => 'Question', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatBankQuestions', 'width' => 429)),
			new AriDataTableControlColumn(array('key' => 'QuestionType', 'label' => AriWebHelper::translateResValue('Label.QuestionType'), 'sortable' => true, 'className' => 'dtCenter', 'width' => 130)),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.Category'), 'sortable' => true, 'width' => 220))
		);		

		$dataTable = new AriMultiPageDataTableControl(
			'dtExportAvailQue',
			$columns, 
			array('dataUrl' => $dsUrl, 'width' => '935px', 'height' => '390px'),
			null,
			true,
			false);

		return $dataTable;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('export', 'clickExport');
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getQuizList', 'ajaxGetQuizList');
		$this->_registerAjaxHandler('getAvailQuizList', 'ajaxGetAvailQuizList');
		$this->_registerAjaxHandler('addExportQuiz', 'ajaxAddExportQuiz');
		$this->_registerAjaxHandler('removeExportQuiz', 'ajaxRemoveExportQuiz');
		$this->_registerAjaxHandler('saveOptions', 'ajaxSaveOptions');
		$this->_registerAjaxHandler('getAvailQueList', 'ajaxGetAvailQueList');
		$this->_registerAjaxHandler('getQueList', 'ajaxGetQueList');
		$this->_registerAjaxHandler('addExportQue', 'ajaxAddExportQue');
		$this->_registerAjaxHandler('removeExportQue', 'ajaxRemoveExportQue');
	}
	
	function _getProfileId()
	{
		if (is_null($this->_profileId))
		{
			$profileId = @intval(AriRequest::getParam('profileId', 0), 10);
			if ($profileId < 1)
			{
				$profileId = $this->_exportController->call('getProfileIdByAlias', 'default');
			}
			
			$this->_profileId = $profileId;
		}

		return $this->_profileId;
	}
	
	function _getProfile()
	{
		if (is_null($this->_profile))
		{
			$this->_profile = $this->_exportController->call('getExportProfile', $this->_getProfileId());
		}
		
		return $this->_profile;
	}
	
	function clickExport($eventArgs)
	{
		$this->saveOptions();
		
		$dataConfigFile = AriUtils::resolvePath('administrator/components/' . AriQuizComponent::getCodeName() . '/config/data.xml');
		$exportData = $this->_exportController->call('getExportData',
			$this->_getProfileId(),
			$dataConfigFile,
			AriResponse::getEncoding());

		if ($exportData) $this->_exportController->call('clearSettings', $this->_getProfileId());
		AriResponse::sendContentAsAttach($exportData, 'export.xml');
	}
	
	function ajaxSaveOptions()
	{
		$result = $this->saveOptions();
		
		AriResponse::sendJsonResponse($result);
	}
	
	function saveOptions()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		$fields = AriWebHelper::translateRequestValues('zProfile');
		$profile = $this->_exportController->call('saveExportProfile',
			$this->_getProfileId(),
			$fields,
			$ownerId);
			
		if ($profile)
		{
			$exportResults = AriRequest::getParam('ExportResults');
			$this->_exportController->call('saveExportQuizResultSettings', 
				$profile->ProfileId,
				$exportResults);
		}
		
		return !is_null($profile);
	}
	
	function ajaxGetQuizList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'QuizName', 'dir' => 'asc'), 
			true);

		$totalCnt = $this->_exportController->call('getExportQuizCount',
			$this->_getProfileId(), 
			$filter);
		$filter->fixFilter($totalCnt);

		$quizzes = $this->_exportController->call('getExportQuizList',
			$this->_getProfileId(), 
			$filter);
		$data = AriMultiPageDataTableControl::createDataInfo($quizzes, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
	
	function ajaxGetAvailQuizList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'QuizName', 'dir' => 'asc'), 
			true);

		$totalCnt = $this->_exportController->call('getAvailableQuizCount',
			$this->_getProfileId(), 
			$filter);
		$filter->fixFilter($totalCnt);

		$quizzes = $this->_exportController->call('getAvailableQuizList',
			$this->_getProfileId(), 
			$filter);
		$data = AriMultiPageDataTableControl::createDataInfo($quizzes, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
	
	function ajaxGetQueList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'Question', 'dir' => 'asc'), 
			true);

		$totalCnt = $this->_exportController->call('getExportBankQuestionCount',
			$this->_getProfileId(), 
			$filter);
		$filter->fixFilter($totalCnt);

		$questions = $this->_exportController->call('getExportBankQuestionList',
			$this->_getProfileId(), 
			$filter);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
	
	function ajaxGetAvailQueList()
	{
		$categoryId = AriRequest::getParam('lbBankCategories', null);
		if (!is_null($categoryId))
		{
			$categoryId = @intval($categoryId, 10);
			if ($categoryId < 0) $categoryId = null;
		}
		
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'Question', 'dir' => 'asc',
				'filter' => array('CategoryId' => $categoryId)), 
			true);

		$totalCnt = $this->_exportController->call('getAvailableBankQuestionCount',
			$this->_getProfileId(), 
			$filter);
		$filter->fixFilter($totalCnt);

		$questions = $this->_exportController->call('getAvailableBankQuestionList',
			$this->_getProfileId(), 
			$filter);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
	
	function ajaxRemoveExportQuiz()
	{
		$result = $this->_exportController->call('deleteExportQuiz',
			$this->_getProfileId(), 
			AriRequest::getParam('QuizId', 0));
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxAddExportQuiz()
	{
		$result = $this->_exportController->call('addExportQuiz',
			$this->_getProfileId(), 
			AriRequest::getParam('QuizId', 0));
		
		AriResponse::sendJsonResponse($result);
	}

	function ajaxRemoveExportQue()
	{
		$result = $this->_exportController->call('deleteExportBankQuestion',
			$this->_getProfileId(), 
			AriRequest::getParam('QuestionId', 0));
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxAddExportQue()
	{
		$result = $this->_exportController->call('addExportBankQuestion',
			$this->_getProfileId(), 
			AriRequest::getParam('BankQuestionId', 0));
		
		AriResponse::sendJsonResponse($result);
	}
}
?>