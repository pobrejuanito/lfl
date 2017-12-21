<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');

class quiz_infoAriPage extends AriPageBase
{
	function execute()
	{
		global $option;
		
		$mid = AriRequest::getParam('mid', '');
		$rurl = AriRequest::getParam('rurl', 'index.php?option=com_ariquiz&task=quiz_list');
		
		$this->addVar('mid', $mid);
		$this->addVar('rurl', $rurl);
		
		parent::execute();
	}
}
?>
