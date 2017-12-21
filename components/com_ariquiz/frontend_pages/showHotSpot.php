<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.GetCacheFile');

class showHotSpotAriPage extends GetCacheFileAriPage
{
	function _init()
	{
		$this->_contentType = 'image/xyz';
		$this->_fileGroup = AriConstantsManager::getVar('FileGroup.HotSpot', AriQuizComponent::getCodeName());
		
		parent::_init();
	}
}
?>