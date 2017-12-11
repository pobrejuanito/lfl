<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizQuestionVersionEntity extends AriDBTable
{
	var $QuestionVersionId;
	var $QuestionId;
	var $QuestionCategoryId = 0;
	var $QuestionType;
	var $QuestionTypeId = 0;
	var $Question = '';
	var $QuestionTime = 0;
	var $HashCode = '';
	var $Created;
	var $CreatedBy;
	var $Data = '';
	var $Score = 0;
	var $BankQuestionId = 0;
	var $OverrideScore;
	var $BankScore;
	var $Note;
	var $OnlyCorrectAnswer = 0;
	var $_BankCategoryId;
	var $_OverrideData = '';
	
	function AriQuizQuestionVersionEntity(&$_db)
	{
		$this->AriDBTable('#__ariquizquestionversion', 'QuestionVersionId', $_db);
		$this->QuestionType = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', AriGlobalPrefs::getEntityGroup());
	}

	function getPublicFields($ignoreArray = array())
	{
		array_push($ignoreArray, 'OverrideScore', 'BankScore');

		return parent::getPublicFields($ignoreArray);
	}
	
	function bind($fields, $ignoreArray = array(), $bindChilds = false)
	{
		array_push($ignoreArray, 'OverrideScore', 'BankScore');
		$result = parent::bind($fields, $ignoreArray);
		
		if (!$bindChilds) return $result;

		$questionType = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', AriGlobalPrefs::getEntityGroup());
		$questionType->bind(AriUtils::getParam($fields, 'QuestionType'));
		$this->QuestionType = $questionType;
		
		return $result;
	}
	
	function mergeBankQuestionVersion($bankQuestionVersion)
	{
		if (empty($bankQuestionVersion)) return ;

		$this->QuestionType = $bankQuestionVersion->QuestionType;
		$this->QuestionTypeId = $bankQuestionVersion->QuestionTypeId;
		$this->Question = $bankQuestionVersion->Question;
		$this->Note = $bankQuestionVersion->Note;
		$this->OnlyCorrectAnswer = $bankQuestionVersion->OnlyCorrectAnswer;
		$this->_OverrideData = $this->Data; 
		$this->Data = $bankQuestionVersion->Data;
		$this->BankScore = $bankQuestionVersion->Score;
		$this->OverrideScore = !empty($this->Score);
		$this->_BankCategoryId = $bankQuestionVersion->QuestionCategoryId;
		if (!$this->OverrideScore)
		{
			$this->Score = $bankQuestionVersion->Score;
		}
	}
	
	function store($updateNulls = false)
	{
		$this->BankScore = null;
		$this->OverrideScore = null;
		
		return parent::store($updateNulls);
	}
}
?>