<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

	$dbDate = $processPage->getVar('dbDate');
	$phpDate = $processPage->getVar('phpDate');
?>

<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<td>
				PHP Date :
			</td>
			<td>
				<?php echo $phpDate; ?>
			</td>
		</tr>
		<tr>
			<td>
				Database Date :
			</td>
			<td>
				<?php echo $dbDate; ?>
			</td>
		</tr>
	</tbody>
</table>