<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.QuestionBankController');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Controllers.AriQuiz.QuestionBankCategoryController');
AriKernel::import('Controllers.AriQuiz.QuestionController');
AriKernel::import('Controllers.AriQuiz.CSVQuestionImportController');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');

class bankAriPage extends AriAdminSecurePageBase
{
	var $VG_IMPORT_DIR = 'ImportDir';
	var $VG_IMPORT_UPLOAD = 'ImportUpload';
	
	var $_tbxImportDir;
	var $_bankController;
	var $_bankCategoryContoller;
	var $_lbFilterCategory;
	var $_lbMassQuestionCategory;
	var $_filter;
	var $_persistanceKey = 'dtBank';
	
	var $_questionCategories;
	
	function _init()
	{
		$this->_bankController = new AriQuizQuestionBankController();
		$this->_bankCategoryContoller = new AriQuizQuestionBankCategoryController();

		parent::_init();
	}
	
	function execute()
	{
		$dataTable = $this->_createDataTable();
		
		$this->_bindFilters();
		
		$this->setResTitle('Title.Bank');
		$this->addVar('dataTable', $dataTable);		
		
		parent::execute();
	}
	
	function _createDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getBankList';		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionId', 'label' => AriWebHelper::translateResValue('Label.ID'), 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'Question', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatBankQuestions')),
			new AriDataTableControlColumn(array('key' => 'QuestionType', 'label' => AriWebHelper::translateResValue('Label.QuestionType'), 'sortable' => true)),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.BankCategory'), 'sortable' => true))
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}

	function _getCategoryList()
	{
		if (is_null($this->_questionCategories))
		{
			$categoryList = $this->_bankCategoryContoller->call('getCategoryList');
			if (is_null($categoryList)) $categoryList = array();
			
			$this->_questionCategories = $categoryList;
		}

		return $this->_questionCategories;
	}
	
	function _createControls()
	{
		$this->_lbFilterCategory =& new AriListBoxWebControl('lbFilterCategory');
			
		$this->_filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'Question', 'dir' => 'asc'), 
			false,
			'dtBank');
		$this->_filter->restore();
		
		$this->_lbMassQuestionCategory =& new AriListBoxWebControl('lbMassQuestionCategories',
			array('name' => 'lbMassQuestionCategories'));
			
		$this->_tbxImportDir =& new AriTextBoxWebControl('tbxImportDir');
		
		$this->_bindControls();
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvImportDir',
			array('controlToValidate' => 'tbxImportDir', 'errorMessageResourceKey' => 'Validator.ImportDirRequired', 'groups' => array($this->VG_IMPORT_DIR)));
	}
	
	function _bindFilters()
	{
		$filterPredicates = $this->_filter->getConfigValue('filter');

		if (isset($filterPredicates['CategoryId'])) $this->_lbFilterCategory->setSelectedValue($filterPredicates['CategoryId']);
	}

	function _bindControls()
	{
		$this->_tbxImportDir->setText(JPATH_ROOT);
		
		$this->_lbFilterCategory->setEmptyRow(AriWebHelper::translateResValue('Label.AllCategory'), -1);
		$this->_lbFilterCategory->dataBind($this->_getCategoryList(), 'CategoryName', 'CategoryId');
		$this->_lbFilterCategory->setSelectedValue(-1);
		
		$this->_lbMassQuestionCategory->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassQuestionCategory->dataBind($this->_getCategoryList(), 'CategoryName', 'CategoryId');
		$this->_lbMassQuestionCategory->setSelectedValue(-1);
	}

	function _registerEventHandlers()
	{
		$this->_registerEventHandler('uploadCSVImport', 'clickUploadCSVImport');
		$this->_registerEventHandler('csvImportFromDir', 'clickCSVImportFromDir');
	}
	
	function clickUploadCSVImport()
	{
		$file = AriUtils::getFilteredParam($_FILES, 'importDataCSVFile', null);
		$fileName = null;
		if (!empty($file) && $file['size'] > 0)
		{
			$fileName = $file['tmp_name'];
		}
		
		$this->_CSVImport($fileName);
	}
	
	function clickCSVImportFromDir()
	{
		$exportFile = $this->_tbxImportDir->getText();
		
		$this->_CSVImport($exportFile);
	}
	
	function _CSVImport($csvFile)
	{
		$my =& JFactory::getUser();		
		$csvImporter = new AriQuizCSVQuestionImportController();
		$result = $csvImporter->importBankQuestions(
			$csvFile,
			$my->get('id'));
		
		$msgId = $result
			? 'Complete.DataImport'
			: 'Complete.DataImportFailed';
		AriResponse::redirect('index.php?option=' . AriQuizComponent::getCodeName() . '&task=bank&arimsg=' . $msgId);
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('filters', 'ajaxFilters');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
		$this->_registerAjaxHandler('getBankList', 'ajaxGetBankList');
		$this->_registerAjaxHandler('massEdit', 'ajaxMassEdit');
	}
	
	function ajaxMassEdit()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');

		$score = AriRequest::getParam('tbxMassScore');
		if (!is_null($score)) $score = intval($score, 10);		
		
		$categoryId = AriRequest::getParam('lbMassQuestionCategories');
		if (!is_null($categoryId)) $categoryId = intval($categoryId, 10);

		$qc = new AriQuizQuestionController();
		$result = $qc->call('updateQuestion',
			AriRequest::getParam('QuestionId', null),
			$score,
			$categoryId,
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxFilters($eventArgs)
	{
		$this->loadControls();
		$categoryId = AriRequest::getParam('lbFilterCategory', null);
		if (!is_null($categoryId))
		{
			if ($categoryId < 0) $categoryId = null;
			$filterPredicates = array('CategoryId' => $categoryId);
		}

		$filter =& $this->_filter;
		$filter->setConfigValue('filter', $filterPredicates);
		$filter->store();
		
		AriResponse::sendJsonResponse(true);
	}
	
	function ajaxDelete($eventArgs)
	{
		$result = ($this->_bankController->call('deleteQuestion', AriRequest::getParam('QuestionId', 0)) && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxGetBankList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'Question', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$totalCnt = $this->_bankController->call('getQuestionCount', $filter);
		$filter->fixFilter($totalCnt);

		$questions = $this->_bankController->call('getQuestionList', $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>