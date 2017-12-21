<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriMailTemplateEntity extends AriDBTable 
{
	var $MailTemplateId;
	var $Subject;
	var $From;
	var $FromName;
	var $AllowHtml = 1;
	var $TextTemplateId;
	var $TextTemplate;

	function AriMailTemplateEntity(&$_db, $tableName)
	{
		$this->AriDBTable($tableName, 'MailTemplateId', $_db);
	}
}
?>