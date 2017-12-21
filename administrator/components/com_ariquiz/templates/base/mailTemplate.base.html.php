<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

	$edTemplate =& $processPage->getControl('edTemplate');
	$params = $processPage->getVar('params');
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>

<?php AriJoomlaBridge::loadOverlib(); ?>
<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="3"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbQuizSettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('tbxTemplateName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.FromName'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('tbxFromName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.From'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('tbxFrom', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<!--tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.AllowHtml'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('chkAllowHtml'); ?></td>
		</tr-->
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Subject'); ?> :</td>
			<td align="left" colspan="2"><?php $processPage->renderControl('tbxSubject', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.Template'); ?> :</td>
			<td align="left">
				<?php
					$processPage->renderControl('edTemplate', array('width' => '100%;', 'height' => 250, 'cols' => 60, 'rows' => 20)); 
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
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.addParamToText = function(paramName)
	{
		if (typeof(tinyMCE) != 'undefined' && tinyMCE.execCommand)
		{
			tinyMCE.execCommand('mceInsertContent', false, paramName);
		}
	};
	
	YAHOO.ARISoft.page.templateValidate = function(val)
	{
		var value = <?php echo $edTemplate->getContent(); ?>;
		var isValid = (value && value.replace(/^\s+|\s+$/g, '').length > 0);

		return isValid;
	};

	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == '<?php echo $processPage->executionTask; ?>$save' || pressbutton == '<?php echo $processPage->executionTask; ?>$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	};
</script>