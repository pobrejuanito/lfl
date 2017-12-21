<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/categoryAddPageBase.php';

AriKernel::import('Controllers.AriQuiz.QuestionBankCategoryController');

class bankcategory_addAriPage extends categoryAddAriPage
{
	var $_categoryController;
	
	function _init()
	{
		$this->_categoryController = new AriQuizQuestionBankCategoryController();
		$this->_categoryResKey = 'Label.BankCategory';
		$this->_entityName = 'AriQuizBankCategoryEntity';
		$this->_categoryListTask = 'bankcategory_list';
		$this->_categoryTask = 'bankcategory_add';
		
		parent::_init();
	}
}
?>