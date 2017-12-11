<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.LangListPageBase');

class lang_frontendAriPage extends AriLangListPageBase 
{
	function _init()
	{
		$codeName = AriGlobalPrefs::getOption();
		$this->_fileGroup = AriConstantsManager::getVar('FileGroup.FrontendLang', $codeName);
		$this->_defaultFileKey = AriConstantsManager::getVar('Config.FrontendLang', $codeName);
		$this->_task = 'lang_frontend';
		$this->_addTask = 'flang_add';
		$this->_dtId = 'dtFrontendLang';
		
		parent::_init();		
	}
}
?>