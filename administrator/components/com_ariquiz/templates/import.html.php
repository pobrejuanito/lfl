<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	if (defined('J1_6') && J1_6)
		JHTML::_('behavior.framework', 'core');
?>
<fieldset>
	<legend><?php AriWebHelper::displayResValue('Label.UploadExportFile'); ?></legend>
	<div>
		<input type="file" id="importDataFile" name="importDataFile" class="text_area" size="110" />
		<input type="button" class="button" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('uploadImport'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
	</div>
</fieldset>

<fieldset>
	<legend><?php AriWebHelper::displayResValue('Label.ImportExportFileFromDir'); ?></legend>
	<div>
		<?php $processPage->renderControl('tbxImportDir', array('class' => 'text_area', 'size' => '110')); ?>
		<input type="button" class="button" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('importFromDir'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
	</div>
</fieldset>

<fieldset>
	<legend><?php AriWebHelper::displayResValue('Label.LMSImport'); ?></legend>
	<div>
		<?php $processPage->renderControl('tbxLMSImportDir', array('class' => 'text_area', 'size' => '110')); ?>
		<input type="button" class="button" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('importLMSFromDir'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
	</div>
</fieldset>

<table class="questionNote" cellpadding="0" cellspacing="0">
	<tr>
		<td class="colMin noWrap"><b><?php AriWebHelper::displayResValue('Label.Note'); ?>:</b>&nbsp;</td>
		<td><?php AriWebHelper::displayResValue('Text.ImportWarning'); ?></td>
	</tr>
</table>

<script type="text/javascript" language="javascript">
YAHOO.util.Event.onDOMReady(function()
{
	YAHOO.ARISoft.page.pageManager.registerAction('uploadImport',
	{
		onAction: function()
		{
			if (YAHOO.ARISoft.validators.alertSummaryValidators.validate(['<?php echo $processPage->VG_IMPORT_UPLOAD; ?>']))
			{
				<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('<?php echo $processPage->executionTask . '$uploadImport'; ?>');
			}
		}
	});
	YAHOO.ARISoft.page.pageManager.registerAction('importFromDir',
	{
		onAction: function()
		{
			if (YAHOO.ARISoft.validators.alertSummaryValidators.validate(['<?php echo $processPage->VG_IMPORT_DIR; ?>']))
			{
				<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('<?php echo $processPage->executionTask . '$importFromDir'; ?>');
			}
		}
	});
	YAHOO.ARISoft.page.pageManager.registerAction('importLMSFromDir',
	{
		onAction: function()
		{
			if (YAHOO.ARISoft.validators.alertSummaryValidators.validate(['<?php echo $processPage->VG_LMSIMPORT_DIR; ?>']))
			{
				<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('<?php echo $processPage->executionTask . '$importLMSFromDir'; ?>');
			}
		}
	});
	
	
	YAHOO.ARISoft.validators.validatorManager.addValidator(
		new YAHOO.ARISoft.validators.requiredValidator('importDataFile',
			{validationGroups: ['<?php echo $processPage->VG_IMPORT_UPLOAD; ?>'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.ImportFileRequired'); ?>'}));
});
</script>