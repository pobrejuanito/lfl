<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Editor');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');
AriKernel::import('Web.Controls.Validators.CustomValidator');
AriKernel::import('TextTemplates.TextTemplateController');

class texttemplate_addAriPage extends AriAdminSecurePageBase
{
	var $_templateController;
	var $_tbxTemplateName;
	var $_edValue;
	
	function _init()
	{
		$this->_templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
		
		parent::_init();
	}
	
	function execute()
	{
		$templateId = intval(AriRequest::getParam('templateId', 0));
		$template = $this->_getTemplate($templateId);

		$this->addVar('templateId', $templateId);
		$this->addVar('params', $this->_getParams());
		
		$this->_bindControls($template);
		
		$this->setTitle(
			AriWebHelper::translateResValue('Label.Template') . ' : ' . AriWebHelper::translateResValue($templateId ? 'Label.UpdateItem' : 'Label.AddItem'));
		
		parent::execute();
	}
	
	function _getParams()
	{
		$params = $this->_templateController->call('getParamsByGroup', AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName()));
		
		return $params;
	}
	
	function _getTemplate($templateId)
	{
		$template = null;
		if ($templateId != 0)
		{
			$template = $this->_templateController->call('getTemplate', $templateId);
		}
		else
		{
			$template = $this->_templateController->call('createTextTemplateEntity'); 
		}
		
		return $template;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('save', 'clickSave');
		$this->_registerEventHandler('apply', 'clickApply');
		$this->_registerEventHandler('cancel', 'clickCancel');
	}
	
	function clickCancel($eventArgs)
	{
		AriWebHelper::cancelAction('texttemplate_list');
	}
	
	function clickSave($eventArgs)
	{
		$template = $this->_saveTemplate();
		if (!$this->_isError())
		{
			 AriWebHelper::preCompleteAction('Complete.TemplateSave', array('task' => 'texttemplate_list'));
		}
	}
	
	function clickApply($eventArgs)
	{
		$template = $this->_saveTemplate();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.TemplateSave', 
				array('task' => 'texttemplate_add', 'templateId' => $template->TemplateId, 'hidemainmenu' => 1));
		}
	}
	
	function _saveTemplate()
	{
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		$fields = AriWebHelper::translateRequestValues('zTemplate');

		return $this->_templateController->call('saveTemplate',
			AriRequest::getParam('templateId', 0),
			$fields,
			AriConstantsManager::getVar('TemplateGroup.Results', AriQuizComponent::getCodeName()),
			$ownerId);
	}
	
	function _createControls()
	{
		$this->_tbxTemplateName =& new AriTextBoxWebControl('tbxTemplateName', 
			array('name' => 'zTemplate[TemplateName]', 'maxLength' => 85));
			
		$this->_edValue =& new AriEditorWebControl('edValue',
			array('name' => 'zTemplate[Value]'));
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvTemplateName',
			array('controlToValidate' => 'tbxTemplateName', 'errorMessageResourceKey' => 'Validator.NameRequired'));
			
		$validate = array(&$this, 'cvValue');
		new AriCustomValidatorWebControl('acvValue', $validate, 
			array('controlToValidate' => 'edValue',
				'clientValidateFunc' => 'YAHOO.ARISoft.page.valueValidate',
				'errorMessageResourceKey' => 'Validator.TextRequired'));
	}
	
	function cvValue()
	{
		return true;
	}
	
	function _bindControls($template)
	{
		$this->_tbxTemplateName->setText(AriWebHelper::translateDbValue($template->TemplateName));
		$this->_edValue->setText(AriWebHelper::translateDbValue($template->Value));
	}
}
?>