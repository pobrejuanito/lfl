<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$task = $processPage->getVar('task');
	$reload = $processPage->getVar('reload');
	$hideMainMenu = $processPage->getVar('hideMainMenu');
?>
<input type="hidden" name="hidemainmenu" value="<?php echo $hideMainMenu; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" id="task" name="task" value="<?php echo $task; ?>" /> 
</form>
<?php
	if ($reload)
	{
?>
<script type="text/javascript">
    var frm = document.forms['adminForm'];
    if (frm) frm.submit();
</script>
<?php
	}
 ?>
</div>