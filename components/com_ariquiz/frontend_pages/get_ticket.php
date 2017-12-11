<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');
AriKernel::import('Controllers.AriQuiz.UserQuizController');
AriKernel::import('Event.EventController');

class get_ticketAriPage extends AriPageBase
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

		$generateTicketId = false;
		$isAnonymous = empty($userId);
		$ticketId = '';
		if (!$isAnonymous)
		{
			$ticketId = $this->_userQuizController->call('getNotFinishedTicketId', $quizId, $userId);
			if (empty($ticketId))
			{
				$generateTicketId = true;
			}
		}
		else 
		{
			if (isset($_COOKIE['ariQuizTicketId']))
			{
				$statisticsInfoId = $this->_userQuizController->call('getStatisticsInfoIdByTicketId', $_COOKIE['ariQuizTicketId'], 0, array('Process', 'Prepare'), $quizId);				
				if (!empty($statisticsInfoId))
				{
					$ticketId = $_COOKIE['ariQuizTicketId'];
				}
				else 
				{
					setcookie('ariQuizTicketId', '', time() - 3600);
					$generateTicketId = true;
				}
			}
			else
			{
				$generateTicketId = true;
			}
		}

		if ($generateTicketId)
		{
			$canTakeQuiz = $this->_userQuizController->call('canTakeQuiz', $quizId, $userId, $my->get('usertype'));
			if ($canTakeQuiz)
			{
				$extraData = AriRequest::getParam('extraData', null);
				AriEventController::raiseEvent('onBeforeStartQuiz', array('QuizId' => $quizId, 'ExtraData' => $extraData, 'UserId' => $userId));
				
				$ticketId = $this->_userQuizController->call('createTicketId', $quizId, $userId, $extraData);
				if ($isAnonymous)
				{
					setcookie('ariQuizTicketId', $ticketId, time()+ 3 * 24 * 3600, '/');
					
					setcookie('aq_email', '', time() - 24 * 3600, '/');
					setcookie('aq_name', '', time() - 24 * 3600, '/');

					if (!empty($extraData['Email'])) setcookie('aq_email', trim($extraData['Email']), time()+ 365 * 24 * 3600, '/');
					if (!empty($extraData['UserName'])) setcookie('aq_name', trim($extraData['UserName']), time()+ 365 * 24 * 3600, '/');
				}
			}
			else
			{
				AriResponse::redirect(
					AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=quiz&quizId=' . $quizId . '&Itemid=' . $Itemid, false, false));
			}
		}

		AriResponse::redirect(
			AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=take_quiz&quizId=' . $quizId . '&ticketId=' . $ticketId . '&Itemid=' . $Itemid, false, false));
	}
}
?>