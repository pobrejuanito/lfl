<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.AriQuiz.CategoryControllerBase');
AriKernel::import('Controllers.AriQuiz.QuestionBankController');

class AriQuizQuestionBankCategoryController extends AriQuizCategoryControllerBase 
{
	var $_tableName = '#__ariquizbankcategory';
	var $_entityName = 'AriQuizBankCategoryEntity';
	
	function deleteCategory($idList, $deleteQuestions = false)
	{	
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$result = parent::deleteCategory($idList);
		
		$database =& JFactory::getDBO();
		
		$catStr = join(',', $this->_quoteValues($idList));
		if ($deleteQuestions)
		{
			$query = sprintf('SELECT QQ.QuestionId' .
				' FROM #__ariquizquestion QQ' .
				' WHERE QQ.QuizId = 0 AND QQ.QuestionCategoryId IN (%s)',
				$catStr);
			$database->setQuery($query);
			$queIdList = $database->loadResultArray();
			if ($database->getErrorNum())
			{
				return false;
			}

			$bankController = new AriQuizQuestionBankController();
			$bankController->call('deleteQuestion', $queIdList);
			if ($bankController->_isError(true, false))
			{
				return false;
			}
		}

		$query = sprintf('UPDATE #__ariquizquestion QQ, #__ariquizquestionversion QQV' . 
			' SET QQ.QuestionCategoryId = 0, QQV.QuestionCategoryId = 0' . 
			' WHERE QQ.QuestionVersionId = QQV.QuestionVersionId AND QQ.QuizId = 0 AND QQ.QuestionCategoryId IN (%s)',
			$catStr);
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			return false;
		}
		
		return true;
	}
}
?>