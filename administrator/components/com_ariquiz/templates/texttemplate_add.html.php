<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$params = $processPage->getVar('params');
	$templateId = $processPage->getVar('templateId');
	$edValue =& $processPage->getControl('edValue');
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>

<?php AriJoomlaBridge::loadOverlib(); ?>
<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="3"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbGTempSettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('tbxTemplateName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.Text'); ?> :</td>
			<td align="left">
				<?php
					$processPage->renderControl('edValue', array('width' => '100%;', 'height' => 250, 'cols' => 60, 'rows' => 20)); 
				?>
			</td>
			<td>
				<?php AriWebHelper::displayResValue('Label.Params'); ?> :<br />
				<?php
					if (!empty($params))
					{
						$tooltipText = AriWebHelper::translateResValue('Label.Tooltip');
						foreach ($params as $param)
						{
				?>
						<a href="javascript:void(0);" onclick="YAHOO.ARISoft.page.addParamToText('<?php echo sprintf('{$%s}', $param->ParamName); ?>'); return false;">{$<?php AriWebHelper::displayDbValue($param->ParamName); ?>}</a>
						<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateDbValue($param->ParamDescription), $tooltipText); ?><br />
				<?php
						}
					}
				?>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="templateId" value="<?php echo $templateId; ?>" />
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.addParamToText = function(paramName)
	{
		if (typeof(tinyMCE) != 'undefined' && tinyMCE.execCommand)
		{
			tinyMCE.execCommand('mceInsertContent', false, paramName);
		}
	};

	YAHOO.ARISoft.page.valueValidate = function(val)
	{
		var value = <?php echo $edValue->getContent(); ?>;
		var isValid = (value && value.replace(/^\s+|\s+$/g, '').length > 0);

		return isValid;
	};

	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'texttemplate_add$save' || pressbutton == 'texttemplate_add$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>