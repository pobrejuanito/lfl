<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/mailTemplate.base.php';

class quizMailTemplateAriPage extends mailTemplateAriPage
{	
	function _init()
	{
		$codeName = AriQuizComponent::getCodeName();

		$this->_mailTemplateGroup = AriConstantsManager::getVar('TemplateGroup.MailResults', $codeName);
		$this->_mailTemplateList = 'mail_templates';
		$this->_mailTemplateController = new AriMailTemplatesController(
			AriConstantsManager::getVar('MailTemplateTable', $codeName),
			AriConstantsManager::getVar('TextTemplateTable', $codeName));
			
		parent::_init();
	}
}
?>