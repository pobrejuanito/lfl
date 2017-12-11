<?php
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

	$isCorrect = ($queItem->MaxScore == $queItem->Score);
	$specificQuestion = AriEntityFactory::createInstance($queItem->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	$baseData = $specificQuestion->getDataFromXml($queItem->BaseData);
	$data = $specificQuestion->getDataFromXml($queItem->Data);
	
	$ansData = array();
	$correctId = null;
	if (!empty($baseData))
	{
		foreach ($baseData as $dataItem)
		{
			$ansData[$dataItem['hidQueId']] = $dataItem['tbxAnswer'];
			if (!empty($dataItem['hidCorrect'])) $correctId = $dataItem['hidQueId']; 
		}
	}
	$selId = !empty($data) && count($data) > 0 ? $data[0]['hidQueId'] : null;
?>
<?php AriWebHelper::displayResValue('Label.YouChoose'); ?>: <?php if (isset($ansData[$selId])) AriWebHelper::displayDbValue($ansData[$selId]); ?>
<?php
if (!$isCorrect)
{
?>
<br/><br/>
<?php AriWebHelper::displayResValue('Label.CorrectAnswerIs'); ?>: <?php if (isset($ansData[$correctId])) AriWebHelper::displayDbValue($ansData[$correctId]); ?>
<?php
}
?>