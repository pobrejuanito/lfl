<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.QuizController');
AriKernel::import('Controllers.AriQuiz.QuestionController');
AriKernel::import('Controllers.AriQuiz.QuestionCategoryController');
AriKernel::import('Controllers.AriQuiz.QuestionBankController');
AriKernel::import('Controllers.AriQuiz.QuestionBankCategoryController');
AriKernel::import('Controllers.AriQuiz.CSVQuestionImportController');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');

class question_listAriPage extends AriAdminSecurePageBase
{
	var $VG_IMPORT_DIR = 'ImportDir';
	var $VG_IMPORT_UPLOAD = 'ImportUpload';

	var $_quizController;
	var $_questionController;
	var $_questionCategoryController;
	var $_bankController;
	var $_bankCategoryContoller;
	var $_persistanceKey = 'dtQuestions';
	var $_bankPersistanceKey = 'dtQuestionsBankQuestions';
	
	var $_tbxImportDir;
	var $_lbBankCategory;
	var $_lbQuestionCategory;
	var $_lbMassQuestionCategory;
	var $_lbCopyBankQuestionCategory;
	var $_lbCopyQuiz;
	var $_lbMoveQuiz;
	
	var $_questionCategories;
	var $_quizList;
	
	function _init()
	{
		$this->_quizController = new AriQuizController();
		$this->_questionController = new AriQuizQuestionController();
		$this->_questionCategoryController = new AriQuizQuestionCategoryController();
		$this->_bankController = new AriQuizQuestionBankController();
		$this->_bankCategoryContoller = new AriQuizQuestionBankCategoryController();
		
		parent::_init();
	}
	
	function _getQuizId()
	{
		return @intval(AriRequest::getParam('quizId', 0), 10);
	}
	
	function execute()
	{
		$quizId = $this->_getQuizId();

		$dataTable = $this->_createDataTable($quizId);
		$bankDataTable = $this->_createBankDataTable($quizId);
		
		$this->_bindControls();
		
		$this->setResTitle('Title.QuestionList');
		$this->addVar('dataTable', $dataTable);
		$this->addVar('bankDataTable', $bankDataTable);
		$this->addVar('quizId', $quizId);
		
		parent::execute();
	}
	
	function _createControls()
	{
		$this->_tbxImportDir =& new AriTextBoxWebControl('tbxImportDir');

		$this->_lbBankCategory =& new AriListBoxWebControl('lbBankCategories',
			array('name' => 'BankCategoryId'));
			
		$this->_lbQuestionCategory =& new AriListBoxWebControl('lbQuestionCategories',
			array('name' => 'lbQuestionCategories'));
			
		$this->_lbMassQuestionCategory =& new AriListBoxWebControl('lbMassQuestionCategories',
			array('name' => 'lbMassQuestionCategories'));
			
		$this->_lbCopyBankQuestionCategory =& new AriListBoxWebControl('lbCopyBankQuestionCategory',
			array('name' => 'lbCopyBankQuestionCategory'));
			
		$this->_lbCopyQuiz =& new AriListBoxWebControl('lbCopyQuiz',
			array('name' => 'lbCopyQuiz'));
			
		$this->_lbMoveQuiz =& new AriListBoxWebControl('lbMoveQuiz',
			array('name' => 'lbMoveQuiz'));
	}
	
