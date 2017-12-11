<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriTextTemplateBaseEntity extends AriDBTable 
{
	var $BaseTemplateId;
	var $DefaultValue;
	var $TemplateDescription;
	var $Group;

	function AriTextTemplateBaseEntity(&$_db, $tableName) 
	{
		$this->AriDBTable($tableName, 'BaseTemplateId', $_db);
	}
}
?>
