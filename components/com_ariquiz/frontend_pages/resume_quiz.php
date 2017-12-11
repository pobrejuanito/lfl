<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');
AriKernel::import('Components.AriQuiz.Util');
AriKernel::import('Controllers.AriQuiz.UserQuizController');
AriKernel::import('Event.EventController');

class resume_quizAriPage extends AriPageBase
{
	var $_userQuizController;
	
	function _init()
	{
		$this->_userQuizController = new AriUserQuizController();
		
		parent::_init();
	}

	function execute()
	{
		global $option, $Itemid;

		$my =& JFactory::getUser();
		$userId = $my->get('id');
		$quizId = AriRequest::getParam('quizId', 0);
		$errorCodeList = AriConstantsManager::getVar('ErrorCode.TakeQuiz', AriUserQuizControllerConstants::getClassName());
		$errorCode = $this->_userQuizController->canTakeQuiz2($quizId, $userId, $my->get('usertype'), true);

		if ($errorCode == $errorCodeList['None'])
		{
			AriResponse::redirect(
				AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=quiz&quizId=' . $quizId . '&Itemid=' . $Itemid, false, false));
		}
		else if ($errorCode == $errorCodeList['HasPausedQuiz'])
		{
			AriEventController::raiseEvent('onBeforeResumeQuiz', array('QuizId' => $quizId, 'UserId' => $userId));
			$ticketId = $this->_userQuizController->resumeQuiz($quizId, $userId);
			if (!empty($ticketId))
			{
				AriEventController::raiseEvent('onResumeQuiz', array('QuizId' => $quizId, 'UserId' => $userId, 'TicketId' => $ticketId));
				AriResponse::redirect(
					AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=question&ticketId=' . $ticketId . '&Itemid=' . $Itemid, false, false));
			}
		}

		AriQuizUtils::redirectToInfo('FrontEnd.QuizNotAvailable');
	}
}
?>