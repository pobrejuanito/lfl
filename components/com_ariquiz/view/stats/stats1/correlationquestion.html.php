<?php
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

	$isCorrect = ($queItem->MaxScore == $queItem->Score);
	$specificQuestion = AriEntityFactory::createInstance($queItem->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	$baseData = $specificQuestion->getDataFromXml($queItem->BaseData);
	$data = $specificQuestion->getDataFromXml($queItem->Data);
	
	$prepareXData = array();
	if ($data)
	{
		foreach ($data as $dataItem)
		{
			$prepareXData[$dataItem['hidLabelId']] = $dataItem['hidAnswerId']; 
		}
	}
	
	$answers = array();
	if ($baseData)
	{
		foreach ($baseData as $dataItem)
		{
			$answers[$dataItem['hidAnswerId']] = $dataItem['tbxAnswer']; 
		}
	}
?>
<table cellpadding="0" cellspacing="0" border="0" class="ariQuizResultCorrelation">
	<tr>
		<td colspan="2"><?php AriWebHelper::displayResValue('Label.YouChoose'); ?>: </td>
 	</tr>
<?php
	if (!empty($baseData))
	{
		foreach ($baseData as $dataItem)
		{
?>
	<tr>
		<td><?php AriWebHelper::displayDbValue($dataItem['tbxLabel']); ?></td>
		<td style="padding-left: 5px;">
			<?php
				$lblId = $dataItem['hidLabelId'];
				if (key_exists($lblId, $prepareXData) && key_exists($prepareXData[$lblId], $answers))
				{
					AriWebHelper::displayDbValue($answers[$prepareXData[$lblId]]);
				}
			?>
		</td>
	</tr>
<?php
		}
		if (!$isCorrect)
		{
?>
	<tr>
		<td colspan="2"><br/></td>
	</tr>
	<tr>
		<td colspan="2">
			<?php AriWebHelper::displayResValue('Label.CorrectAnswerIs'); ?>:</td>
	</tr>
<?php
			foreach ($baseData as $dataItem)
			{
?>
	<tr>
		<td><?php AriWebHelper::displayDbValue($dataItem['tbxLabel']); ?></td>
		<td style="padding-left: 5px;"><?php AriWebHelper::displayDbValue($dataItem['tbxAnswer']); ?></td>
	</tr>
<?php
			}
		}
	}
?>
</table>