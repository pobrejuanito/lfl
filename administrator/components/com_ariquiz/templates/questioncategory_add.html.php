<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$qCategoryId = $processPage->getVar('qCategoryId');
	$quizId = $processPage->getVar('quizId');
	$isUpdate = $processPage->getVar('isUpdate');
	$quizList = $processPage->getVar('quizList');
	$category = $processPage->getVar('category');
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>

<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbCategorySettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Quiz'); ?> :</td>
			<td align="left">
			<?php
				if (!$isUpdate)
				{
					$processPage->renderControl('lbQuizList', array('class' => 'text_area'));
				}
				else 
				{
					AriWebHelper::displayDbValue($category->Quiz->QuizName);
				} 
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxCategoryName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuestionCount'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxQuestionCount', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuestionTime'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxQuestionTime', array('class' => 'text_area')); ?></td>
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
<script type="text/javascript" language="javascript">
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'questioncategory_add$save' || pressbutton == 'questioncategory_add$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	}
</script>
<input type="hidden" name="qCategoryId" value="<?php echo $qCategoryId; ?>" />
<?php
	if ($isUpdate)
	{
?>
<input type="hidden" name="quizId" value="<?php echo $quizId; ?>" />
<?php
	}
?>