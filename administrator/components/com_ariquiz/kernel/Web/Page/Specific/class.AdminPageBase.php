<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');

class AriAdminPageBase extends AriPageBase
{
	var $actionUrl = 'index.php';
	var $_title = '';
	var $isSimple = false;
	var $task = null;
	var $reload = false;
	var $hideMainMenu = false;
	
	function _init()
	{
		$hideMainMenu = AriRequest::getParam('hidemainmenu');
		if (!is_null($hideMainMenu))
		{
			$this->hideMainMenu = AriUtils::parseValueBySample($hideMainMenu, true);
		}
		
		parent::_init();
	}
	
	function setResTitle($resKey)
	{
		$this->setTitle(AriWebHelper::translateResValue($resKey));
	}
	
	function setTitle($title)
	{
		$this->_title = $title;
	}
	
	function getTitle()
	{
		return $this->_title;
	}
	
	function execute()
	{
		$tplPath = dirname(__FILE__) . '/_Templates/';
		$processPage =& $this;
		
		if (!$this->isSimple) require_once $tplPath . 'AdminPageHeader.html.php';
		
		parent::execute();
		
		$this->_registerSystemVariables();
		if (!$this->isSimple) require_once $tplPath . 'AdminPageFooter.html.php';
	}
	
	function _registerSystemVariables()
	{
		if (!is_null($this->task)) $this->addVar('task', $this->task);
		if ($this->reload) $this->addVar('reload', $this->reload);
		$hideMainMenu = $this->hideMainMenu ? '1' : '0';
		$this->addVar('hideMainMenu', $hideMainMenu);
	}
}
?>