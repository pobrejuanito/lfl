<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

	require_once dirname(__FILE__) . '/base/category_add.base.html.php';

	$option = $processPage->getVar('option');
	$categoryId = $processPage->getVar('categoryId');
?>

<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.categoryNameValidate = function(val)
	{
		var isValid = true;

		return isValid;
	};
</script>