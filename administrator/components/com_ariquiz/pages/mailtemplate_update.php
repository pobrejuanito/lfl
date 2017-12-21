<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/quizMailTemplate.base.php';

class mailtemplate_updateAriPage extends quizMailTemplateAriPage 
{
	function _init()
	{
		parent::_init();
		
		$mailTemplateId = @intval(AriRequest::getParam('mailTemplateId', 0), 10);
		if ($mailTemplateId < 1)
		{
			AriResponse::redirect('index.php?option=' . AriQuizComponent::getCodeName() . '&task=' . $this->_mailTemplateList);
		}
		
		$this->_mailTemplateId = $mailTemplateId;
	}
	
	function execute()
	{
		$this->addVar('mailTemplateId', $this->_mailTemplateId); 
		$this->setTitle(
			AriWebHelper::translateResValue('Label.MailTemplate') . ' : ' . AriWebHelper::translateResValue('Label.UpdateItem'));
		
		parent::execute();
	}
	
	function _getMailTemplate()
	{
		if (is_null($this->_mailTemplate))
		{			
			$this->_mailTemplate = $this->_mailTemplateController->call('getTemplate', $this->_mailTemplateId);
		}
		
		return $this->_mailTemplate;
	}
}
?>