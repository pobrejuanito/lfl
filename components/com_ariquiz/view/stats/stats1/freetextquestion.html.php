<?php
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

	$isCorrect = ($queItem->MaxScore == $queItem->Score);
	$specificQuestion = AriEntityFactory::createInstance($queItem->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	$baseData = $specificQuestion->getDataFromXml($queItem->BaseData);
	$data = $specificQuestion->getDataFromXml($queItem->Data);

	$userAnswer = !empty($data) && count($data) > 0 ? $data[0]['tbxAnswer'] : '';
?>

<table cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td><?php AriWebHelper::displayResValue('Label.YouChoose'); ?>: </td>
		<td>
			<?php AriWebHelper::displayDbValue($userAnswer); ?>
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
			if (!empty($baseData))
			{
				foreach ($baseData as $dataItem)
				{
			?>
				<li><?php AriWebHelper::displayDbValue($dataItem['tbxAnswer']); ?>
				<br/>
			<?php
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