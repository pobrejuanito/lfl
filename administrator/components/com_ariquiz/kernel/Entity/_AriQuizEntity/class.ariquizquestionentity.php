<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizQuestionEntity extends AriDBTable 
{
	var $QuestionId;
	var $QuizId;
	var $QuestionVersionId = null;
	var $QuestionCategoryId = 0;
	var $QuestionTypeId = 0;
	var $CreatedBy;
	var $Created;
	var $ModifiedBy = 0;
	var $Modified = null;
	var $QuestionVersion;
	var $Status;
	var $QuestionIndex = 0;
	var $BankQuestionId = 0;
	var $_BankCategoryId;

	function AriQuizQuestionEntity(&$_db) 
	{
		$this->AriDBTable('#__ariquizquestion', 'QuestionId', $_db);
		$this->QuestionVersion = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', AriGlobalPrefs::getEntityGroup());
	}
	
	function bind($fields, $ignoreArray = array(), $bindChilds = false)
	{
		$result = parent::bind($fields, $ignoreArray);

		if (!$bindChilds) return $result;
		
		$questionVersion = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', AriGlobalPrefs::getEntityGroup());
		$questionVersion->bind(AriUtils::getParam($fields, 'QuestionVersion'), array(), true);

		$bankQuestionVersionFields = AriUtils::getParam($fields, 'BankQuestionVersion');
		if ($bankQuestionVersionFields && !empty($bankQuestionVersionFields['QuestionVersionId']))
		{
			$bankQuestionVersion = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', AriGlobalPrefs::getEntityGroup());
			$bankQuestionVersion->bind($bankQuestionVersionFields, array(), true);
			$questionVersion->mergeBankQuestionVersion($bankQuestionVersion);
		}				
		
		$this->QuestionVersion = $questionVersion;
		
		return $result;
	}
}
?>