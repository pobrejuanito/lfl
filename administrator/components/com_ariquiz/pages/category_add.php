<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/categoryAddPageBase.php';

AriKernel::import('Controllers.AriQuiz.CategoryController');

class category_addAriPage extends categoryAddAriPage
{
	var $_categoryController;
	
	function _init()
	{
		$this->_categoryController = new AriQuizCategoryController();
		$this->_categoryResKey = 'Label.Category';
		$this->_entityName = 'AriQuizCategoryEntity';
		$this->_categoryListTask = 'category_list';
		$this->_categoryTask = 'category_add';
		
		parent::_init();
	}
	
	function _registerAjaxHandlers()
	{
		$this->_registerAjaxHandler('checkCategoryName', 'ajaxCheckCategoryName');
	}
	
	function ajaxCheckCategoryName()
	{
		$name = AriWebHelper::translateAjaxRequestValue('name'); 
		$categoryId = @intval(AriRequest::getParam('categoryId', 0));
		$isUnique = $this->_categoryController->call('isUniqueCategoryName', $name, $categoryId);

		AriResponse::sendJsonResponse($isUnique);
	}
}
?>