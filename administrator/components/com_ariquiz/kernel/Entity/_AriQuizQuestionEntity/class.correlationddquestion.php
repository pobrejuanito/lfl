<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Entity._AriQuizQuestionEntity.QuestionBase');
AriKernel::import('Entity._AriQuizQuestionEntity.correlationquestion');
AriKernel::import('Entity._AriQuizQuestionEntity._Templates.QuestionTemplates');
AriKernel::import('Web.JSON.JSONHelper');

class CorrelationDDQuestion extends CorrelationQuestion 
{
	function getFrontXml($questionId)
	{
		$correlation = AriRequest::getParam('hidCorrelation_' . $questionId, array());
		$correlation = AriJSONHelper::decode($correlation);
		
		$variant = array();
		if (!empty($correlation))
		{
			foreach ($correlation as $item)
			{
				$variant[$item['labelId']] = $item['answerId'];
			}
		}
		
		return $this->_createFrontXml($variant);
	}
}
?>