<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/mailTemplateList.base.php';

class mail_templatesAriPage extends mailTemplateListAriPage
{
	function _init()
	{
		$codeName = AriQuizComponent::getCodeName();
		
		$this->_titleResKey = 'Label.MailTemplates';
		$this->_templateFormatter = 'YAHOO.ARISoft.Quiz.formatters.formatMailTemplate';
		$this->_mailTemplateGroup = AriConstantsManager::getVar('TemplateGroup.MailResults', $codeName);;
		$this->_persistanceKey = 'dtQuizResultMTemplates';
		$this->_mailTemplateController = new AriMailTemplatesController(
			AriConstantsManager::getVar('MailTemplateTable', $codeName),
			AriConstantsManager::getVar('TextTemplateTable', $codeName));

		parent::_init();
	}	
}
?>