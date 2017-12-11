<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$infoMessage = $processPage->getInfoMessage();
	$mosConfig_live_site = JURI::root(true);
	$option = $processPage->getVar('option');
	$jsPath = $mosConfig_live_site . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$cssAdminPath = $mosConfig_live_site . '/administrator/components/' . $option . '/css/';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $cssAdminPath;?>core.css" />

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsPath; ?>ari.all.js"></script>
<script type="text/javascript" src="<?php echo $jsPath; ?>ari.quiz.js"></script>
<script type="text/javascript" src="<?php echo $jsPath; ?>ari.pageController.js"></script>
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.pageManager = new YAHOO.ARISoft.page.pageController(
		{
			baseUrl: '<?php echo $mosConfig_live_site . '/'; ?>',
			adminBaseUrl: '<?php echo $mosConfig_live_site . '/administrator/'; ?>',
			formId: 'adminForm',
			option: '<?php echo $option; ?>',
			defaultAction: function(action, config)
			{
				<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(action);
			} 
		});
	YAHOO.ARISoft.page.pageManager.subscribe('beforeAction', function(o)
	{
		YAHOO.util.Dom.get('task').value = o.action;
	});	
	YAHOO.ARISoft.page.pageManager.subscribe('sendInfoMessage', function(o)
	{
		var message = o.message;
		YAHOO.util.Dom.setStyle('ariInfoMessage', 'display', message ? 'block' : 'none');
		YAHOO.util.Dom.get('ariInfoMessage').innerHTML = message;
	});

	YAHOO.ARISoft.page.baseUrl = '<?php echo $mosConfig_live_site . '/'; ?>';
	YAHOO.ARISoft.page.adminBaseUrl = '<?php echo $mosConfig_live_site . '/administrator/'; ?>';
	YAHOO.ARISoft.page.option = '<?php echo $option; ?>';
	
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(action, options)
	{
		options = options || {};
		YAHOO.ARISoft.page.pageManager.triggerAction(action, options);
	}
</script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/administrator/index.php?option=<?php echo $option; ?>&task=ajax.getMessages"></script>
<div id="ariInfoMessage" class="message"<?php if (empty($infoMessage)) { ?> style="display: none;"<?php } ?>><?php echo $infoMessage; ?></div>
<table class="adminheading">
	<tr>
		<th><?php echo $processPage->getTitle(); ?></th>
	</tr>
</table>
<div class="ariJoomla15 yui-skin-sam">
<form name="adminForm" id="adminForm" action="<?php echo $processPage->actionUrl; ?>" method="post" enctype="multipart/form-data">