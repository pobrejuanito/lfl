<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizQuestionTemplateEntity extends AriDBTable
{
	var $TemplateId;
	var $TemplateName;
	var $QuestionTypeId;
	var $Data;
	var $QuestionType;
	var $Created;
	var $CreatedBy;
	var $Modified = null;
	var $ModifiedBy = 0;
	var $DisableValidation = 0;
	
	function AriQuizQuestionTemplateEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquizquestiontemplate', 'TemplateId', $_db);
		$this->QuestionType = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', AriGlobalPrefs::getEntityGroup());
	}
}
?>
