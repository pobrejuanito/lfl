<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.PageBase');
AriKernel::import('Controllers.AriQuiz.UserQuizController');
AriKernel::import('Controllers.AriQuiz.CategoryController');

class cat_quiz_listAriPage extends AriPageBase
{
	var $_userQuizController;
	var $_categoryController;

	function _init()
	{
		$this->_userQuizController = new AriUserQuizController();
		$this->_categoryController = new AriQuizCategoryController();
		
		parent::_init();
	}
	
	function execute()
	{		
		
		$my =& JFactory::getUser();
		
		$categoryId = AriRequest::getParam('categoryId', 0);
		
		$category = $this->_categoryController->call('getCategory', $categoryId);
		$quizList = $this->_userQuizController->call('getUserQuizList', $categoryId);

		// Begin add by Mike
		//$quizOrder = $this->_userQuizController->call('getQuizOrder', $categoryId);
		//$quizList = $this->_userQuizController->call('sortQuizList', $quizList, $quizOrder);
		// end add by Mike

		$this->addVar('category', $category);
		$this->addVar('quizList', $quizList);
		
		// added by Mike: passes error value
		$err = $_REQUEST['err'];
		$quizErrList = $this->_userQuizController->call('getUserQuizErrList',$err);
		$this->addVar('quizErr', $quizErrList);

		// added by Mike: custom controller used from class.UserQuizController
		// passes user's passed test variable
		$passedQuiz = $this->_userQuizController->call('getPassedQuizes', $my->get('id'));
		$this->addVar('passedQuiz', $passedQuiz);
		
		// added by Mike: also uses custom controller
		// passes the next quiz id that the user should take
		$nextQuiz = $this->_userQuizController->call('getNextQuiz', $my->get('id'), $categoryId);
		$this->addVar('nextQuiz', $nextQuiz);
		
		parent::execute();
	}
}
?>