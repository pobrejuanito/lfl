<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Controllers.AriQuiz.QuestionCategoryController');

class questioncategory_listAriPage extends AriAdminSecurePageBase 
{
	var $_persistanceKey = 'dtQCategories';
	
	function execute()
	{
		$quizId = AriRequest::getParam('quizId', 0);
		
		$dataTable = $this->_createDataTable($quizId);
		
		$this->setResTitle('Title.QuestionCategoryList');
		$this->addVar('dataTable', $dataTable);
		$this->addVar('quizId', $quizId);
				
		parent::execute();
	}
	
	function _createDataTable($quizId)
	{
		global $option;

		$dsUrl = 'index.php?option=' . $option . '&task=' . $this->executionTask . '$ajax|getQCategoryList&quizId=' . $quizId;		
		$columns = array(
			new AriDataTableControlColumn(array('key' => '', 'label' => AriWebHelper::translateResValue('Label.NumberPos'), 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatPosition', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'QuestionCategoryId', 'label' => '<input type="checkbox" class="adtCtrlCheckbox" />', 'formatter' => 'YAHOO.ARISoft.widgets.dataTable.formatters.formatCheckbox', 'className' => 'dtCenter dtColMin')),
			new AriDataTableControlColumn(array('key' => 'CategoryName', 'label' => AriWebHelper::translateResValue('Label.Name'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQCategory')),
			new AriDataTableControlColumn(array('key' => 'QuizName', 'label' => AriWebHelper::translateResValue('Label.Quiz'), 'sortable' => true, 'formatter' => 'YAHOO.ARISoft.Quiz.formatters.formatQuiz')),
			new AriDataTableControlColumn(array('key' => 'QuizId', 'label' => '', 'hidden' => true))
		);

		$dataTable = new AriMultiPageDataTableControl(
			$this->_persistanceKey,
			$columns, 
			array('dataUrl' => $dsUrl));

		return $dataTable;
	}

	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('delete', 'ajaxDelete');
		$this->_registerAjaxHandler('getQCategoryList', 'ajaxGetQCategoryList');
		$this->_registerAjaxHandler('massEdit', 'ajaxMassEdit');
	}
	
	function ajaxMassEdit()
	{
		$my =& JFactory::getUser();
		
		$ownerId = $my->get('id');

		$fields = AriWebHelper::translateRequestValues('MassEdit');
		$qCategoryController = new AriQuizQuestionCategoryController();
		$result = $qCategoryController->call('updateQuestionCategory',
			AriRequest::getParam('QuestionCategoryId', null), 
			$fields, 
			$ownerId);
		
		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxDelete()
	{
		$qCategoryController = new AriQuizQuestionCategoryController();
		$result = ($qCategoryController->call('deleteQuestionCategory',
			AriRequest::getParam('QuestionCategoryId', null),
			AriRequest::getParam('zq_deleteQuestions', false)) && !$this->_isError());

		AriResponse::sendJsonResponse($result);
	}
	
	function ajaxGetQCategoryList()
	{
		$quizId = AriRequest::getParam('quizId', 0);
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'CategoryName', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$categoryController = new AriQuizQuestionCategoryController();
		$totalCnt = $categoryController->call('getQuestionCategoryCount', $quizId, $filter);
		$filter->fixFilter($totalCnt);

		$categories = $categoryController->call('getQuestionCategoryList', $quizId, $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($categories, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>