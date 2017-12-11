<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizExportProfileEntity extends AriDBTable 
{
	var $ProfileId = null;
	var $ProfileName = '';
	var $ProfileAlias = null;
	var $ExportAllQuizzes = 0;
	var $ExportAllBankQuestions = 0;
	var $ExportQuizzes = 0;
	var $ExportBankQuestions = 0;
	var $ExportQuizResults = 0;
	var $Created;
	var $CreatedBy = 0;
	var $ModifiedBy = null;
	var $Modified = null;
	
	function AriQuizExportProfileEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquiz_export', 'ProfileId', $_db);
	}	
}
?>