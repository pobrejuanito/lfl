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
		if (typeof(Ajax) != "undefined")
			new Ajax('index.php?option=<?php echo $option; ?>&task=<?php echo $processPage->executionTask; ?>$ajax|checkCategoryName&categoryId=<?php echo $categoryId; ?>&name=' + encodeURIComponent(val.getValue()), 
				{
					async : false,
					onSuccess: function(response) 
					{
						isValid = Json.evaluate(response);
					}
				}).request();

		return isValid;
	};
</script>