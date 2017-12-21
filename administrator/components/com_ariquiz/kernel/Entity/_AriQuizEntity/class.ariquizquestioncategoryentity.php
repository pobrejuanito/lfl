<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizQuestionCategoryEntity extends AriDBTable
{
	var $QuestionCategoryId;
	var $QuizId;
	var $CategoryName;
	var $Description = '';
	var $CreatedBy = 0;
	var $Created;
	var $ModifiedBy = 0;
	var $Modified = null;
	var $QuestionCount = 0;
	var $QuestionTime = 0;
	var $Quiz;
	var $RandomQuestion = 0;
	var $Status;
	
	function AriQuizQuestionCategoryEntity(&$_db)
	{
		$this->AriDBTable('#__ariquizquestioncategory', 'QuestionCategoryId', $_db);
	}
}
?>
