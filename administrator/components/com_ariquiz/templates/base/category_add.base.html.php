<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$categoryTask = $processPage->getVar('categoryTask');
	$categoryId = $processPage->getVar('categoryId');
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>
<?php
	JHTML::_('behavior.mootools');
?>

<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbCategorySettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxCategoryName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.Description'); ?> :</td>
			<td align="left">
				<?php
					$processPage->renderControl('edDescription', array('width' => '100%;', 'height' => 250, 'cols' => 60, 'rows' => 20)); 
				?>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="categoryId" value="<?php echo $categoryId;?>" />
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.categoryNameValidate = function(val)
	{
		var isValid = true;

		return isValid;
	};

	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == '<?php echo $categoryTask; ?>$save' || pressbutton == '<?php echo $categoryTask; ?>$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>