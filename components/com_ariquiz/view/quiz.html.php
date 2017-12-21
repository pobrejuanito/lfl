<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
$version = $processPage->getVar('version');
$quiz = $processPage->getVar('quiz');
$ticketId = $processPage->getVar('ticketId');
$option = 'com_ariquiz';
$task = $processPage->getVar('task');
$cssFile = $processPage->getVar('cssFile');
$canTakeQuiz = $processPage->getVar('canTakeQuiz');
$errorMessage = $processPage->getVar('errorMessage');
$Itemid = $processPage->getVar('Itemid');
$mosConfig_live_site = JURI::root(true);
$jsAdminPath = $mosConfig_live_site . '/components/' . $option . '/js/';
$jsYuiPath = $jsAdminPath . 'yui/';
$messagesLink = AriJoomlaBridge::getLink('index.php?option=' . $option . '&task=script.messages&t=' . time() . '&quizId=' . $quiz->QuizId);
$takeQuizTask = $processPage->getVar('takeQuizTask');
$tmpl = AriRequest::getParam('tmpl');
$my =& JFactory::getUser();
$showInfoArea = ($quiz->Anonymous != 'Yes' && !$my->get('id'));
?>

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/json/json-min.js"></script>
<script charset="utf-8" src="<?php echo $jsAdminPath; ?>ari.all.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo $jsAdminPath; ?>ari.quiz.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script type="text/javascript">
	YAHOO.ARISoft.page.option = '<?php echo $option; ?>';
	YAHOO.util.Get.css('<?php echo $cssFile; ?>');
</script>
<script charset="utf-8" src="<?php echo $messagesLink; ?>" type="text/javascript"></script>

<div style="margin: 4px 4px 4px 4px;">
	<form action="index.php" method="post">
	<?php
		if ($showInfoArea):
	?>
	<fieldset style="width: 400px;">
		<legend><?php AriWebHelper::displayResValue('Label.Information'); ?></legend>
		<table cellpadding="3" cellspacing="3" border="0">
			<tr>
				<td nowrap="nowrap"><?php AriWebHelper::displayResValue('Label.Name'); ?> : </td>
				<td><?php $processPage->renderControl('tbxGuestName', array('class' => 'inputbox', 'size' => 50)); ?></td>
			</tr>
			<tr>
				<td nowrap="nowrap"><?php AriWebHelper::displayResValue('Label.Email'); ?> : </td>
				<td><?php $processPage->renderControl('tbxGuestMail', array('class' => 'inputbox', 'size' => 50)); ?></td>
			</tr>
		</table>
	</fieldset>
	<?php
		endif;
	?>
	<?php /* title goes here */ //AriWebHelper::displayDbValue($quiz->QuizName); ?>
	<?php
	// get category description here
	$description = '';
	
	if ( isset($_GET['categoryId']) && $_GET['categoryId'] !== '') {
	
		$database =& JFactory::getDBO();
		$query = sprintf("SELECT Description FROM #__ariquizcategory WHERE CategoryId = ". $_GET['categoryId']);
		$database->setQuery($query);
		$database->query();
		if($database->getNumRows() === 1) {
		
			$rows = $database->loadObjectList();
			$description = $rows[0]->Description;
		}
	}
 	?>
 	
 	<img src="/images/bible-study/sos_study_title.png">
 	<?php 
 		$quiz_number = getLessonNumber($quiz->QuizName);
 	?>
 	<div class="quiz_category"><?php echo $description ?></div>
	<?php AriWebHelper::displayDbValue($quiz->Description, false); ?>
	<br /><br />
<?php

	// if this is a information page don't display the take quiz button
	if ( !$quiz_number[2] ) : 
		if ($canTakeQuiz) {
	?>	<div style="width:30%; margin: 0px auto">
		<input type="image" src="/images/bible-study/start_quiz.png" onclick="return aris.validators.alertSummaryValidators.validate();" value="<?php AriWebHelper::displayResValue('Label.Continue'); ?>" />
			</div>
	<?php
		} else if ($errorMessage) {
	?>
		<div class="ariQuizErrorMessage">
			<?php AriWebHelper::displayResValue($errorMessage); ?>
		</div>
	<?php
		}
		
		if ($tmpl) {
			?>
			<input type="hidden" name="tmpl" value="<?php echo $tmpl; ?>" />
			<?php
		}
		?>
		<input type="hidden" name="task" value="<?php echo $takeQuizTask; ?>" />
		<input type="hidden" name="quizId" value="<?php echo $quiz->QuizId; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		</form>
	</div>
	<?php
	endif;

function getLessonNumber($name) {

	$title = '';
	$pattern = '#\[(.*)\]#';
	$lesson_title = preg_replace($pattern, $replacement, $name);
	preg_match($pattern, $name, $matches);
	if ( is_numeric($matches[1])) {
		$lesson_number = "제". $matches[1] . "과";
	}
	
	if ( $matches[1] === 'i' ) {
		$info = true;
	} else {
		$info = false;
	}
	return array($lesson_number, $lesson_title, $info);
}
?>