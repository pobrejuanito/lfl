<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/questionAddPageBase.php';

class bank_addAriPage extends AriQuestionAddPageBase 
{	
	function _init()
	{
		parent::_init();

		$this->_task = 'bank_add';
		$this->_taskList = 'bank';
		$this->_mode = AriConstantsManager::getVar('Mode.Bank', AriQuestionUiConstants::getClassName());;
		$this->task = $this->_task;
	}

	function _saveQuestion()
	{ 
		$my =& JFactory::getUser();
		$ownerId = $my->get('id');
		$quizId = 0;
		$questionTypeId = AriRequest::getParam('questionTypeId', '');
		
		$fields = AriWebHelper::translateRequestValues('zQuiz');
		$fields['QuestionCategoryId'] = AriRequest::getParam('BankCategoryId', null);

		$questionType = $this->_questionController->call('getQuestionType', $questionTypeId);
		$questionObj = AriEntityFactory::createInstance($questionType->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
		$data = $questionObj->getXml();
		$files = AriWebHelper::translateRequestValues('zQuizFiles');

		$score = @intval(AriUtils::getParam($fields, 'Score', 0), 10);
		$fields['Score'] = $questionObj->getMaximumQuestionScore($score, $data);

		return $this->_questionController->call('saveQuestion',
			AriRequest::getParam('questionId', 0),
			$quizId, 
			$questionTypeId, 
			$ownerId, 
			$fields,
			$data,
			$files);
	}
}
?>