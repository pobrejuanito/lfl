<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSONHelper');
AriKernel::import('Xml.SimpleXmlHelper');
AriKernel::import('Web.Controls.Advanced.MultiplierControls');

class AriQuizLMSImportMultipleQuestion extends AriQuizLMSImportQuestionBase
{
	var $_type = 'MultipleQuestion';

	/*
	[chkMQRandomizeOrder] => 1
    [cbCorrect_0] => true
    [tbxAnswer_0] => Answer 1
    [hidQueId_0] => 4b618dac069f50.10167037
    [tblQueContainer_hdnstatus_0] => 
    [tbxAnswer_1] => Answer 2
    [hidQueId_1] => 4b618dac06b096.99581238
    [tblQueContainer_hdnstatus_1] => 
    [cbCorrect_2] => true
    [tbxAnswer_2] => Answer 3
    [hidQueId_2] => 4b618dac06bf19.66739017
    [tblQueContainer_hdnstatus_2] => 
    [hidPercentScore] => [{"correct":[false,true,false],"id":"","override":false,"score":31},{"correct":[true,false,true],"id":"","override":false,"score":34}]  
	 */
	function getXml($questionId, &$questionNode, &$optionsNode)
	{
		$request = $_REQUEST;

		$options = $this->getOptions($questionId, $optionsNode);
		$i = 0;
		foreach ($options as $option)
		{
			$answer = $option['answer'];
			$correct = $option['correct'];

			$_REQUEST['tbxAnswer_' . $i] = $answer;
			$_REQUEST['tblQueContainer_hdnstatus_' . $i] = '';
			if ($correct)
				$_REQUEST['cbCorrect_' . $i] = 'true';

			++$i;
		}
		
		$xml = $this->_question->getXml();
		$_REQUEST = $request;

		return $xml;
	}
	
	function getOptions($questionId, &$optionsNode)
	{
		$options = array();
		
		if ($questionId < 1 || empty($optionsNode))
			return $options;
			
		$choicesNode =& AriSimpleXmlHelper::getSingleNode($optionsNode, 'choice_data');
		if (empty($choicesNode))
			return $options;

		$choicesNode =& AriSimpleXmlHelper::getNode($choicesNode, 'quest_choice');
		if (empty($choicesNode))
			return $options;
			
		foreach ($choicesNode as $choiceNode)
		{
			if ($choiceNode->attributes('c_question_id') != $questionId)
				continue ;

			$answer = AriSimpleXmlHelper::getData($choiceNode, 'choice_text');
			if (empty($answer))
				continue ;

			$options[@intval($choiceNode->attributes('ordering'), 10)] = array(
				'answer' => $answer,
				'correct' => AriUtils::parseValueBySample($choiceNode->attributes('c_right'), false)
			);
		}
		
		return $options;
	}
}
?>