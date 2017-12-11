<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.AriQuiz.CategoryControllerBase');

class AriQuizCategoryController extends AriQuizCategoryControllerBase
{
	var $_tableName = '#__ariquizcategory';
	var $_entityName = 'AriQuizCategoryEntity'; 	
}
?>