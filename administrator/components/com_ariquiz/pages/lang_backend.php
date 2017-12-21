<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.LangListPageBase');

class lang_backendAriPage extends AriLangListPageBase 
{
	function _init()
	{
		$codeName = AriGlobalPrefs::getOption();
		$this->_fileGroup = AriConstantsManager::getVar('FileGroup.BackendLang', $codeName);
		$this->_defaultFileKey = AriConstantsManager::getVar('Config.BackendLang', $codeName);
		$this->_task = 'lang_backend';
		$this->_addTask = 'blang_add';
		$this->_dtId = 'dtBackendLang';
		
		parent::_init();
	}
}
?>