<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

	require_once dirname(__FILE__) . '/base/category_list.base.html.php';
?>
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.pageManager.subscribe('beforeAction', function(o)
	{
		if (o.action != 'bankcategory_list$ajax|delete') return ;
		
		var isDeleteQuestions = confirm('<?php AriWebHelper::displayResValue('Warning.DeleteQueFromQCategory'); ?>');
		document.getElementById('zq_deleteQuestions').value = isDeleteQuestions ? '1' : '0';
	});
</script>
<input type="hidden" id="zq_deleteQuestions" name="zq_deleteQuestions" value="0" />