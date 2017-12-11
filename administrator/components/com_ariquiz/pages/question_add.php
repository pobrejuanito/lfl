<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/questionAddPageBase.php';

class question_addAriPage extends AriQuestionAddPageBase
{
	function _init()
	{
		parent::_init();

		$this->_task = 'question_add';
		$this->_taskList = 'question_list';
		$this->_mode = AriConstantsManager::getVar('Mode.None', AriQuestionUiConstants::getClassName());
		$this->task = $this->_task;
	}
	
	function _saveQuestion()
	{
		$my =& JFactory::getUser();		
		$ownerId = $my->get('id');
		$quizId = AriRequest::getParam('quizId', 0);
		$data = '';
		
		$questionTypeId = 0;
		//$bankQuestionId = AriRequest::getParam('ddlBank', 0);
		$bankQuestionId = $this->_bankQuestionId;
		$fields = array();
		if ($bankQuestionId)
		{
			$bankQuestion = $this->_questionController->call('getQuestion', $bankQuestionId, false, false);
			$questionTypeId = $bankQuestion->QuestionTypeId;
			$questionType = $this->_questionController->call('getQuestionType', $questionTypeId);
			$questionObj = AriEntityFactory::createInstance($questionType->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
			
			$data = $questionObj->getOverrideXml();

			$zQuiz = AriRequest::getParam('zQuiz', array());
			$fields['BankQuestionId'] = $bankQuestionId;
			$fields['QuestionCategoryId'] = $zQuiz['QuestionCategoryId'];

			if ($questionObj->isScoreSpecific())
			{
				$fields['Score'] = 0;
			}
			else
			{
				$chkOverrideScore = AriRequest::getParam('chkOverrideScore', false);
				if ($chkOverrideScore)
				{
					if (is_array($zQuiz) && array_key_exists('Score', $zQuiz)) $score = $zQuiz['Score'];
	
					if ($score)
					{
						$fields['Score'] = $score;
					}
				}
			}			
		}
		else
		{
			$questionTypeId = AriRequest::getParam('questionTypeId', '');
			$fields = AriWebHelper::translateRequestValues('zQuiz');
			$fields['BankQuestionId'] = 0;
			$questionType = $this->_questionController->call('getQuestionType', $questionTypeId);
			$questionObj = AriEntityFactory::createInstance($questionType->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));

			$data = $questionObj->getXml();
			
			$score = @intval(AriUtils::getParam($fields, 'Score', 0), 10);
			$fields['Score'] = $questionObj->getMaximumQuestionScore($score, $data);
		}

		$files = AriWebHelper::translateRequestValues('zQuizFiles');

		return $this->_questionController->call('saveQuestion',
			AriRequest::getParam('questionId', 0),
			$quizId, 
			$questionTypeId, 
			$ownerId, 
			$fields,
			$data,
			$files);
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getBankByCategory', 'ajaxGetBankByCategory');
	} 
	
	function ajaxGetBankByCategory()
	{
		$categoryId = AriRequest::getParam('categoryId', null);
		if (!is_null($categoryId))
		{
			$categoryId = @intval($categoryId, 10);
			if ($categoryId < 0) $categoryId = null;
		}

		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => null, 'sortField' => 'Question', 'dir' => 'asc', 'filter' => array('CategoryId' => $categoryId)), 
			false);

		$totalCnt = $this->_bankController->call('getQuestionCount', $filter);
		$filter->fixFilter($totalCnt);

		$bank = $this->_bankController->call('getQuestionList', $filter);

		AriResponse::sendJsonResponse($bank);
	}
}
?>