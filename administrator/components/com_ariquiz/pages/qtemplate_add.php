<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.CheckBox');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Web.Controls.Editor');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');
AriKernel::import('Controllers.AriQuiz.QuestionController');

require_once dirname(__FILE__) . '/base/questionAddPageBase.php';

class qtemplate_addAriPage extends AriAdminSecurePageBase 
{
	var $_questionController;
	var $_tbxTemplateName;
	var $_lbQuestionType;
	var $_chkValidation;
	
	function _init()
	{
		$this->_questionController = new AriQuizQuestionController();
		
		parent::_init();
	}
	
	function execute()
	{
		$templateId = AriRequest::getParam('templateId', 0);
		$question = null;
		$className = null;
		$questionTypeList = $this->_questionController->call('getQuestionTypeList', true);
		$questionTypeId = AriRequest::getParam('questionTypeId', 0);
		if ($templateId == 0)
		{
			$template = AriEntityFactory::createInstance('AriQuizQuestionTemplateEntity', AriGlobalPrefs::getEntityGroup());
		}
		else 
		{
			$template = $this->_questionController->call('getQuestionTemplate', $templateId);
			if (empty($questionTypeId))
			{ 
				$questionTypeId = $template->QuestionTypeId;
			}
		}

		if (empty($questionTypeId))
		{ 
			$questionTypeId = $questionTypeList[0]->QuestionTypeId;  
		}
		
		foreach ($questionTypeList as $qt)
		{
			if ($qt->QuestionTypeId == $questionTypeId)
			{
				$className = $qt->ClassName;
				break;
			}
		}

		$specificQuestion = AriEntityFactory::createInstance($className, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
		$questionData = $template->Data;
		
		$this->_bindControls($template, $questionTypeId, $questionTypeList);
		
		$this->addVar('templateId', $templateId);
		$this->addVar('questionTypeId', $questionTypeId);
		$this->addVar('className', $className);
		$this->addVar('specificQuestion', $specificQuestion);
		$this->addVar('questionData', $questionData);
		
		$this->setTitle(
			AriWebHelper::translateResValue('Title.QuestionTemplate') . ':' . AriWebHelper::translateResValue($templateId ? 'Label.UpdateItem' : 'Label.AddItem'));
		
		parent::execute();
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('save', 'clickSave');
		$this->_registerEventHandler('apply', 'clickApply');
		$this->_registerEventHandler('cancel', 'clickCancel');
	}
	
	function clickCancel($eventArgs)
	{
		AriWebHelper::cancelAction('qtemplate_list');
	}
	
	function clickSave($eventArgs)
	{
		$template = $this->_saveTemplate();
		if (!$this->_isError())
		{
			 AriWebHelper::preCompleteAction('Complete.QTemplateSave', array('task' => 'qtemplate_list'));
		}				
	}
	
	function clickApply($eventArgs)
	{
		$template = $this->_saveTemplate();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.QTemplateSave', 
				array('task' => 'qtemplate_add', 'templateId' => $template->TemplateId, 'hidemainmenu' => 1));
		}
	}
	
	function _saveTemplate()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		$fields = AriWebHelper::translateRequestValues('zQuiz');
		
		$questionTypeId = AriRequest::getParam('questionTypeId', '');
		$questionType = $this->_questionController->call('getQuestionType', $questionTypeId);
		$questionObj = AriEntityFactory::createInstance($questionType->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
		$data = $questionObj->getXml();

		return $this->_questionController->call('saveQuestionTemplate',
			AriRequest::getParam('templateId', 0), 
			$questionTypeId,
			$ownerId, 
			$fields,
			$data);
	}
	
	function _createControls()
	{
		$this->_tbxTemplateName =& new AriTextBoxWebControl('tbxTemplateName', 
			array('name' => 'zQuiz[TemplateName]', 'maxLength' => 85));
			
		$this->_lbQuestionType =& new AriListBoxWebControl('lbQuestionType',
			array('name' => 'questionTypeId'));
			
		$this->_chkValidation =& new AriCheckBoxWebControl('chkValidation',
			array('name' => 'zQuiz[DisableValidation]'));
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvTemplateName',
			array('controlToValidate' => 'tbxTemplateName', 'errorMessageResourceKey' => 'Validator.NameRequired',
				'groups' => array('QTemplateValGroup')));
	}
	
	function _bindControls($template, $questionTypeId, $questionTypeList)
	{
		$this->_tbxTemplateName->setText(AriWebHelper::translateDbValue($template->TemplateName));

		$this->_lbQuestionType->dataBind($questionTypeList, 'QuestionType', 'QuestionTypeId');
		$this->_lbQuestionType->setSelectedValue($questionTypeId);
		
		$this->_chkValidation->setChecked($template->DisableValidation);
	}
}
?>