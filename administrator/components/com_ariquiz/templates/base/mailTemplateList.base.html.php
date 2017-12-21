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

<?php
	$dataTable->render(); 
?>
<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function()
{
	YAHOO.ARISoft.page.pageManager.registerActionGroup('templateAction',
	{
		onAction: YAHOO.ARISoft.page.actionHandlers.simpleDatatableAction,
		dataTable: <?php echo $dataTable->id; ?>,
		enableValidation: true,
		errorMessage: '<?php AriWebHelper::displayResValue('Label.ActionFailure'); ?>',
		completeMessage: '',
		loadingMessage: '<img src="<?php echo $mosConfig_live_site; ?>/administrator/components/<?php echo $option; ?>/images/loading.gif" border="0" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;<?php AriWebHelper::displayResValue('Label.Loading'); ?>'
	});
	YAHOO.ARISoft.page.pageManager.registerAction('<?php echo $processPage->executionTask; ?>$ajax|delete',
	{
		group: 'templateAction',
		completeMessage: '<?php AriWebHelper::displayResValue('Complete.TemplateDelete'); ?>'
	});
});
</script>