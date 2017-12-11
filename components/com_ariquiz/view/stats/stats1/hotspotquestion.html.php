<?php
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

	$isCorrect = ($queItem->MaxScore == $queItem->Score);
	$specificQuestion = AriEntityFactory::createInstance($queItem->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
	$baseData = $specificQuestion->getDataFromXml($queItem->BaseData);
	$data = $specificQuestion->getDataFromXml($queItem->Data);
	$hotspotGroup = AriConstantsManager::getVar('FileGroup.HotSpot', AriQuizComponent::getCodeName());

	$userX = !empty($data) ? $data[ARI_QUIZ_HOTSPOT_X1] : -1;
	$userY = !empty($data) ? $data[ARI_QUIZ_HOTSPOT_Y1] : -1;
	
	$x = $baseData[ARI_QUIZ_HOTSPOT_X1];
	$y = $baseData[ARI_QUIZ_HOTSPOT_Y1];
	$width = $baseData[ARI_QUIZ_HOTSPOT_X2] - $baseData[ARI_QUIZ_HOTSPOT_X1];
	$height = $baseData[ARI_QUIZ_HOTSPOT_Y2] - $baseData[ARI_QUIZ_HOTSPOT_Y1];
	
	$cacheFile = $baseData[ARI_QUIZ_HOTSPOT_IMGSRC];
	$cacheDir = JPATH_ROOT . '/administrator/components/' . $option . '/cache/files/' . $hotspotGroup . '/';
	$wwwDir = $mosConfig_live_site . '/administrator/components/' . $option . '/cache/files/' . $hotspotGroup . '/';
	$hotSpotImg = '';
	if (empty($cacheFile) || !file_exists($cacheDir . $cacheFile))
	{
		$fileId = $baseData[ARI_QUIZ_HOTSPOT_IMG];
		$fileController = new AriFileController(AriConstantsManager::getVar('FileTable', AriQuizComponent::getCodeName()));
		$cacheImageList = $fileController->call('getFileList', $hotspotGroup, array($fileId), true);
		if (!empty($cacheImageList) && count($cacheImageList) > 0)
		{
			$cacheImage = $cacheImageList[0];
			if (!file_exists($cacheDir . $cacheImage->FileId . '.' . $cacheImage->Extension))
			{
				AriFileCache::saveBinaryFile($cacheImage->Content, $cacheDir . $cacheImage->FileId . '.' . $cacheImage->Extension);
			}
			$hotSpotImg = $wwwDir . $cacheImage->FileId . '.' . $cacheImage->Extension;
		}
	}
	else
	{
		$hotSpotImg = $wwwDir . $cacheFile;
	}
?>
<?php AriWebHelper::displayResValue('Label.YouChoose'); ?>: <br/>
<div style="position: relative; text-align: left;" id="divAriHotSpotWrap">
	<div style="left: <?php echo $x; ?>px; top: <?php echo $y; ?>px; width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; font-size: 0; position: absolute; z-index: 2; background: white; opacity: 0.5; filter:alpha(opacity=50);">&nbsp;</div>
	<img style="<?php if ($userX < 0 || $userY < 0) { ?>display: none;<?php } else { ?>top: <?php echo $userY - 5; ?>px; left: <?php echo $userX - 5; ?>px;<?php } ?>position: absolute; z-index: 2;" src="<?php echo $mosConfig_live_site;?>/administrator/components/<?php echo $option; ?>/images/circle.gif" />
	<img style="position: relative;" src="<?php echo $hotSpotImg;?>" />
</div>