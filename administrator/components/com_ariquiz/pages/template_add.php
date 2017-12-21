<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.TextBox');
AriKernel::import('Web.Controls.Validators.RequiredValidator');
AriKernel::import('Web.Controls.Validators.CustomValidator');
AriKernel::import('Controllers.FileController');
AriKernel::import('Cache.FileCache');

class template_addAriPage extends AriAdminSecurePageBase 
{
	var $_savedIndex = array('ShortDescription', 'Content');
	var $_fileController;
	var $_tbxTemplateName;
	var $_tbxTemplate;
	
	function _init()
	{
		$this->_fileController = new AriFileController();
		
		parent::_init();
	}
	
	function execute()
	{
		$fileId = $this->_getFileId();
		$file = $this->_getFile($fileId);
		
		$this->_bindControls($file);
		
		$this->addVar('fileId', $fileId);

		$this->setTitle(
			AriWebHelper::translateResValue('Title.CSSTemplate') . ' : ' . AriWebHelper::translateResValue($fileId ? 'Label.UpdateItem' : 'Label.AddItem'));
		
		parent::execute();
	}
	
	function _getFileId()
	{
		return intval(AriRequest::getParam('fileId', 0));
	}
	
	function _getFile($fileId)
	{
		$file = null;
		if ($fileId != 0)
		{
			$file = $this->_fileController->call('getFile', $fileId, AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName()));
		}
		else
		{
			$file = AriEntityFactory::createInstance('AriFileEntity');
		}
		
		return $file;
	}
	
	function _registerEventHandlers()
	{
		$this->_registerEventHandler('save', 'clickSave');
		$this->_registerEventHandler('apply', 'clickApply');
		$this->_registerEventHandler('cancel', 'clickCancel');
	}
	
	function clickCancel($eventArgs)
	{
		AriWebHelper::cancelAction('templates');
	}
	
	function clickSave($eventArgs)
	{
		$template = $this->_saveFile();
		if (!$this->_isError())
		{
			 AriWebHelper::preCompleteAction('Complete.TemplateSave', array('task' => 'templates'));
		}
	}
	
	function clickApply($eventArgs)
	{
		$file = $this->_saveFile();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.TemplateSave', 
				array('task' => 'template_add', 'fileId' => $file->FileId, 'hidemainmenu' => 1));
		}
	}
	
	function _saveFile()
	{
		global $option;

		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		$reqFields = AriWebHelper::translateRequestValues('zTemplate');
		$fields = array();
		foreach ($this->_savedIndex as $index)
		{
			$fields[$index] = isset($reqFields[$index])
				? $reqFields[$index]
				: '';
		}
		
		if (get_magic_quotes_gpc())
		{
			$fields['Content'] = AriString::stripslashes($fields['Content']);
		}

		$group = AriConstantsManager::getVar('FileGroup.CssTemplate', AriQuizComponent::getCodeName());
		$fields['Group'] = $group;
		$file = $this->_fileController->call('saveFile',
			AriRequest::getParam('fileId', 0),
			$fields,
			$ownerId);
		if (!empty($file))
		{
			AriFileCache::saveTextFile($file->Content, 
				JPATH_ROOT . '/components/' . $option . '/cache/files/' . $group . '/' . $file->FileId . '.css');
		}
		
		return $file;
	}
	
	function _createControls()
	{
		$this->_tbxTemplateName =& new AriTextBoxWebControl('tbxTemplateName', 
			array('name' => 'zTemplate[ShortDescription]', 'maxLength' => 85));
			
		$this->_tbxTemplate =& new AriTextBoxWebControl('tbxTemplate', 
			array('name' => 'zTemplate[Content]',
				'type' => AriConstantsManager::getVar('Type.Multi', AriTextBoxWebControlConstants::getClassName())));			
	}
	
	function _createValidators()
	{
		new AriRequiredValidatorWebControl('arqvTemplateName',
			array('controlToValidate' => 'tbxTemplateName', 'errorMessageResourceKey' => 'Validator.NameRequired'));
			
		$validate = array(&$this, 'cvTemplate');
		new AriCustomValidatorWebControl('acvTemplate', $validate, 
			array('controlToValidate' => 'tbxTemplate',
				'clientValidateFunc' => 'YAHOO.ARISoft.page.templateValidate',
				'errorMessageResourceKey' => 'Validator.TemplateRequired'));
	}
	
	function cvTemplate()
	{
		return true;
	}
	
	function _bindControls($file)
	{		
		$content = $file->Content;
		if ($this->_getFileId() < 1)
		{
			$cssPath = JPATH_ROOT . '/components/' . AriQuizComponent::getCodeName() . '/css/default.css';
			if (@file_exists($cssPath))
			{
				$oldMQR = get_magic_quotes_runtime();
				set_magic_quotes_runtime(0);
			
				$handle = fopen($cssPath, "rb");
			 
				$content = fread($handle, filesize($cssPath));
				fclose($handle);
			
				set_magic_quotes_runtime($oldMQR);
			}
		}
		
		$this->_tbxTemplateName->setText(AriWebHelper::translateDbValue($file->ShortDescription));
		$this->_tbxTemplate->setText(AriWebHelper::translateDbValue($content));
	}
}
?>