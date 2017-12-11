<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.QuizController');
AriKernel::import('Controllers.AriQuiz.CategoryController');
AriKernel::import('Controllers.FileController');
AriKernel::import('TextTemplates.TextTemplateController');
AriKernel::import('MailTemplates.MailTemplatesController');
AriKernel::import('Controllers.AriQuiz.ResultScaleController');
AriKernel::import('Web.Controls.Editor');
AriKernel::import('Web.Controls.CheckBox');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');
AriKernel::import('Web.Controls.Validators.RangeValidator');
AriKernel::import('Web.Controls.Validators.RegExValidator');
AriKernel::import('Web.Controls.Validators.CustomValidator');

class quiz_listAriPage extends AriAdminSecurePageBase 
{
	var $_fileController;
	var $_quizController;
	var $_lbFilterCategory;
	var $_lbFilterStatus;
	var $_lbMassCategory;
	var $_lbMassQuestionOrderType;
	var $_lbMassAnonStatus;
	var $_lbMassFullStatisticsType;
	var $_lbMassCss;
	var $_lbMassSucEmail;
	var $_lbMassFailEmail;
	var $_lbMassSucPrint;
	var $_lbMassFailPrint;
	var $_lbMassSuc;
	var $_lbMassFail;
	var $_lbMassAdminEmail;
	var $_lbMassScale;
	var $_filter;
	var $_persistanceKey = 'dtQuizzes';
	
	function _init()
	{
		$this->_quizController = new AriQuizController();
		$this->_fileController = new AriFileController();
		
		parent::_init();
	}
	
	function execute()
	{
		$dataTable = $this->_createDataTable();
		
		$this->_bindFilters();
		
		$this->setResTitle('Title.QuizList');
		$this->addVar('dataTable', $dataTable);
		
		parent::execute();
	}
	
