<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$mosConfig_live_site = JURI::root(true);
	$dataTable = $processPage->getVar('dataTable');
	$jsPath = $mosConfig_live_site . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
?>

<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath; ?>build/datatable/assets/skins/joomla/datatable.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath; ?>build/datatable/assets/skins/joomla/datatable-skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath;?>build/container/assets/container.css" />

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/json/json-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/container/container-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/datatable/datatable-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/paginator/paginator-min.js"></script>

<div style="text-align: right;">
	<?php AriWebHelper::displayResValue('Label.Filter'); ?> : 
		<?php $processPage->renderControl('lbFilterCategory', array('class' => 'text_area')); ?>
		<input type="button" class="button" onclick="<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('bank$ajax|filters'); return false;" value="<?php echo AriWebHelper::displayResValue('Label.Apply'); ?>" />
</div>
<br/>
<?php
	$dataTable->render(); 
?>
<div id="panelCSVImport" style="visibility: hidden;">
	<div class="hd"><?php AriWebHelper::displayResValue('Toolbar.CSVImport'); ?></div>
	<div class="bd" style="text-align: center; overflow: auto;">
		<fieldset>
			<legend><?php AriWebHelper::displayResValue('Label.UploadExportFile'); ?></legend>
			<div>
				<input type="file" id="importDataCSVFile" name="importDataCSVFile" class="text_area" size="70" />
				<input type="button" class="button" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('uploadImport'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
			</div>
		</fieldset>
		<fieldset>
			<legend><?php AriWebHelper::displayResValue('Label.ImportExportFileFromDir'); ?></legend>
			<div>
				<?php $processPage->renderControl('tbxImportDir', array('class' => 'text_area', 'size' => '70')); ?>
				<input type="button" class="button" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('importFromDir'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
			</div>
		</fieldset>
	</div>
	<div class="ft" style="text-align: center;">
		<div>
			<input type="button" class="button" value="<?php AriWebHelper::displayResValue('Toolbar.Cancel'); ?>" onclick="YAHOO.ARISoft.page.panelCSVImport.hide(); return false;" />
		</div>
	</div>
</div>
<div id="panelMassEdit" style="visibility: hidden;">
	<div class="hd"><?php AriWebHelper::displayResValue('Label.MassEdit'); ?></div>  
	<div class="bd ari-settings-group" style="text-align: center; overflow: auto;">
		<input type="checkbox" id="chkMassMainSettingsSwitcher" class="ari-settings-switcher" checked="checked" style="display: none;" />
		<table width="100%" border="0" cellpadding="3" cellspacing="0" id="tblMassSettings">
			<tr>
				<td style="width: 15%; text-align: right;">
					<label for="lbMassQuestionCategories" class="ari-dashed-line ari-setting-label"><?php AriWebHelper::displayResValue('Label.Category'); ?></label> :
				</td>
				<td style="text-align: left;">
					<?php $processPage->renderControl('lbMassQuestionCategories', array('class' => 'text_area')); ?>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">
					<label for="tbxMassScore" class="ari-dashed-line ari-setting-label"><?php AriWebHelper::displayResValue('Label.Score'); ?></label> :
				</td>
				<td style="text-align: left;">
					<input type="text" id="tbxMassScore" name="tbxMassScore" size="4" />
				</td>
			</tr>
		</table>
	</div>
	<div class="ft" style="text-align: center;">
		<div>
			<input type="button" class="button" value="<?php AriWebHelper::displayResValue('Toolbar.Apply'); ?>" onclick="YAHOO.ARISoft.page.pageManager.triggerAction('applyMassEdit');" />
			<input type="button" class="button" value="<?php AriWebHelper::displayResValue('Label.Clear'); ?>" onclick="this.form.reset();YAHOO.ARISoft.page.pageManager.massEditSettings.resetSettings();" />
			<input type="button" class="button" value="<?php AriWebHelper::displayResValue('Toolbar.Cancel'); ?>" onclick="YAHOO.ARISoft.page.panelMassEdit.hide(); return false;" />
		</div>
		<div style="text-align: left;">
			<br/>
			<b><?php AriWebHelper::displayResValue('Label.Note'); ?> :</b> <?php AriWebHelper::displayResValue('Text.MassEditNote'); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function()
{
	var page = YAHOO.ARISoft.page,
		pageManager = page.pageManager,
		aDom = YAHOO.ARISoft.DOM,
		validators = YAHOO.ARISoft.validators;

	aDom.moveTo(YAHOO.ARISoft.DOM.wrapWithElement('form', 'panelMassEdit', {id: 'frmMassEdit', name: 'frmMassEdit'}));
	
	/* Mass edit settings panel */
	pageManager.massEditSettings = new YAHOO.ARISoft.widgets.settingsPanel('panelMassEdit', {});

	page.panelMassEdit = new YAHOO.widget.Panel("panelMassEdit", 
		{ width:"510px", height:"140px", visible:false, constraintoviewport:true, modal:true, fixedcenter: "contained", zIndex: 200});   
	page.panelMassEdit.render();
	
	/* CSV import panel */
	page.panelCSVImport  = new YAHOO.widget.Panel("panelCSVImport", 
		{ width:"510px", height:"170px", visible:false, constraintoviewport:true, modal:true, fixedcenter: "contained", zIndex: 200});   
	page.panelCSVImport.render();

	pageManager.registerActionGroup('questionAction',
	{
		onAction: page.actionHandlers.simpleDatatableAction,
		dataTable: <?php echo $dataTable->id; ?>,
		enableValidation: true,
		errorMessage: '<?php AriWebHelper::displayResValue('Label.ActionFailure'); ?>',
		completeMessage: '',
		loadingMessage: '<img src="<?php echo $mosConfig_live_site; ?>/administrator/components/<?php echo $option; ?>/images/loading.gif" border="0" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;<?php AriWebHelper::displayResValue('Label.Loading'); ?>'
	});
	pageManager.registerAction('bank$ajax|delete',
	{
		group: 'questionAction',
		completeMessage: '<?php AriWebHelper::displayResValue('Complete.QuestionDelete'); ?>'
	});
	pageManager.registerAction('bank$ajax|filters',
	{
		group: 'questionAction'
	});
	pageManager.registerAction('bank$ajax|massEdit',
	{
		onAction: function(action, config)
		{
			config.postData = YAHOO.util.Connect.setForm('frmMassEdit');
		
			page.actionHandlers.simpleDatatableAction.call(this, action, config);
		},
		group: 'questionAction',
		completeMessage: '<?php AriWebHelper::displayResValue('Complete.MassEdit'); ?>'
	});
	pageManager.registerAction('applyMassEdit',
	{
		onAction: function()
		{
			if (!validators.alertSummaryValidators.validate(['massEdit'])) return ;

			page.panelMassEdit.hide();
			pageManager.triggerAction('bank$ajax|massEdit');
		}
	});
	pageManager.registerAction('mass_edit',
	{
		onAction: function()
		{
			page.panelMassEdit.show();
		}
	});
	pageManager.registerAction('csv_import',
	{
		onAction: function()
		{
			page.panelCSVImport.show();
		}
	});
	pageManager.registerAction('uploadImport',
	{
		onAction: function()
		{
			if (validators.alertSummaryValidators.validate(['<?php echo $processPage->VG_IMPORT_UPLOAD; ?>']))
			{
				pageManager.triggerAction('<?php echo $processPage->executionTask . '$uploadCSVImport'; ?>');
			}
		}
	});
	pageManager.registerAction('importFromDir',
	{
		onAction: function()
		{
			if (validators.alertSummaryValidators.validate(['<?php echo $processPage->VG_IMPORT_DIR; ?>']))
			{
				pageManager.triggerAction('<?php echo $processPage->executionTask . '$csvImportFromDir'; ?>');
			}
		}
	});
	
	validators.validatorManager.addValidator(
		new validators.requiredValidator('importDataCSVFile',
			{validationGroups: ['<?php echo $processPage->VG_IMPORT_UPLOAD; ?>'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.ImportFileRequired'); ?>'}));
});

YAHOO.ARISoft.validators.validatorManager.addValidator(
	new YAHOO.ARISoft.validators.customValidator('tbxMassScore',
		function(val)
		{
			if (YAHOO.ARISoft.page.pageManager.massEditSettings.isDisabledSettingEl(val.ctrlId)) return true;
			
			var validators = YAHOO.ARISoft.validators.validatorManager.getFailedValidator(['massEditScore']);
			if (validators.length == 0) return true;

			val.errorMessage = validators[0].errorMessage;
			
			return false;
		},
		{
			validationGroups: ['massEdit']
		}));
YAHOO.ARISoft.validators.validatorManager.addValidator(
	new YAHOO.ARISoft.validators.requiredValidator('tbxMassScore',
		{
			validationGroups: ['massEditScore'], 
			errorMessage : '<?php AriWebHelper::displayResValue('Validator.QuestionScoreRequired'); ?>'
		}));
YAHOO.ARISoft.validators.validatorManager.addValidator(
	new YAHOO.ARISoft.validators.rangeValidator('tbxMassScore', 0, null, YAHOO.ARISoft.validators.rangeValidatorType.int,
		{
			validationGroups: ['massEditScore'], 
			errorMessage : '<?php AriWebHelper::displayResValue('Validator.QuestionScore'); ?>'
		}));
YAHOO.ARISoft.validators.validatorManager.addValidator(
	new YAHOO.ARISoft.validators.customValidator('cvMassEditSettings',
		function(val)
		{
			return YAHOO.ARISoft.page.pageManager.massEditSettings.getActiveElementsCount() > 0;
		},
		{validationGroups: ['massEdit'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.MassEditSettingsRequired'); ?>'}));
YAHOO.ARISoft.validators.validatorManager.addValidator(
	new YAHOO.ARISoft.validators.customValidator('cvMassEditCount',
		function(val)
		{
			return YAHOO.ARISoft.widgets.dataTable.utils.isCheckedCheckboxField(<?php echo $dataTable->id; ?>, 'yui-dt-col-QuestionId');
		},
		{validationGroups: ['massEdit'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.SelectAtLeastOneItem'); ?>'}));
</script>