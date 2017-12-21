<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('GlobalPrefs.GlobalPrefs');

class AriFileEntity extends AriDBTable 
{
	var $FileId;
	var $Content;
	var $FileName = '';
	var $Group = '';
	var $Size = 0;
	var $Description = null;
	var $ShortDescription = null;
	var $Created;
	var $CreatedBy = 0;
	var $Modified = null;
	var $ModifiedBy = 0;
	var $Extension = '';
	var $Flags = 0;
	
	function AriFileEntity(&$_db)
	{
		$table = AriGlobalPrefs::getFileTable();
		$this->AriDBTable($table, 'FileId', $_db);
	}
}
?>
