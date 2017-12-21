<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.AjaxPageBase');

class messagesAriPage extends AriPageBase
{
	function execute()
	{
		$messages = $this->_getMessages();
		
		$data = 'YAHOO.ARISoft.page._locale["' . AriQuizComponent::getCodeName() . '"] = ' . AriJSONHelper::encode($messages);

		$this->sendResponse($data, 'utf-8');
	}
	
	function _getMessages()
	{
		$arisI18N =& AriGlobalPrefs::getI18N();
		
		$messages = $arisI18N->getMessages();
		return $messages;
	}
}
?>