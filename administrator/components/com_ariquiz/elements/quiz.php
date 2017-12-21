<?php
defined('_JEXEC') or die( 'Restricted access' );

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
AriKernel::import('Controllers.AriQuiz.QuizController');

class JElementQuiz extends JElement
{
	var	$_name = 'Quiz';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$qc = new AriQuizController();
		$quizzes = $qc->getQuizList(
			new AriDataFilter(
				array('sortField' => 'QuizName'), 
				false,
				null)
		);
		
		return JHTML::_(
			'select.genericlist', 
			$quizzes, 
			$control_name . '[' . $name . ']', 
			'class="inputbox"', 
			'QuizId', 
			'QuizName', 
			$value,
			$control_name . $name);
	}
}
