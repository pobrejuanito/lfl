<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizScaleItemEntity extends AriDBTable 
{
	var $ScaleItemId = null;
	var $ScaleId = 0;
	var $BeginPoint = 0;
	var $EndPoint = 0;
	var $TextTemplateId = null;
	var $MailTemplateId = null;
	var $PrintTemplateId = null;
	
	function AriQuizScaleItemEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquiz_result_scale_item', 'ScaleItemId', $_db);
	}
}
?>
