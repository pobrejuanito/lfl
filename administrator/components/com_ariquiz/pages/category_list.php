<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/categoryListPageBase.php';

AriKernel::import('Controllers.AriQuiz.CategoryController');

class category_listAriPage extends categoryListAriPage
{
	function _init()
	{
		parent::_init();
		
		$this->_ajaxDTHandler = $this->executionTask . '$ajax|getCategoryList';
		$this->_persistanceKey = 'dtCategories';
		$this->_categoryController = new AriQuizCategoryController();
		$this->_categoryListPage = 'category_list';
		$this->_titleResKey = 'Title.CategoryList';
		$this->_categoryFormatter = 'YAHOO.ARISoft.Quiz.formatters.formatCategory';
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('getCategoryList', 'ajaxGetCategoryList');
		
		parent::_registerAjaxHandlers();
	}
	
	function ajaxGetCategoryList()
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