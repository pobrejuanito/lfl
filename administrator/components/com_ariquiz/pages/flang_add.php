<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.LangAddPageBase');

class flang_addAriPage extends AriLangAddPageBase   
{
	function _init()
	{
		$codeName = AriGlobalPrefs::getOption();
		$this->_fileGroup = AriConstantsManager::getVar('FileGroup.FrontendLang', $codeName);
		$this->_listTask = 'lang_frontend';
		$this->_task = 'flang_add';
		
		parent::_init();
	}
}
?>