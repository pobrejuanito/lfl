<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizQuestionTypeEntity extends AriDBTable 
{
	var $QuestionTypeId;
	var $QuestionType;
	var $ClassName;
	var $CanHaveTemplate = 1;
	var $TypeOrder = 0;
	var $Default;
	
	function AriQuizQuestionTypeEntity(&$_db)
	{
		$this->AriDBTable('#__ariquizquestiontype', 'QuestionTypeId', $_db);
	}
}
?>