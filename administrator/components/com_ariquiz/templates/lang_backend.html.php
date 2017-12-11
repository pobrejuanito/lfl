<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$dataTable = $processPage->getVar('dataTable');
	$option = $processPage->getVar('option');
	$defaultLang = $processPage->getVar('defaultLang');
	$currentTask = $processPage->getVar('currentTask');
	$addTask = $processPage->getVar('addTask');
	$mosConfig_live_site = JURI::root(true);
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

<?php
	$dataTable->render(); 
?>

<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function()
{
	YAHOO.ARISoft.page.pageManager.registerActionGroup('langAction',
	{
		onAction: YAHOO.ARISoft.page.actionHandlers.simpleDatatableAction,
		dataTable: <?php echo $dataTable->id; ?>,
		enableValidation: true,
		errorMessage: '<?php AriWebHelper::displayResValue('Label.ActionFailure'); ?>',
		completeMessage: '',
		loadingMessage: '<img src="<?php echo $mosConfig_live_site; ?>/administrator/components/<?php echo $option; ?>/images/loading.gif" border="0" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;<?php AriWebHelper::displayResValue('Label.Loading'); ?>'
	});
	YAHOO.ARISoft.page.pageManager.registerAction('<?php echo $currentTask; ?>$ajax|delete',
	{
		group: 'langAction',
		completeMessage: '<?php AriWebHelper::displayResValue('Complete.LangDelete'); ?>'
	});
	YAHOO.ARISoft.page.pageManager.registerAction('import',
	{
		onAction: function()
		{
			YAHOO.ari.container.panelImport.show();
		}
	});
	YAHOO.ARISoft.page.pageManager.registerAction('<?php echo $currentTask . '$import'; ?>',
	{
		onAction: function(action)
		{
			if (YAHOO.ARISoft.validators.alertSummaryValidators.validate('import'))
			{
				<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(action);
			}
		}
	});
});
</script>
<div id="panelImport">   
	<div class="hd"><?php AriWebHelper::displayResValue('Toolbar.Import'); ?></div>  
	<div class="bd">
		<table border="0" cellspacing="1" cellpadding="1">
			<tr>
				<td style="white-space: nowrap;"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
				<td><input type="text" id="tbxLangName" name="zLang[ShortDescription]" class="text_area" size="45" /></td>
			</tr>
			<tr>
				<td style="white-space: nowrap;"><?php AriWebHelper::displayResValue('Label.File'); ?> :</td>
				<td><input type="file" id="fileLang" name="fileLang" class="text_area" size="45" /></td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="button" class="button" onclick="<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('<?php echo $currentTask . '$import'; ?>'); return false;" value="<?php AriWebHelper::displayResValue('Toolbar.Import'); ?>" />
				</td>
			</tr>
		</table>
	</div>  
	<div class="ft"></div>  
</div>
<script type="text/javascript" language="javascript">
	YAHOO.namespace("ari.container");
	YAHOO.ari.container.panelImport = new YAHOO.widget.Panel("panelImport", 
		{ width:"400px", visible:false, constraintoviewport:true, modal:true, fixedcenter: "contained", zIndex: 200});   
	YAHOO.ari.container.panelImport.render();
	
	YAHOO.ARISoft.validators.validatorManager.addValidator(
		new YAHOO.ARISoft.validators.requiredValidator('tbxLangName',
			{validationGroups : ['import'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.NameRequired'); ?>'}));   
			
	YAHOO.ARISoft.validators.validatorManager.addValidator(
		new YAHOO.ARISoft.validators.requiredValidator('fileLang',
			{validationGroups : ['import'], errorMessage : '<?php AriWebHelper::displayResValue('Validator.FileRequired'); ?>'}));
			
	YAHOO.ARISoft.validators.validatorManager.addValidator(
		new YAHOO.ARISoft.validators.customValidator('fileLang',
			function(val)
			{
				var isValid = true;

				var ext = YAHOO.ARISoft.util.getFileExtension(val.getValue());
				isValid = (ext && ext.toLowerCase() == 'xml');

				return isValid;
			},
			{errorMessage : '<?php AriWebHelper::displayResValue('Validator.FileIncorrectFormat'); ?>'}));
</script>