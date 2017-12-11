<?php
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

	$isCorrect = ($queItem->MaxScore == $queItem->Score);
	$specificQuestion = AriEntityFactory::createInstance($queItem->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	$baseData = $specificQuestion->getDataFromXml($queItem->BaseData);
	$data = $specificQuestion->getDataFromXml($queItem->Data);

	$ansData = array();
	$correctIdList = array();
	if (!empty($baseData))
	{
		foreach ($baseData as $dataItem)
		{
			$ansData[$dataItem['hidQueId']] = $dataItem['tbxAnswer'];
			if (!empty($dataItem['cbCorrect'])) $correctIdList[] = $dataItem['hidQueId']; 
		}
	}

	$selIdList = array();
	if (!empty($data))
	{
		$keys = array_keys($ansData);
		foreach ($data as $dataItem)
		{
			$id = $dataItem['hidQueId'];
			if (in_array($id, $keys)) $selIdList[] = $id; 
		}
	}
?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td><?php AriWebHelper::displayResValue('Label.YouChoose'); ?>: </td>
		<td>
			<ul>
			<?php
				if (!empty($selIdList))
				{
					foreach ($selIdList as $selId)
					{ 
			?>
				<li><?php AriWebHelper::displayDbValue($ansData[$selId]); ?>
				<br/>
			<?php
					}
				}
			?>
			</ul>
		</td>
	</tr>
<?php
if (!$isCorrect)
{
?>
	<tr valign="top">
		<td><?php AriWebHelper::displayResValue('Label.CorrectAnswerIs'); ?>: </td>
		<td>
			<ul>
			<?php
				if (!empty($correctIdList))
				{
					foreach ($correctIdList as $correctId)
					{ 
						if (isset($ansData[$correctId]))
						{
			?>
				<li><?php AriWebHelper::displayDbValue($ansData[$correctId]); ?>
				<br/>
			<?php
						}
					}
				}
			?>
			</ul>
		</td>
	</tr>
<?php
}
?>
</table>