	function _bindControls()
	{		
		$this->_tbxImportDir->setText(JPATH_ROOT);
		
		$quizList = $this->_getQuizList();
		
		$this->_lbBankCategory->setEmptyRow(AriWebHelper::translateResValue('Label.AllCategory'), -1);
		$this->_lbBankCategory->dataBind($this->_getBankCategoryList(true), 'CategoryName', 'CategoryId');
		$this->_lbBankCategory->setSelectedValue(-1);
		
		$this->_lbQuestionCategory->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbQuestionCategory->dataBind($this->_getCategoryList($this->_getQuizId()), 'CategoryName', 'QuestionCategoryId');
		$this->_lbQuestionCategory->setSelectedValue(0);
		
		$this->_lbMassQuestionCategory->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassQuestionCategory->dataBind($this->_getCategoryList($this->_getQuizId()), 'CategoryName', 'QuestionCategoryId');
		$this->_lbMassQuestionCategory->setSelectedValue(0);
		
		$this->_lbCopyBankQuestionCategory->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbCopyBankQuestionCategory->dataBind($this->_getBankCategoryList(), 'CategoryName', 'CategoryId');
		$this->_lbCopyBankQuestionCategory->setSelectedValue(0);
		
		$this->_lbCopyQuiz->dataBind($quizList, 'QuizName', 'QuizId');
		$this->_lbCopyQuiz->setSelectedValue(0);
		$this->_lbCopyQuiz->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), '0');
		
		$this->_lbMoveQuiz->dataBind($quizList, 'QuizName', 'QuizId');
		$this->_lbMoveQuiz->setSelectedValue(0);
		$this->_lbMoveQuiz->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), '0');
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvImportDir',
			array('controlToValidate' => 'tbxImportDir', 'errorMessageResourceKey' => 'Validator.ImportDirRequired', 'groups' => array($this->VG_IMPORT_DIR)));
	}
	
	function _createDataTable($quizId)
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQuestionList&quizId=' . $quizId;		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionId', 'label' => AriWebHelper::translateResValue('Label.ID'), 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'Question', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => false, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuestions')),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.QuestionCategory'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatStripHtml')),
			new AriDataTableControlColumn(array('key' => 'QuestionType', 'label' => AriWebHelper::translateResValue('Label.QuestionType'))),
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.Reorder'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuestionsReorder', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Quiz'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatStripHtml')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => '', 'hidden' => true)),
			new AriDataTableControlColumn(array('key' => 'QuestionIndex2', 'label' => '', 'hidden' => true)),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}
	
	function _createBankDataTable($quizId)
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getBankQuestionList&quizId=' . $quizId;		
		$columns = array(
			new AriDataTableControlColumn(array('key' => 'Num', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter', 'width' => 15)),
			new AriDataTableControlColumn(array('key' => 'BankQuestionId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter', 'width' => 20)),
			new AriDataTableControlColumn(array('key' => 'Question', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatBankQuestions', 'width' => 429)),
			new AriDataTableControlColumn(array('key' => 'QuestionType', 'label' => AriWebHelper::translateResValue('Label.QuestionType'), 'sortable' => true, 'className' => 'dtCenter', 'width' => 130)),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.Category'), 'sortable' => true, 'width' => 220))
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_bankPersistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl, 'width' => '935px', 'height' => '375px'),
			null,
			true,
			false);

		return $dataTable;
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
	
	function _getQuizList()
	{ 
		if (is_null($this->_quizList))
		{
			$quizList = $this->_quizController->call('getQuizList');
			if (is_null($quizList)) $quizList = array();
			
			$this->_quizList = $quizList;
		}

		return $this->_quizList;
	}
	
	function _getCategoryList($quizId)
	{
		if (is_null($this->_questionCategories))
		{
			$categoryList = $this->_questionCategoryController->call('getQuestionCategoryList', $quizId);
			if (is_null($categoryList)) $categoryList = array();
			
			$this->_questionCategories = $categoryList;
		}

		return $this->_questionCategories;
	}
	
	function _changeQuestionOrder($dir)
	{
		global $option;
		
		$quizId = AriRequest::getParam('quizId', 0);
		$questionId = AriRequest::getParam('queId', array());
		if (is_array($questionId)) $questionId = $questionId[0];
		$questionId = @intval($questionId, 10);
		
		$result = ($this->_questionController->call('changeQuestionOrder', $questionId, $dir) && !$this->_isError());

		return $result;
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
		$quizId = $this->_getQuizId();
		$csvImporter = new AriQuizCSVQuestionImportController();
		$result = $csvImporter->importQuizQuestions(
			$csvFile,
			$quizId,
			$my->get('id'));
		
		$msgId = $result
			? 'Complete.DataImport'
			: 'Complete.DataImportFailed';
		AriResponse::redirect('index.php?option=' . AriQuizComponent::getCodeName() . '&task=question_list&quizId=' . $quizId . '&arimsg=' . $msgId);
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getQuestionList', 'ajaxGetQuestionList');
		$this->_registerAjaxHandler('getBankQuestionList', 'ajaxGetBankQuestionList');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
		$this->_registerAjaxHandler('orderup', 'ajaxOrderUp');
		$this->_registerAjaxHandler('orderdown', 'ajaxOrderDown');
		$this->_registerAjaxHandler('importFromBank', 'ajaxImportFromBank');
		$this->_registerAjaxHandler('massEdit', 'ajaxMassEdit');
		$this->_registerAjaxHandler('bankCopy', 'ajaxBankCopy');
		$this->_registerAjaxHandler('getQuestionCategories', 'ajaxGetQuestionCategories');
		$this->_registerAjaxHandler('copy', 'ajaxCopy');
		$this->_registerAjaxHandler('move', 'ajaxMove');
	}
	
	function ajaxCopy()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');

		$quizId = intval(AriRequest::getParam('lbCopyQuiz'), 10);
		$categoryId = intval(AriRequest::getParam('lbCopyQueCategory'), 10);
		
		$result = $this->_questionController->call('copy',
			AriRequest::getParam('QuestionId', null),
			$quizId,
			$categoryId,
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxMove()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');

		$quizId = intval(AriRequest::getParam('lbMoveQuiz'), 10);
		$categoryId = intval(AriRequest::getParam('lbMoveQueCategory'), 10);
		
		$result = $this->_questionController->call('move',
			AriRequest::getParam('QuestionId', null),
			$quizId,
			$categoryId,
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxBankCopy()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		
		$categoryId = intval(AriRequest::getParam('lbCopyBankQuestionCategory', 0), 10);
		$basedOnBank = !!AriRequest::getParam('chkBasedOnBank');
		
		$result = $this->_questionController->call('copyToBank',
			AriRequest::getParam('QuestionId', null),
			$categoryId,
			$ownerId,
			$basedOnBank);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxMassEdit()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');

		$score = AriRequest::getParam('tbxMassScore');
		if (!is_null($score)) $score = intval($score, 10);		
		
		$categoryId = AriRequest::getParam('lbMassQuestionCategories');
		if (!is_null($categoryId)) $categoryId = intval($categoryId, 10);
		
		$result = $this->_questionController->call('updateQuestion',
			AriRequest::getParam('QuestionId', null),
			$score,
			$categoryId,
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxImportFromBank()
	{
		$my =& JFactory::getUser();
		
		$ownerId = $my->get('id');
		$bankIdList = AriRequest::getParam('BankQuestionId', 0);
		$categoryId = @intval(AriRequest::getParam('lbQuestionCategories', 0), 10);
		$score = AriRequest::getParam('tbxBankScore');
		if ($score) $score = trim($score);
		$score = strlen($score)
			? @intval($score, 10)
			: null;
		
		$quizId = $this->_getQuizId();
		$result = ($this->_bankController->call('importQuestionsFromBank', $bankIdList, $quizId, $ownerId, $categoryId, $score) && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxOrderUp()
	{
		$result = $this->_changeQuestionOrder(-1);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxOrderDown()
	{
		$result = $this->_changeQuestionOrder(1);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxDelete($eventArgs)
	{
		$result = ($this->_questionController->call('deleteQuestion', AriRequest::getParam('QuestionId', 0)) && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxGetQuestionList()
	{
		$quizId = @intval(AriRequest::getParam('quizId', 0));
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'QuestionIndex2', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$totalCnt = $this->_questionController->call('getQuestionCount', $quizId, $filter);
		$filter->fixFilter($totalCnt);

		$questions = $this->_questionController->call('getQuestionList', $quizId, $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
	
	function ajaxGetQuestionCategories()
	{
		$quizId = @intval(AriRequest::getParam('quizId'), 10);
		$categories = $quizId > 0
			? $this->_questionCategoryController->call('getQuestionCategoryList', $quizId)
			: null;

		AriResponse::sendJsonResponse($categories);
	}
	
	function ajaxGetBankQuestionList()
	{
		$categoryId = AriRequest::getParam('lbBankCategories', null);
		if (!is_null($categoryId))
		{
			$categoryId = @intval($categoryId, 10);
			if ($categoryId < 0) $categoryId = null;
		}

		$quizId = @intval(AriRequest::getParam('quizId', null), 10);
		$loadUsedQuestions = AriUtils::parseValueBySample(AriRequest::getParam('chkLoadUsedQuestions', null), false);
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'Question', 'dir' => 'asc', 
				'filter' => array('CategoryId' => $categoryId, 'QuizId' => $quizId, 'NotLoadUsedQuestions' => !$loadUsedQuestions)), 
			true);

		$totalCnt = $this->_bankController->call('getQuestionCount', $filter);
		$filter->fixFilter($totalCnt);

		$questions = $this->_bankController->call('getQuestionList', $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($questions, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>