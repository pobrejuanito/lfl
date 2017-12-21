<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.LangAddPageBase');

class blang_addAriPage extends AriLangAddPageBase   
{
	function _init()
	{
		$codeName = AriGlobalPrefs::getOption();
		$this->_fileGroup = AriConstantsManager::getVar('FileGroup.BackendLang', $codeName);
		$this->_listTask = 'lang_backend';
		$this->_task = 'blang_add';
		
		parent::_init();
	}
}
?>