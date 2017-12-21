<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Editor');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Web.Controls.Validators.RangeValidator');
AriKernel::import('Web.Controls.Validators.RequiredValidator');
AriKernel::import('Web.Controls.Validators.CustomValidator');
AriKernel::import('Controllers.AriQuiz.QuizController');
AriKernel::import('Controllers.AriQuiz.QuestionCategoryController');
AriKernel::import('Utils.Utils');

class questioncategory_addAriPage extends AriAdminSecurePageBase 
{
	var $_quizController;
	var $_qCategoryController;
	var $_tbxCategoryName;
	var $_tbxQuestionCount;
	var $_tbxQuestionTime;
	var $_edDescription;
	var $_lbQuizList;
	
	function _init()
	{
		$this->_quizController = new AriQuizController();
		$this->_qCategoryController = new AriQuizQuestionCategoryController();
		
		parent::_init();
	}
	
	function execute()
	{
		$qCategoryId = intval(AriRequest::getParam('qCategoryId', 0));
		$category = AriEntityFactory::createInstance('AriQuizQuestionCategoryEntity', AriGlobalPrefs::getEntityGroup());
		$isUpdate = false;
		$quizList = null;
		$quizId = 0;
		$isNotQuiz = false;
		if ($qCategoryId > 0)
		{
			$category = $this->_qCategoryController->call('getQuestionCategory', $qCategoryId, true);
			$quizId = $category->Quiz->QuizId;
			$isUpdate = true;
		}
		else 
		{
			$quizId = AriRequest::getParam('quizId', 0);
			$category->Quiz = $this->_quizController->call('getQuiz', $quizId);
			$quizList = $this->_getQuizList();
			$isNotQuiz = empty($quizList) || count($quizList) == 0;			
		}
		
		if ($isNotQuiz)
		{
			AriWebHelper::preCompleteAction('Warning.QCategoryCreateQuiz', 
				array('task' => 'questioncategory_list', 'quizId' => $quizId));
		}
		
		$this->addVar('category', $category);
		$this->addVar('isUpdate', $isUpdate);
		$this->addVar('quizId', $quizId);
		$this->addVar('qCategoryId', $qCategoryId);
		$this->addVar('quizList', $quizList);
		
		$this->_bindControls($category);
		
		$this->setTitle(
			AriWebHelper::translateResValue('Title.QuestionCategory') . ' : ' . AriWebHelper::translateResValue($qCategoryId ? 'Label.UpdateItem' : 'Label.AddItem'));
		
		parent::execute();
	}
	
	function _getQuizList()
	{
		$quizList = $this->_quizController->call('getQuizList');
		
		return $quizList;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('save', 'clickSave');
		$this->_registerEventHandler('apply', 'clickApply');
		$this->_registerEventHandler('cancel', 'clickCancel');
	}
	
	function clickCancel($eventArgs)
	{
		AriWebHelper::cancelAction('questioncategory_list', array('quizId' => AriRequest::getParam('quizId', 0)));
	}
	
	function clickSave($eventArgs)
	{
		$category = $this->_saveCategory();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.QCategorySave', array('task' => 'questioncategory_list', 'quizId' => $category->QuizId));
		}				
	}
	
	function clickApply($eventArgs)
	{
		$category = $this->_saveCategory();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.QCategorySave', 
				array('task' => 'questioncategory_add', 'qCategoryId' => $category->QuestionCategoryId, 'quizId' => $category->QuizId, 'hidemainmenu' => 1));
		}
	}
	
	function _saveCategory()
	{
		$my =& JFactory::getUser();

		$ownerId = $my->get('id');
		$fields = AriWebHelper::translateRequestValues('zCategory');
		$quizId = AriUtils::getParam($fields, 'QuizId', 0);
		$qCategoryId = AriRequest::getParam('qCategoryId', 0);

		if (!$qCategoryId && !$quizId) $this->clickCancel(null);
		
		return  $this->_qCategoryController->call('saveQuestionCategory',
			$qCategoryId,
			$fields,
			$quizId, 
			$ownerId);
	}
	
	function _createControls()
	{
		$this->_tbxCategoryName =& new AriTextBoxWebControl('tbxCategoryName', 
			array('name' => 'zCategory[CategoryName]', 'maxLength' => 85));
			
		$this->_tbxQuestionCount =& new AriTextBoxWebControl('tbxQuestionCount', 
			array('name' => 'zCategory[QuestionCount]', 'maxLength' => 85));
			
		$this->_tbxQuestionTime =& new AriTextBoxWebControl('tbxQuestionTime', 
			array('name' => 'zCategory[QuestionTime]', 'maxLength' => 85));
			
		$this->_edDescription =& new AriEditorWebControl('edDescription',
			array('name' => 'zCategory[Description]'));
			
		$this->_lbQuizList =& new AriListBoxWebControl('lbQuizList',
			array('name' => 'zCategory[QuizId]'));
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvCategoryName',
			array('controlToValidate' => 'tbxCategoryName', 'errorMessageResourceKey' => 'Validator.NameRequired'));

		new AriRangeValidatorWebControl('aravQuestionCount',
			array('controlToValidate' => 'tbxQuestionCount', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.QuestionCount'));
			
		new AriRangeValidatorWebControl('aravQuestionTime',
			array('controlToValidate' => 'tbxQuestionTime', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.QuestionTime'));
	}
	
	function _bindControls($category)
	{
		$this->_tbxCategoryName->setText(AriWebHelper::translateDbValue($category->CategoryName));
		$this->_tbxQuestionCount->setText($category->QuestionCount);
		$this->_tbxQuestionTime->setText($category->QuestionTime);
		$this->_edDescription->setText(AriWebHelper::translateDbValue($category->Description));
		
		$this->_lbQuizList->dataBind($this->_getQuizList(), 'QuizName', 'QuizId');
		$this->_lbQuizList->setSelectedValue($category->QuizId);
	}
}
?>