<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$templateId = $processPage->getVar('templateId');
	$className = $processPage->getVar('className');
	$specificQuestion = $processPage->getVar('specificQuestion');
	$questionData = $processPage->getVar('questionData');
	$modeList = AriConstantsManager::getVar('Mode', AriQuestionUiConstants::getClassName());
	$uiModeList = AriConstantsManager::getVar('UiMode', AriQuestionUiConstants::getClassName());
	$uiMode = $uiModeList['None'];
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/json/json-min.js"></script>

<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbQTemplateSettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxTemplateName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuestionType'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbQuestionType', array('class' => 'text_area', 'onchange' => ((J1_6 ? 'Joomla.submitbutton' : 'submitbutton') . '(\'qtemplate_add\')'))); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.DisableQueValidation'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkValidation', array('value' => '1')); ?></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.AdditionalSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbQuestionSettings">
		<tr>
			<td colspan="2">
				<?php
					$path = AriQuestionAddPageBase::getQuestionTemplatePath($className);
					if (!empty($path)) require_once($path);
				?>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="templateId" value="<?php echo $templateId; ?>" />
<script type="text/javascript" language="javascript">
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'qtemplate_add$save' || pressbutton == 'qtemplate_add$apply')
		{
			var disableVal = YAHOO.ARISoft.DOM.$('chkValidation').checked;
			if (!aris.validators.alertSummaryValidators.validate(disableVal ? ['QTemplateValGroup'] : null))
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>