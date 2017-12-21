<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$fileId = $processPage->getVar('fileId');
	$res = $processPage->getVar('res');
	$groups = $processPage->getVar('groups');
	$currentTask = $processPage->getVar('currentTask');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
?>

<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath;?>build/tabview/assets/tabview-core.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath;?>build/tabview/assets/tabview.css"/> 
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath;?>build/tabview/assets/border_tabs.css"/>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/element/element-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/tabview/tabview-min.js"></script>

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
			<td colspan="2">
				<div id="langTabContainer" class="yui-navset"> 
					<ul class="yui-nav">
						<?php
							$i = 0;
							foreach ($groups as $group)
							{
						?>
						<li<?php if ($i == 0) { ?> title="active" class="selected"<?php } ?>><a href="#resTab<?php echo $i; ?>"><em><?php echo $group; ?></em></a></li> 
						<?php
								++$i;
							}
						?> 
					</ul> 
					<div class="yui-content">
						<?php
							$i = 0;
							foreach ($groups as $group)
							{
						?> 
						<div class="yui-hidden" id="resTab<?php echo $i; ?>">
							<table class="adminlist" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
								<tr>
									<th><?php AriWebHelper::displayResValue('Label.Description'); ?></th>
									<th><?php AriWebHelper::displayResValue('Label.Message'); ?></th>
								</tr>
							<?php
								$resItemList = $res[$group];
								$rowNum = 0;
								foreach ($resItemList as $resItem)
								{
									$itemId = $resItem['id'];
							?>
								<tr class="<?php echo 'row' . ($rowNum % 2); ?>" valign="top">
									<td style="width: 20%; white-space: nowrap;">
										<input id="tbxResDescr[<?php echo $itemId; ?>]" name="tbxResDescr[<?php echo $itemId; ?>]" type="text" class="text_area" value="<?php AriWebHelper::displayDbValue($resItem['description']); ?>" style="width: 99%;" />
									</td>
									<td>
									<?php
										if ($resItem['type'] == 'WYSIWYG')
										{
											$ed =& new AriEditorWebControl('editorMes[' . $itemId . ']', array('name' => 'tbxResMessage[' . $itemId . ']'));
											$ed->setText(AriWebHelper::translateDbValue($resItem['message'], false));
											$ed->render(array('width' => '100%;', 'height' => 250, 'cols' => 60, 'rows' => 20));
										}
										else
										{
									?>
									<input id="tbxResMessage[<?php echo $itemId; ?>]" name="tbxResMessage[<?php echo $itemId; ?>]" type="text" class="text_area" value="<?php AriWebHelper::displayDbValue($resItem['message']); ?>" style="width: 99%;" />
									<?php
										}
									?>
									</td>
								</tr>
							<?php
									++$rowNum;
								}
							?>
							</table>
						</div> 
						<?php
								++$i;
							}
						?> 
					</div> 
				</div>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="fileId" value="<?php echo $fileId; ?>" />
<script type="text/javascript" language="javascript">
	var tabView = new YAHOO.widget.TabView('langTabContainer');
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == '<?php echo $currentTask; ?>$save' || pressbutton == '<?php echo $currentTask; ?>$apply')
		{
			if (!YAHOO.ARISoft.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>