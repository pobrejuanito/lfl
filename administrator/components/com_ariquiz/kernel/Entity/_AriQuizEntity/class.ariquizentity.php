<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizEntity extends AriDBTable
{
	var $QuizId = null;
	var $QuizName = '';
	var $CreatedBy = 0;
	var $Created;
	var $ModifiedBy = 0;
	var $Modified = null;
	var $AccessType = null;
	var $Status;
	var $TotalTime = 0;
	var $PassedScore = 0;
	var $QuestionCount = 0;
	var $QuestionTime = 0;
	var $CategoryList;
	var $AccessList;
	var $Description = '';
	var $CanSkip = 0;
	var $CanStop = 0;
	var $RandomQuestion = 0;
	var $UseCalculator = 0;
	var $AttemptCount = 0;
	var $LagTime = 0;
	var $CssTemplateId = 0;
	var $AdminEmail = '';
	var $ResultScaleId = 0;
	var $ParsePluginTag = 0;
	var $ShowCorrectAnswer = 0;
	var $ShowExplanation = 0;
	var $Anonymous = 'Yes';
	var $QuestionOrderType = 'Numeric';
	var $FullStatistics = 'Never';
	var $MailGroupList = '';
	var $AutoMailToUser = 0;
	var $StartDate = null;
	var $EndDate = null;

	function AriQuizEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquiz', 'QuizId', $_db);
	}
}
?>