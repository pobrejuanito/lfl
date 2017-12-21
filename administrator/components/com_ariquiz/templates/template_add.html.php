<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$fileId = $processPage->getVar('fileId');
	$file = $processPage->getVar('file');
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $jsPath; ?>edit_area/edit_area_full_with_plugins.js"></script>
<script type="text/javascript">
	editAreaLoader.init({
		id: "tbxTemplate",
		start_highlight: true,
		allow_resize: "none",
		allow_toggle: true,
		toolbar: "fullscreen, |, undo, redo, |, select_font,|, change_smooth_selection, highlight, reset_highlight",
		language: "en",
		syntax: "css"	
	}); 
</script>

<?php AriJoomlaBridge::loadOverlib(); ?>
<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbTempSettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxTemplateName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Title.CSSTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxTemplate', array('class' => 'text_area', 'style' => 'width: 99%; height: 300px;')); ?></td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="fileId" value="<?php echo $fileId; ?>" />
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.templateValidate = function(val)
	{
		var value = editAreaLoader.getValue('tbxTemplate');
		var isValid = (value && YAHOO.lang.trim(value).length > 0);

		return isValid;
	};

	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'template_add$save' || pressbutton == 'template_add$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
			
			document.getElementById('tbxTemplate').value = editAreaLoader.getValue('tbxTemplate');
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>