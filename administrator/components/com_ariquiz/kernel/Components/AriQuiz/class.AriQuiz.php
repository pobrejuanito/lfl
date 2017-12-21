<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('I18N.I18N');
AriKernel::import('Components.Constants');
AriKernel::import('Web.Request');

class AriQuizComponent extends AriObject
{
	function getCodeName()
	{
		return 'com_ariquiz';
	}
	
	function &instance()
	{
		static $instance;
		
		if (!isset($instance))
		{
			$c = __CLASS__;
			$instance = new $c();
		}
		
		return $instance;
	}
	
	function init($loadI18N = true)
	{		
		$codeName = $this->getCodeName();
		AriGlobalPrefs::setOption($codeName);
		AriGlobalPrefs::setConfigGroup($codeName);
		AriGlobalPrefs::setCacheDir(AriConstantsManager::getVar('CacheDir', $codeName));
		AriGlobalPrefs::setConfigTable(AriConstantsManager::getVar('ConfigTable', $codeName));
		AriGlobalPrefs::setFileTable(AriConstantsManager::getVar('FileTable', $codeName));
		AriGlobalPrefs::setPersistanceTable(AriConstantsManager::getVar('PersistanceTable', $codeName));
		
		if ($loadI18N)
		{
			$i18n =& $this->_getI18N();
			AriGlobalPrefs::setI18N($i18n);
			AriGlobalPrefs::setDbCharset(AriConstantsManager::getVar('DbCharset', $codeName));
			AriGlobalPrefs::setEntityGroup(AriConstantsManager::getVar('EntityGroup', $codeName));
		}
	}
	
	function &_getI18N()
	{
		$isAdmin = AriJoomlaBridge::isAdmin();
		
		$codeName = $this->getCodeName();
		$configKey = $isAdmin ? 'Config.BackendLang' : 'Config.FrontendLang';
		$configKey = AriConstantsManager::getVar($configKey, $codeName);
		$fileGroup = $isAdmin ? 'FileGroup.BackendLang' : 'FileGroup.FrontendLang';
		$fileGroup = AriConstantsManager::getVar($fileGroup, $codeName);
		
		$i18n = $this->_createI18N($configKey, $fileGroup); 
		return $i18n;
	}
	
	function _createI18N($configKey, $fileGroup)
	{
		AriKernel::import('Cache.FileCache');
		AriKernel::import('Config.ConfigWrapper');
		
		$cacheDir = AriGlobalPrefs::getCacheDir();
		$useLang = AriRequest::getParam('aqLangId');
		if (empty($useLang))
			$useLang = AriConfigWrapper::getConfigKey($configKey, 'en'); 
		AriFileCache::cacheFile($cacheDir, $fileGroup, $useLang, 'xml');

		return new ArisI18N($cacheDir . $fileGroup, $useLang, $cacheDir . 'i18n/' . $fileGroup, $this->getCodeName(), 'en');
	}
}

class AriQuizConstants extends AriComponentConstants
{
	var $Option = null;
	var $TextTemplateTable = '#__arigenerictemplate';
	var $PersistanceTable = '#__ariquiz_persistance';
	var $FileTable = '#__ariquizfile';
	var $ConfigTable = '#__ariquizconfig';
	var $MailTemplateTable = '#__ariquizmailtemplate';
	var $PropertyTable = array(
		'Property' => '#__ariquiz_property',
		'PropertyValue' => '#__ariquiz_property_value');
	var $DbCharset = 'UTF-8';
	var $EntityGroup = '_AriQuizEntity';
	var $QuestionEntityGroup = '_AriQuizQuestionEntity';
	var $EntityKey = 'AriQuiz';
	var $Config = array(
		'Version' => 'Version',
		'BackendLang' => 'BLang',
		'FrontendLang' => 'FLang');
	var $FileGroup = array(
		'BackendLang' => 'lbackend',
		'FrontendLang' => 'lfrontend',
		'CssTemplate' => 'css',
		'HotSpot' => 'hotspot');
	var $TemplateGroup = array(
		'Results' => 'QuizResult',
		'MailResults' => 'QuizMailResult');
	var $TextTemplates = array(
		'Successful' => 'QuizSuccessful',
		'Failed' => 'QuizFailed',
		'SuccessfulEmail' => 'QuizSuccessfulEmail',
		'FailedEmail' => 'QuizFailedEmail',
		'SuccessfulPrint' => 'QuizSuccessfulPrint',
		'FailedPrint' => 'QuizFailedPrint',
		'AdminEmail' => 'QuizAdminEmail');
	
	function __construct()
	{
		$this->Option = AriQuizComponent::getCodeName();
		$this->CacheDir = JPATH_ROOT . '/administrator/components/' . $this->Option . '/cache/files/';
		
		parent::__construct();
	}
}

new AriQuizConstants();
?>