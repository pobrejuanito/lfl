<?php
defined('_JEXEC') or die('Restricted access');

$basePath = dirname(__FILE__) . DS . '..' . DS;
require_once ($basePath . 'kernel' . DS . 'class.AriKernel.php');

AriKernel::import('Joomla.JoomlaBridge');
AriKernel::import('PHPCompat.CompatPHP50x');
AriKernel::import('Constants.ClassConstants');
AriKernel::import('Constants.ConstantsManager');
AriKernel::import('GlobalPrefs.GlobalPrefs');
AriKernel::import('Components.AriQuiz.AriQuiz');
AriKernel::import('Web.Utils.WebHelper');
AriKernel::import('Web.TaskManager');
AriKernel::import('Web.Response');
AriKernel::import('Controllers.AriQuiz.CategoryController');

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldCategory extends JFormField
{
	protected $type = 'Category';
	
	function getInput()
	{
		return $this->fetchElement($this->element['name'], $this->value, $this->element, $this->name);
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		$catController = new AriQuizCategoryController();
		$categories = $catController->getCategoryList(
			new AriDataFilter(
				array('sortField' => 'CategoryName'), 
				false,
				null)
		);
		
		if (!is_array($categories)) $categories = array();
		
		$emptyCat = new stdClass();
		$emptyCat->CategoryId = 0;
		$emptyCat->CategoryName = JText::_('UNCATEGORY');
		array_unshift($categories, $emptyCat);
		
		return JHTML::_(
			'select.genericlist', 
			$categories, 
			$control_name, 
			'class="inputbox"', 
			'CategoryId', 
			'CategoryName', 
			$value,
			$control_name . $name);
	}
}
?>