<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');
AriKernel::import('Components.AriQuiz.Util');
AriKernel::import('Controllers.AriQuiz.UserQuizController');

class take_quizAriPage extends AriPageBase
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
		$ticketId = AriRequest::getParam('ticketId', '');
		
		if (!AriQuizUtils::checkQuizAvailability($userId, $ticketId)) return ;

		$errorMessage = '';
		$questionCount = 0;
		$isQuizComposed = $this->_userQuizController->composeUserQuiz($quizId, $ticketId, $userId, $questionCount);

		if (!$isQuizComposed)
		{
			AriQuizUtils::redirectToInfo('FrontEnd.QuizNotAvailable');			
		}
		else if ($questionCount == 0)
		{
			AriQuizUtils::redirectToInfo('Error.QuizNotHaveQuestions');
		}
		else 
		{
			AriResponse::redirect(
				AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=question&ticketId=' . $ticketId . '&Itemid=' . $Itemid, false, false));
		}
	}
}
?>