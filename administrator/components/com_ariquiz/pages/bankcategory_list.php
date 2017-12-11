<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/categoryListPageBase.php';

AriKernel::import('Controllers.AriQuiz.QuestionBankCategoryController');

class bankcategory_listAriPage extends categoryListAriPage
{
	function _init()
	{
		parent::_init();
		
		$this->_ajaxDTHandler = $this->executionTask . '$ajax|getBankCategoryList';
		$this->_persistanceKey = 'dtBankCategories';
		$this->_categoryController = new AriQuizQuestionBankCategoryController();
		$this->_categoryListPage = 'bankcategory_list';
		$this->_titleResKey = 'Title.BankCategoryList';
		$this->_categoryFormatter = 'YAHOO.ARISoft.Quiz.formatters.formatBankCategory';
	}
	
	function ajaxDelete($eventArgs)
	{
		$result = ($this->_categoryController->call('deleteCategory', AriRequest::getParam('CategoryId', 0), AriRequest::getParam('zq_deleteQuestions', false)) && !$this->_isError());
		
		AriResponse::sendJsonResponse($result);
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getBankCategoryList', 'ajaxGetBankCategoryList');
		
		parent::_registerAjaxHandlers();
	}
	
	function ajaxGetBankCategoryList()
	{
		$filter = new AriDataFilter(
			array('startOffset' => 0, 'limit' => 10, 'sortField' => 'CategoryName', 'dir' => 'asc'), 
			true, 
			$this->_persistanceKey);

		$totalCnt = $this->_categoryController->call('getCategoryCount', $filter);
		$filter->fixFilter($totalCnt);

		$categories = $this->_categoryController->call('getCategoryList', $filter);
		$data = AriMultiPageDataTableControl::createDataInfo($categories, $filter, $totalCnt); 

		AriResponse::sendJsonResponse($data);
	}
}
?>