	function _createDataTable()
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQuizList';		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => AriWebHelper::translateResValue('Label.ID'), 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuiz')),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.Category'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatStripHtml')),
			new AriDataTableControlColumn(array('key' => 'Status', 'label' => AriWebHelper::translateResValue('Label.Status'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuizStatus', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => AriWebHelper::translateResValue('Label.Questions'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuizQuestion', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => AriWebHelper::translateResValue('Label.Results'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuizResult', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => AriWebHelper::translateResValue('Label.QCategories'), 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuizCategory', 'className' => 'dtCenter dtColMin')),
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}

	function _getCategoryList()
	{
		$categoryController = new AriQuizCategoryController();
		$categoryList = $categoryController->call('getCategoryList');
		
		return $categoryList;
	}
	
	function _getStatusList()
	{
		$statusList = AriConstantsManager::getVar('Status', AriQuizControllerConstants::getClassName());
		
		return array(
			$statusList['Active'] => AriWebHelper::translateResValue('Label.Active'), 
			$statusList['Inactive'] => AriWebHelper::translateResValue('Label.Inactive'));
	}

	function _createControls()
	{
		$quizTextList = AriConstantsManager::getVar('TextTemplates', AriQuizComponent::getCodeName());
		
		$this->_lbFilterCategory =& new AriListBoxWebControl('lbFilterCategory');
			
		$this->_lbFilterStatus =& new AriListBoxWebControl('lbFilterStatus',
			array('translateText' => false));
			
		$this->_filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'QuizName', 'dir' => 'asc'), 
			false,
			'dtQuizzes');
		$this->_filter->restore();
		
		$this->_lbMassCategory =& new AriListBoxWebControl('lbMassCategory',
			array('name' => 'MassCategory[]'));
			
		$this->_lbMassQuestionOrderType =& new AriListBoxWebControl('lbMassAnsOrderType',
			array('name' => 'MassEdit[QuestionOrderType]', 'translateText' => false));
			
		$this->_lbMassFullStatisticsType =& new AriListBoxWebControl('lbMassFullStatisticsType',
			array('name' => 'MassEdit[FullStatistics]', 'translateText' => false));
			
		$this->_lbMassAnonStatus =& new AriListBoxWebControl('lbMassAnonStatus',
			array('name' => 'MassEdit[Anonymous]', 'translateText' => false));
			
		$this->_lbMassCss =& new AriListBoxWebControl('lbMassTemplate',
			array('name' => 'MassEdit[CssTemplateId]'));
			
		$this->_lbMassSucEmail =& new AriListBoxWebControl('lbMassSucEmail',
			array('name' => 'MassTextTemplate[' . $quizTextList['SuccessfulEmail'] . ']'));
			
		$this->_lbMassFailEmail =& new AriListBoxWebControl('lbMassFailEmail',
			array('name' => 'MassTextTemplate[' . $quizTextList['FailedEmail'] . ']'));
			
		$this->_lbMassSucPrint =& new AriListBoxWebControl('lbMassSucPrint',
			array('name' => 'MassTextTemplate[' . $quizTextList['SuccessfulPrint'] . ']'));
			
		$this->_lbMassFailPrint =& new AriListBoxWebControl('lbMassFailPrint',
			array('name' => 'MassTextTemplate[' . $quizTextList['FailedPrint'] . ']'));
			
		$this->_lbMassSuc =& new AriListBoxWebControl('lbMassSuc',
			array('name' => 'MassTextTemplate[' . $quizTextList['Successful'] . ']'));
			
		$this->_lbMassFail =& new AriListBoxWebControl('lbMassFail',
			array('name' => 'MassTextTemplate[' . $quizTextList['Failed'] . ']'));
			
		$this->_lbMassAdminEmail =& new AriListBoxWebControl('lbMassAdminEmail',
			array('name' => 'MassTextTemplate[' . $quizTextList['AdminEmail'] . ']'));
			
		$this->_lbMassScale =& new AriListBoxWebControl('lbMassScale',
			array('name' => 'MassEdit[ResultScaleId]'));
		
		$this->_bindControls();
	}
	
	function _bindFilters()
	{
		$filterPredicates = $this->_filter->getConfigValue('filter');

		if (isset($filterPredicates['CategoryId'])) $this->_lbFilterCategory->setSelectedValue($filterPredicates['CategoryId']);
		if (isset($filterPredicates['Status'])) $this->_lbFilterStatus->setSelectedValue($filterPredicates['Status']);
	}
	
	function _bindControls()
	{
		$categories = $this->_getCategoryList();
		
		$this->_lbFilterCategory->setEmptyRow(AriWebHelper::translateResValue('Label.AllCategory'), 0);
		$this->_lbFilterCategory->dataBind($categories, 'CategoryName', 'CategoryId');
		
		$this->_lbFilterStatus->setEmptyRow(AriWebHelper::translateResValue('Label.AllStatus'), 0);
		$this->_lbFilterStatus->dataBind($this->_getStatusList());
		
		$this->_lbMassCategory->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassCategory->dataBind($categories, 'CategoryName', 'CategoryId');
		$this->_lbMassCategory->setSelectedValue(0);
		
		$this->_lbMassQuestionOrderType->dataBind($this->_getQuestionOrderTypes());
		
		$this->_lbMassAnonStatus->dataBind($this->_getAnonymousStatuses());
		
		$this->_lbMassFullStatisticsType->dataBind($this->_getFullStatisticsTypes());
		
		$this->_lbMassCss->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassCss->dataBind($this->_getCssTemplateList(), 'ShortDescription', 'FileId');
		
		$quizTextList = AriConstantsManager::getVar('TextTemplates', AriQuizComponent::getCodeName());
		$textTemplates = $this->_getTextTemplateList();
		$mailTemplates = $this->_getMailTemplateList();

		$this->_lbMassSucEmail->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassSucEmail->dataBind($mailTemplates, 'TemplateName', 'TextTemplateId');
		
		$this->_lbMassFailEmail->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassFailEmail->dataBind($mailTemplates, 'TemplateName', 'TextTemplateId');
		
		$this->_lbMassSucPrint->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassSucPrint->dataBind($textTemplates, 'TemplateName', 'TemplateId');
		
		$this->_lbMassFailPrint->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassFailPrint->dataBind($textTemplates, 'TemplateName', 'TemplateId');
		
		$this->_lbMassSuc->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassSuc->dataBind($textTemplates, 'TemplateName', 'TemplateId');
		
		$this->_lbMassFail->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassFail->dataBind($textTemplates, 'TemplateName', 'TemplateId');
		
		$this->_lbMassAdminEmail->setEmptyRow(AriWebHelper::translateResValue('Label.NotSelectedItem'), 0);
		$this->_lbMassAdminEmail->dataBind($mailTemplates, 'TemplateName', 'TextTemplateId');
		
		$this->_lbMassScale->setEmptyRow(AriWebHelper::translateResValue('Label.ChooseScale'), 0);
		$this->_lbMassScale->dataBind($this->_getScaleList(), 'ScaleName', 'ScaleId');		
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getQuizList', 'ajaxGetQuizList');
		$this->_registerAjaxHandler('activate', 'ajaxActivate');
		$this->_registerAjaxHandler('deactivate', 'ajaxDeactivate');
		$this->_registerAjaxHandler('singleActivate', 'ajaxSingleActivate');
		$this->_registerAjaxHandler('singleDeactivate', 'ajaxSingleDeactivate');
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
		$this->_registerAjaxHandler('filters', 'ajaxFilters');
		$this->_registerAjaxHandler('massEdit', 'ajaxMassEdit');
		$this->_registerAjaxHandler('copy', 'ajaxCopy');
	}
	
	function ajaxCopy()
	{
		$my =& JFactory::getUser();

		$ownerId = $my->get('id');
		$quizName = AriRequest::getParam('tbxCopyQuizName');
		
		$result = $this->_quizController->call('copyQuizzes',
			AriRequest::getParam('QuizId', null),
			$quizName,
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxMassEdit()
	{
		$my =& JFactory::getUser();

		$ownerId = $my->get('id');

		$fields = AriWebHelper::translateRequestValues('MassEdit');
		$textTemplates = AriRequest::getParam('MassTextTemplate');
		$category = AriRequest::getParam('MassCategory');
		$props = AriRequest::getParam('MassQuizProp');

		$result = $this->_quizController->call('updateQuiz',
			AriUtils::resolvePath('administrator/components/' . AriQuizComponent::getCodeName() . '/config/data.xml'),
			AriRequest::getParam('QuizId', null), 
			$fields, 
			$category,
			$textTemplates,
			$props,
			$ownerId);

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxActivate($eventArgs)
	{
		$result = $this->_quizController->call('activateQuiz', AriRequest::getParam('QuizId', 0));

		AriResponse::sendJsonResponse($result);		
	}
	
	function ajaxDeactivate($eventArgs)
	{
		$result = $this->_quizController->call('deactivateQuiz', AriRequest::getParam('QuizId', 0));

		AriResponse::sendJsonResponse($result);		
	}

	function ajaxSingleActivate($eventArgs)
	{
		$result = $this->_quizController->call('activateQuiz', AriRequest::getParam('quizId', 0));

		AriResponse::sendJsonResponse($result);		
	}
	
	function ajaxSingleDeactivate($eventArgs)
	{
		$result = $this->_quizController->call('deactivateQuiz', AriRequest::getParam('quizId', 0));

		AriResponse::sendJsonResponse($result);		
	}
	
	function ajaxDelete()
	{
		$result = $this->_quizController->call('deleteQuiz', AriRequest::getParam('QuizId', 0));
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxFilters()
	{	
		$this->loadControls();
		$filterPredicates = array('CategoryId' => $this->_lbFilterCategory->getSelectedValue(),
			'Status' => $this->_lbFilterStatus->getSelectedValue());
		
		$filter =& $this->_filter;
		$filter->setConfigValue('filter', $filterPredicates);
		$filter->store();
		
		AriResponse::sendJsonResponse(true);
	}
	
	function ajaxGetQuizList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'QuizName', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$totalCnt = $this->_quizController->call('getQuizCount', $filter);
		$filter->fixFilter($totalCnt);

		$quizzes = $this->_quizController->call('getQuizList', $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($quizzes, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
		exit();
	}
	
	function _getQuestionOrderTypes()
	{
		$qOrderTypes = AriConstantsManager::getVar('QuestionOrderType', AriQuizControllerConstants::getClassName());
		$data = array();
		foreach ($qOrderTypes as $key => $value)
		{
			$data[$value] = AriWebHelper::translateResValue('Label.QOT.' . $key);
		}
		
		return $data;
	}
	
	function _getFullStatisticsTypes()
	{
		$statTypes = AriConstantsManager::getVar('FullStatisticsType', AriQuizControllerConstants::getClassName());
		$data = array();
		foreach ($statTypes as $key => $value)
		{
			$data[$value] = AriWebHelper::translateResValue('Label.FST.' . $key);
		}

		return $data;
	}
	
	function _getAnonymousStatuses()
	{
		$statuses = AriConstantsManager::getVar('AnonymousStatus', AriQuizControllerConstants::getClassName());
		$data = array();
		foreach ($statuses as $key => $value)
		{
			$data[$value] = AriWebHelper::translateResValue('Label.AnonStatus.' . $key);
		}
		
		return $data;
	}
	
	function _getCssTemplateList()
	{		
		$cssTemplates = $this->_fileController->call('getFileList', AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName()));
		
		return $cssTemplates;
	}
	
	function _getMailTemplateList()
	{
		$codeName = AriQuizComponent::getCodeName();

		$mailTemplateController = new AriMailTemplatesController(
			AriConstantsManager::getVar('MailTemplateTable', $codeName),
			AriConstantsManager::getVar('TextTemplateTable', $codeName));
		$templateList = $mailTemplateController->call('getTemplateList', null, AriConstantsManager::getVar('TemplateGroup.MailResults', $codeName));
		
		return $templateList;
	}
	
	function _getTextTemplateList()
	{
		$templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
		$templateList = $templateController->call('getTemplateList', AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName()));
		
		return $templateList;
	}
	
	function _getScaleList()
	{
		$scaleController = new AriQuizResultScaleController();
		$filter = new AriDataFilter(
			array('startOffset' => null, 'limit' => null, 'sortField' => 'ScaleName', 'dir' => 'asc'));

		return $scaleController->call('getScaleList', $filter);
	}
	
	function _createValidators()
	{
		new AriRangeValidatorWebControl('aravTotalTime',
			array('controlToValidate' => 'tbxMassTotalTime', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.TotalTime', 'groups' => array('massEditActive')));

		new AriRangeValidatorWebControl('aravPassedScore',
			array('controlToValidate' => 'tbxMassPassedScore', 'minValue' => 0, 'maxValue' => 100, 'errorMessageResourceKey' => 'Validator.PassedScore', 'groups' => array('massEditActive')));
			
		new AriRangeValidatorWebControl('aravQuestionCount',
			array('controlToValidate' => 'tbxMassQuestionCount', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.QuestionCount', 'groups' => array('massEditActive')));
			
		new AriRangeValidatorWebControl('aravQuestionTime',
			array('controlToValidate' => 'tbxMassQuestionTime', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.QuestionTime', 'groups' => array('massEditActive')));
			
		new AriRangeValidatorWebControl('aravLagTime',
			array('controlToValidate' => 'tbxMassLagTime', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.LagTime', 'groups' => array('massEditActive')));
			
		new AriRangeValidatorWebControl('aravAttempCount',
			array('controlToValidate' => 'tbxMassAttemptCount', 'minValue' => 0, 'errorMessageResourceKey' => 'Validator.AttemptCount', 'groups' => array('massEditActive')));

		new AriRegExValidatorWebControl('arevAdminEmail', '/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/i',
			array('controlToValidate' => 'tbxMassAdminEmail',
				'clientRegEx' => '/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/i',
				'errorMessageResourceKey' => 'Validator.EmailIncorrect',
				'groups' => array('massEditActive')));			
	}
}
?>