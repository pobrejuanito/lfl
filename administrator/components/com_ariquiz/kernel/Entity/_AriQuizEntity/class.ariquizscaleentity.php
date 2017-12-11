<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizScaleEntity extends AriDBTable 
{
	var $ScaleId = null;
	var $ScaleName = '';
	var $Created;
	var $CreatedBy = 0;
	var $ModifiedBy = 0;
	var $Modified = null;
	var $ScaleItems = array();
	
	function AriQuizScaleEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquiz_result_scale', 'ScaleId', $_db);
	}
}
?>