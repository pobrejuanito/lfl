<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriQuizCSVImportMultipleSummingQuestion extends AriQuizCSVImportQuestionBase
{
	var $_type = 'MultipleSummingQuestion';

	/*
	[chkMSQRandomizeOrder] => 1
    [tbxAnswer_0] => Answer 1
    [hidQueId_0] => 4b619571535dd9.51773947
    [tbxMSQScore_0] => 12
    [tblQueContainer_hdnstatus_0] => 
    [tbxAnswer_1] => Answer 2
    [hidQueId_1] => 4b619571536b30.77889319
    [tbxMSQScore_1] => 2
    [tblQueContainer_hdnstatus_1] => 
    [tbxAnswer_2] => Answer 3
    [hidQueId_2] => 4b619571537997.52791729
    [tbxMSQScore_2] => 4
    [tblQueContainer_hdnstatus_2] =>   
	 */
	function getXml($data)
	{
		$request = $_REQUEST;
		
		$random = AriUtils::parseValueBySample(AriUtils::getParam($data, 'Randomize'), false);
		if ($random)
			$_REQUEST['chkMSQRandomizeOrder'] = '1';

		$childs = $data['_Childs'];
		$correct = false;
		$i = 0;
		foreach ($childs as $child)
		{
			$answer = trim(AriUtils::getParam($child, 'Answers', ''));
			if (empty($answer))
				continue ;
				
			$score = intval(AriUtils::getParam($child, 'Score'), 10);

			$_REQUEST['tbxAnswer_' . $i] = $answer;
			$_REQUEST['tbxMSQScore_' . $i] = $score;
			$_REQUEST['tblQueContainer_hdnstatus_' . $i] = '';

			++$i;
		}
		
		$xml = $this->_question->getXml();
		$_REQUEST = $request;

		return $xml;
	}
}
?>