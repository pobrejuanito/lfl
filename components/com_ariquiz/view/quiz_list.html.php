<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
$quizList = $processPage->getVar('quizList');
$option = $processPage->getVar('option');
$Itemid = $processPage->getVar('Itemid');
$quizErr = $processPage->getVar('quizErr');

if (!empty($quizList))
{
?>
<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
<?php
	if (!empty($quizErr))
	{
		?>
		<tr><td style="color:#FF0000;">
		<?php
		$q=0;

		foreach ($quizErr as $err)
		{
			if($q == 0)
			{	
				AriWebHelper::displayResValue('Validator.MissingPrevQuiz');
				echo $err->QuizName;
			}
			else
			{
				AriWebHelper::displayResValue('Validator.MissingPrevQuizSep');
				echo $err->QuizName; 
			}
		$q++;
		}
		?>
		</td></tr>
		<?php
	}
	$prevCategoryId = -1;

	foreach ($quizList as $quiz)
	{

		/********************* iflair added ******************/
		if ($quiz->CategoryId != $prevCategoryId)
		{
		?>
		<tr>
			<th class="sectiontableheader"><?php echo empty($quiz->CategoryId) ? AriWebHelper::translateResValue('Category.Uncategory') : AriWebHelper::translateDbValue($quiz->CategoryName); ?></th>
		</tr>
		<?php
		}
		/********************* iflair end ******************/

		$link = AriJoomlaBridge::getLink('index.php?option=' . $option . '&task=quiz&quizId=' . $quiz->QuizId . '&Itemid=' . $Itemid, false, false);

?>

	<tr>

		<td>

			<a href="<?php echo $link; ?>"><?php AriWebHelper::displayDbValue($quiz->QuizName); ?></a>

		</td>

	</tr>

<?php

		$prevCategoryId = $quiz->CategoryId;

	}

?>

</table>

<?php

}

else

{

	AriWebHelper::displayResValue('Label.NotItemsFound');

}

?>