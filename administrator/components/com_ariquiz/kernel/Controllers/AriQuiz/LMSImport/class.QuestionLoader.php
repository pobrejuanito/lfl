<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.AriQuiz.LMSImport.Questions.QuestionBase');

class AriQuizLMSImportQuestionLoader
{
	function getQuestion($type)
	{
		static $questions = array();
		
		$instance = null;
		if (array_key_exists($type, $questions))
		{
			$className = $questions[$type];
			return new $className();
		}
		
		if (!preg_match('/^[A-z]+$/', $type)) 
			return $instance;
			
		$questionPath = dirname(__FILE__) . '/Questions/class.' . $type . '.php';
		if (file_exists($questionPath) && is_file($questionPath))
		{
			require_once $questionPath;
			 
			$className = 'AriQuizLMSImport' . $type;
			if (class_exists($className))
			{
				$questions[$type] = $className;
				$instance = new $className();
			}
		}
		
		return $instance;
	}
}
?>