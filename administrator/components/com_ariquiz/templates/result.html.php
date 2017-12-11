<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$dataTable = $processPage->getVar('dataTable');
	$rootPath = JURI::root(true) . '/components/' . $option . '/';
	$jsPath = $rootPath . 'js/';
	$jsYuiPath = $jsPath . 'yui/';
	$quizId = $processPage->getVar('quizId');
	$statisticsInfoId = $processPage->getVar('statisticsInfoId');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath; ?>build/datatable/assets/skins/joomla/datatable.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath; ?>build/datatable/assets/skins/joomla/datatable-skin.css" />

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/json/json-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/datatable/datatable-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/paginator/paginator-min.js"></script>

<div style="text-align: right;">
	<b><?php AriWebHelper::displayResValue('Label.PreviewTemplate'); ?> : </b>
	<?php $processPage->renderControl('lbTextTemplates', array('class' => 'text_area')); ?>
</div>
<br/>
<div class="">
<?php
	$dataTable->render(); 
?>
</div>
<input type="hidden" name="StatisticsInfoId" value="<?php echo $statisticsInfoId; ?>" />
<input type="hidden" name="quizId" value="<?php echo $quizId;?>" />
<script type="text/javascript">
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'result$res_template')
		{
			var ddlTemplate = document.getElementById('lbTextTemplates');
			if (ddlTemplate && ddlTemplate.value)
			{
				window.open('index3.php?option=<?php echo $option; ?>&task=texttemplate_preview&sid=<?php echo $statisticsInfoId; ?>&templateId=' + ddlTemplate.value, 'blank');
			}
			return;
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
		if (pressbutton == 'result$tocsv' || pressbutton == 'result$toexcel' || pressbutton == 'result$tohtml' || pressbutton == 'result$toword')
		{
			document.getElementById('task').value = 'result';
		}
	}
</script>