<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizCSVImportQuestionBase extends AriObject
{
	var $_type;
	
	function __construct()
	{
		$this->_question = AriEntityFactory::createInstance(
			$this->_type, 
			AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	}
	
	function getXml($data)
	{
		return null;
	}
	
	function getMaximumQuestionScore($score, $xml)
	{
		return $this->_question->getMaximumQuestionScore($score, $xml);
	}
}
?>