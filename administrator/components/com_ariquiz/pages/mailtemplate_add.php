<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/quizMailTemplate.base.php';

class mailtemplate_addAriPage extends quizMailTemplateAriPage 
{
	function execute()
	{
		$this->setTitle(
			AriWebHelper::translateResValue('Label.MailTemplate') . ' : ' . AriWebHelper::translateResValue('Label.AddItem'));
		
		parent::execute();
	}
	
	function clickApply($eventArgs)
	{
		$template = $this->_saveTemplate();
		if (!$this->_isError())
		{
			AriWebHelper::preCompleteAction('Complete.TemplateSave', 
				array('task' => 'mailtemplate_update', 'mailTemplateId' => $template->MailTemplateId, 'hidemainmenu' => 1));
		}
	}
}
?>