<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Advanced.MultiplierControls');

class AriQuizQuestionBase 
{	
	function applyUserData($data, $userXml)
	{
		return $data;
	}
	
	function getClientDataFromXml($xml, $userXml, $decodeHtmlEntity = false)
	{
		return $this->getDataFromXml($xml, $decodeHtmlEntity);
	}
	
	function getDataFromXml($xml, $decodeHtmlEntity = false)
	{
		return null;
	}
	
	function getFrontXml($questionId)
	{
		return null;
	}
	
	function getXml()
	{
		return null;
	}
	
	function getOverrideXml()
	{
		return null;
	}
	
	function isCorrect($xml, $baseXml)
	{
		return false;
	}
	
	function getScore($xml, $baseXml, $score)
	{
		return $this->isCorrect($xml, $baseXml) ? $score : 0;
	}

	function correctPercent($percent)
	{
		$percent = @intval($percent, 10);
		
		return $percent > 100 ? 100 : ($percent < 0 ? 0 : $percent);
	}

	function getMaximumQuestionScore($score, $xml)
	{
		return $this->isScoreSpecific()
			? $this->calculateMaximumScore($score, $xml)
			: $score;
	}
	
	function calculateMaximumScore($score, $xml)
	{
		return $score;
	}
	
	function isScoreSpecific()
	{
		return false;
	}
}
?>