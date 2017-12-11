<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');
AriKernel::import('Controllers.AriQuiz.UserQuizController');

class quiz_listAriPage extends AriPageBase
{
	var $_userQuizController;

	function _init()
	{
		$this->_userQuizController = new AriUserQuizController();
		
		parent::_init();
	}
	
	function execute()
	{
		$quizList = $this->_userQuizController->call('getUserQuizList');
		$this->addVar('quizList', $quizList);
		
		parent::execute();
	}
}
?>
