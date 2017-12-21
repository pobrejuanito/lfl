<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizCategoryEntityBase extends AriDBTable
{
	var $CategoryId;
	var $CategoryName;
	var $Description = '';
	var $CreatedBy;
	var $Created;
	var $ModifiedBy = 0;
	var $Modified = null;

	function AriQuizCategoryEntityBase(&$_db, $tableName)
	{
		$this->AriDBTable($tableName, 'CategoryId', $_db);
	}
}
?>