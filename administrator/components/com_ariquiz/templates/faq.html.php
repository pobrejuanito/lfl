<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
?>
<table class="adminheading">
	<tr>
		<th><?php AriWebHelper::displayResValue('Title.FAQ'); ?></th>
	</tr>
</table>
<table class="adminlist">
	<tr>
		<td align="left">
			<?php AriWebHelper::displayResValue('RichText.FAQ', false); ?>		
		</td>
	</tr>
</table>